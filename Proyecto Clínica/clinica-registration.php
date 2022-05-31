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
   <link rel="shortcut icon" href="https://i.imgur.com/vLYNKUt.png"/>
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
          <h1>Registrar Nuevo Médico</h1>
        </div>
        <div class="colums">
          <div class="item">
            <label for="lname">Nombre<span>*</span></label>
            <input id="lname" type="text" name="dato_nombre" required/>
          </div>
          <div class="item">
            <label for="address1">Especialidad<span>*</span></label>
            <input id="address1" type="text" name="dato_especialidad" required/>
          </div>
          <div class="item">
            <label for="eaddress">Correo<span>*</span></label>
            <input id="eaddress" type="email" name="dato_correo" required/>
          </div>
          <div class="item">
            <label for="phone">Celular<span>*</span></label>
            <input id="phone" type="text" name="dato_celular" required/>
          </div>
        </div>
        <div class="btn-block">
          <button type="submit" class="hvr-pulse-shrink" name="registrationButton">Registrar</button>
        </div>
        <?php
         error_reporting(0);
         if(array_key_exists('registrationButton', $_POST)) 
         {
         $dato_nombre = $_POST['dato_nombre'];
         $dato_especialidad = $_POST['dato_especialidad'];
         $dato_correo = $_POST['dato_correo'];
         $dato_celular = $_POST['dato_celular'];

         $post = (isset($_POST['dato_nombre']) && !empty($_POST['dato_nombre'])) &&
                 (isset($_POST['dato_especialidad']) && !empty($_POST['dato_especialidad'])) &&
                 (isset($_POST['dato_correo']) && !empty($_POST['dato_correo'])) &&
                 (isset($_POST['dato_celular']) && !empty($_POST['dato_celular']));

         if($post)
         {
            $resultado = $connect->query("SELECT * FROM medico");
            if($fila = mysqli_fetch_array($resultado))
            {
               if($fila['correo'] == $dato_correo)
               {
                  echo "<script> swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'El correo ya se encuentra registrado',
                  showConfirmButton: false,
                  position: 'center',
                  toast: true,
                  allowOutsideClick: false,
                  allowEnterKey: true,
                  timer: 3500
                  });</script>";
                  
               }
               else
               {
                  $connect->query("INSERT INTO medico (nombre, especialidad, correo, celular, eliminado) VALUES ('$dato_nombre', '$dato_especialidad', '$dato_correo', '$dato_celular', 0)");
                  echo "<script> swal.fire({
                  icon: 'success',
                  title: '¡Confirmación!',
                  text: 'El médico fue registrado correctamente',
                  showConfirmButton: false,
                  position: 'center',
                  toast: true,
                  allowOutsideClick: false,
                  allowEnterKey: true,
                  timer: 3500
                  });</script>";
               }
            }
            else
               {
                 echo "<script> swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'El médico no se encuentra en el sistema',
                  position: 'center',
                  toast: true,
                  allowOutsideClick: false,
                  allowEnterKey: true,
                  confirmButtonText: 'Aceptar',
                  confirmButtonColor: '#9ca683',
                  type: 'error',
                  });</script>";
               }
         }
      }
         ?>
      </form>
    </div>
   </body>
</html>