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
   <link rel="stylesheet" href="clinica-view-appointment.css">
</head>
<body>
  <?php
  if($_SESSION['privilegios'] == 0) //SI EL USUARIO QUE INICIO SESION ES ADMINISTRADOR, MUESTRA EL MENSAJE CORRESPONDIENTE EN EL DIV
  {
    echo '<div class="container">Nombre: '. $_SESSION['nombre'] .' Usuario: ' . $_SESSION['usuario'] . '
            <div class="overlay">
              <div class="textOverlay">Administrador</div>
            </div>
          </div>';
  }
  else // EN CAMBIO SI EL USUARIO QUE INICIO SESION ES USUARIO, MUESTRA EL MENSAJE CORRESPONDIENTE EN EL DIV
  {
    echo '<div class="container">Nombre: '. $_SESSION['nombre'] .' Usuario: ' . $_SESSION['usuario'] . '
            <div class="overlay">
              <div class="textOverlay">Usuario</div>
            </div>
          </div>';
  }
  ?>
  <img src="logo_clinica.png" alt="Clínica Encinas"><br><br>
  <?php
  //$resultado = $connect->query("SELECT * FROM cita WHERE usuario = '".$_SESSION['usuario']."'");
  $resultado = $connect->query("SELECT * FROM cita WHERE usuario = '{$_SESSION['usuario']}' UNION ALL SELECT * FROM cirugia WHERE usuario = '{$_SESSION['usuario']}'");
  
   echo '<div class="table-wrapper">';
   echo '<table class="fl-table">';
   echo '<thead>';
   echo '<tr>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Fecha de la consulta</th>
            <th>Hora de la consulta</th>
            <th>Tipo de consulta</th>
            <th>Sala</th>
        </tr>';
   echo '</thead>';
   while($fila = mysqli_fetch_array($resultado)) 
   {
      $dato_paciente = $fila['nombre'];
      $dato_medico = $fila['medico'];
      $dato_fecha = $fila['fecha'];
      $dato_hora = $fila['hora'];
      $dato_tipo = $fila['tipo'];
      $dato_sala = $fila['sala'];

      echo '<tr>';
      echo '<td>'.$dato_paciente.'</td>';
      echo '<td>'.$dato_medico.'</td>';
      echo '<td>'.$dato_fecha.'</td>';
      echo '<td>'.$dato_hora.'</td>';
      echo '<td>'.$dato_tipo.'</td>';
      echo '<td>'.$dato_sala.'</td>';
      echo '</tr>';
   }
   echo '</table>';
   echo '</div>' . '<br>' . '<br>';
  ?>
</body>
</html>