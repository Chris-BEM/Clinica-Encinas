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
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript"> //SCRIPT QUE NOS PERMITE UTILIZAR LAS API DE GOOGLE CHARTS PARA DESPLEGAR LA GRAFICA
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
         var data = google.visualization.arrayToDataTable([
         ['class Name','Medicos'],
         <?php
         $resultado = $connect->query("SELECT especialidad, count(*) as total FROM medico GROUP BY especialidad");

         while($fila = mysqli_fetch_array($resultado)) {
            echo "['".$fila['especialidad']."',".$fila['total']."],";
         }
         ?>
         ]);

        var options = {
          title: 'Especialidades Médicas en Clínica Encinas'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
   </script>
   <body>
   <img src="logo_clinica.png" alt="Clínica Encinas"><br><br>
   <!--<h1>Bienvenido!</h1><br><br>-->

   <br><div class="w3-content w3-display-container">
      <img class="mySlides w3-animate-fading" src="img/banner01.jpg" style="width:100%">
      <img class="mySlides w3-animate-fading" src="img/banner02.jpg" style="width:100%">
      <img class="mySlides w3-animate-fading" src="img/banner03.jpg" style="width:100%">
   </div>
   <p>
      Con esta página web se busca ofrecer una manera eficiente a las clínicas de poder gestionar su agenda de citas médicas y cirugías, además de contar con opciones para la administración de médicos, tales como altas y bajas o modificaciones, se incluye también una opción para reportes, siendo totalmente adaptable a los requerimientos de cada clínica.
   </p>
   <div id="piechart" style="width: 700px; height: 300px;"></div>
   <img class="img01" src="img/img01.jpg">
   <p class="text01">
      Comprometidos con tu salud.
   </p>

   <p class="text02">
      Nuestra clínica está enfocada en ofrecer los servicios con los estándares de calidad más alto, porque lo más importante es tu salud, contamos con diversos servicios para tu tranquilidad, así como médicos especialistas en diversas ramas.
   </p><br>

   <footer>
   <p>
      Encinas Mardueño Christopher Brad | Programación para Internet D15 | Ingeniería Informática | Centro Universitario de Ciencias Exactas e Ingenierías (UDG)
   </p>
   </footer>

   <script> //SCRIPT QUE NOS PERMITE HACER EL SLIDER DE IMAGENES AUTOMATICO
   var slideIndex = 0;
   carousel();

   function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > x.length) {slideIndex = 1}
         x[slideIndex-1].style.display = "block";
         setTimeout(carousel, 6000); // CAMBIA LA IMAGEN CADA 8 SEGUNDOS
   }
   </script>
   </body>
</html>