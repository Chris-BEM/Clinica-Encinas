<?php session_start(); //INICIA LA SESION
if(empty($_SESSION['acceso']) || $_SESSION['acceso'] == '') //VALIDA QUE EXISTA UNA SESION, EN CASO DE QUE NO SE HAYA LOGUEADO NINGUN USUARIO, VA REDIRIGIR AL USUARIO A LA PAGINA DE INICIO DE SESION
{
   header("Location: clinica-login.php"); 
   die();
}
?>
<?php /*VALIDA EL USUARIO QUE INICIO LA SESION SI ES ADMINISTRADOR O USUARIO, MOSTRANDO EL NAVBAR CORRESPONDIENTE*/
if($_SESSION['privilegios'] == 0)
{
   include 'header-admin.php'; //SE MUESTRA EL NAVBAR CON LAS OPCIONES DEL ADMINISTRADOR
}
else
{
   include 'header-user.php'; //SE MUESTRA EL NAVBAR CON LAS OPCIONES DEL USUARIO
}
?>
<?php include('connect.php');?> <!--CONEXION A LA BASE DE DATOS-->

<!DOCTYPE html>
<html lang="esp">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="clinica-appointment.css">
   <script
   src="https://code.jquery.com/jquery-3.6.0.min.js"
   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
   crossorigin="anonymous"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
   <body>
      <?php
      if($_SESSION['privilegios'] == 0) //SI EL USUARIO QUE INICIO SESION ES ADMINISTRADOR, MUESTRA EL MENSAJE CORRESPONDIENTE EN EL DIV
      {
         echo '<div class="container">Nombre: '. $_SESSION['nombre'] .' Usuario: ' . $_SESSION['usuario'] . '
               <div class="overlay">
                  <div class="textOverlay">Tipo de cuenta: administrador</div>
               </div>
            </div>';
      }
      else // EN CAMBIO SI EL USUARIO QUE INICIO SESION ES USUARIO, MUESTRA EL MENSAJE CORRESPONDIENTE EN EL DIV
      {
         echo '<div class="container">Nombre: '. $_SESSION['nombre'] .' Usuario: ' . $_SESSION['usuario'] . '
               <div class="overlay">
                  <div class="textOverlay">Tipo de cuenta: usuario</div>
               </div>
            </div>';
      }
      ?>
      <img src="logo_clinica.png" alt="Clínica Encinas"><br><br>
      <div class="testbox">
      <form method="post">
        <div class="banner">
          <h1>Agendar cirugía</h1>
        </div>
        <div class="colums">
          <div class="item">
            <label for="nombre">Nombre:</label>
            <input id="nombre" type="text" name="dato_nombre" required/>
          </div>
          <div class="item">
            <label for="correo">Correo:</label>
            <input id="correo" type="email" name="dato_correo" required/>
          </div>
          <div class="item">
            <label for="celular">Celular:</label>
            <input id="celular" type="tel" name="dato_celular" required/>
          </div>
          <div class="item">
            <label for="medico">Médico:</label>
            <select name="dato_especialidad">
               <option value="" disabled selected>Seleccione una opción</option>
               <?php
               $resultado = $connect->query("SELECT nombre, especialidad FROM medico WHERE especialidad = 'Cirugía'");
               while($fila = mysqli_fetch_array($resultado)) 
               {
                  echo "<option value='".$fila['nombre']."''>".$fila['nombre']."".' | '."".$fila['especialidad']."</option>";
               }
               ?>
            </select>
          </div>
          <div class="item">
            <label for="sala">Sala de quirófano:</label>
            <select name="dato_sala" required>
              <option value="" disabled selected>Seleccione una opción</option>
              <option value="Sala 1">Sala 1</option>
              <option value="Sala 2">Sala 2</option>
              <option value="Sala 3">Sala 3</option>
              <option value="Sala 4">Sala 4</option>
              <option value="Sala 5">Sala 5</option>
              <option value="Sala 6">Sala 6</option>
            </select>
          </div>
          <div class="item">
            <label for="fecha">Fecha:</label>
            <input type="date" name="dato_fecha" required>
          </div>
          <div class="item">
            <label for="hora">Hora:</label>
            <select name="dato_hora" required>
              <option value="" disabled selected>Seleccione una hora</option>
              <option value="08:00">08:00</option>
              <option value="10:00">10:00</option>
              <option value="12:00">12:00</option>
              <option value="14:00">14:00</option>
              <option value="16:00">16:00</option>
              <option value="18:00">18:00</option>
            </select>
          </div>
        </div>
        <div class="btn-block">
          <button type="submit" class="hvr-pulse-shrink" name="appointmentButton">Agendar</button>
        </div>
        <?php
         error_reporting(0);
         if(array_key_exists('appointmentButton', $_POST))
         {
            $dato_nombre = $_POST['dato_nombre'];
            $dato_correo = $_POST['dato_correo'];
            $dato_celular = $_POST['dato_celular'];
            $dato_seleccion = $_POST['dato_especialidad'];
            $dato_sala = $_POST['dato_sala'];
            $dato_fecha = $_POST['dato_fecha'];
            $dato_hora = $_POST['dato_hora'];

            $resultado = $connect->query("SELECT fecha, hora, sala FROM cirugia WHERE fecha = '$dato_fecha' AND hora = '$dato_hora' AND sala = '$dato_sala'");
            if($fila = mysqli_fetch_array($resultado))
            {
               if($fila['fecha'] == $dato_fecha && $fila['hora'] == $dato_hora && $fila['sala'] == $dato_sala)
               {
                  echo "<script> swal.fire({
                     icon: 'error',
                     title: '¡Error al agendar la cirugía!',
                     text: 'La sala en la fecha y horario seleccionado no se encuentra disponible',
                     position: 'center',
                     toast: true,
                     allowOutsideClick: false,
                     allowEnterKey: true,
                     type: 'error',
                     });</script>";
               }
            }
            else
            {
               $connect->query("INSERT INTO cirugia (nombre, correo, celular, medico, sala, fecha, hora, usuario, tipo) VALUES ('$dato_nombre', '$dato_correo', '$dato_celular', '$dato_seleccion', '$dato_sala', '$dato_fecha', '$dato_hora', '".$_SESSION['usuario']."', 'Cirugía')");
               echo "<script> swal.fire({
                     icon: 'success',
                     title: '¡Confirmado!',
                     text: 'Su cirugía fue registrada correctamente',
                     showConfirmButton: false,
                     position: 'center',
                     toast: true,
                     allowOutsideClick: false,
                     allowEnterKey: true,
                     timer: 2500
                     });</script>";
            }   
         }
            ?>
      </form>
    </div>
   </body>
</html>