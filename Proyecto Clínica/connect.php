<!DOCTYPE html>
<html lang="esp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
   <?php
   //Datos para la conexión
   $server = "localhost";
   $db = "clinica";
   $user = "chris_em";
   $password = "signal";

   //Conexión a MySQL
   $connect = new mysqli($server, $user, $password, $db);
   if ($connect -> connect_errno) 
   {

      echo "Error al conectar a MySQL: " . $connect -> connect_error;
      exit();
   }

   //Selección de la BD
   $db_selected = mysqli_select_db($connect, $db);
   if(!$db_selected)
   {
      echo "Error al conectar a la Base de Datos: " . $db_selected -> connect_error;
      exit();
   }
   ?>
</body>
</html>