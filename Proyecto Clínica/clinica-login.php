<?php session_start();?>
<!DOCTYPE html>
<?php include('connect.php');?>
<html lang="esp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://i.imgur.com/vLYNKUt.png"/>
    <link rel="stylesheet" href="clinica-login.css" />
    <title>Clínica Encinas</title>
    <script defer src="clinica-login.js"></script>
    <script
   src="https://code.jquery.com/jquery-3.6.0.min.js"
   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
   crossorigin="anonymous"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<img class="logo01" src="logo_clinica.png" alt="Clínica Encinas">

<div class="container" id="container">
   <div class="form-container sign-up-container">
      <form method="post">
         <h1>Crear cuenta</h1>
         <input type="text" placeholder="Nombre" name="dato_nombre" required />
         <input type="email" placeholder="Correo" name="dato_correo" required />
         <input type="text" placeholder="Usuario" name="dato_usuario" required />
         <input type="password" placeholder="Contraseña" name="dato_password" required />
         <button class="hvr-pulse-shrink" name="signUpButton">Registrarse</button>
      </form>
      <?php
      if(array_key_exists('signUpButton', $_POST)) 
      {
         $dato_nombre = $_POST['dato_nombre'];
         $dato_correo = $_POST['dato_correo'];
         $dato_usuario = $_POST['dato_usuario'];
         $dato_password = $_POST['dato_password'];

         $post = (isset($_POST['dato_nombre']) && !empty($_POST['dato_nombre'])) &&
                 (isset($_POST['dato_correo']) && !empty($_POST['dato_correo'])) &&
                 (isset($_POST['dato_usuario']) && !empty($_POST['dato_usuario'])) &&
                 (isset($_POST['dato_password']) && !empty($_POST['dato_password']));

         if($post)
         {
            $resultado = $connect->query("SELECT usuario FROM usuario WHERE usuario = '$dato_usuario'");
            if($fila = mysqli_fetch_array($resultado))
            {
               if($fila['usuario'] == $dato_usuario)
               {
                  echo "<script> swal.fire({
                     icon: 'error',
                     title: '¡Error al crear cuenta!',
                     text: 'El nombre de usuario no se encuentra disponible',
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
            else
            {
               $connect->query("INSERT INTO usuario (nombre, correo, usuario, password, privilegios) 
               VALUES ('$dato_nombre', '$dato_correo', '$dato_usuario', '$dato_password', 1)");

                  echo "<script> swal.fire({
                     icon: 'success',
                     title: '¡Te damos la bienvenida!',
                     text: 'Su cuenta fue creada correctamente',
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
                     title: '¡Error al crear cuenta!',
                     text: 'Uno de los campos se encuentra vacio',
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
   ?>
   </div>
   <div class="form-container sign-in-container">
      <form method="post">
         <h1>Iniciar sesión</h1>
         <input type="text" placeholder="Usuario" name="dato_usuario" />
         <input type="password" placeholder="Contraseña" name="dato_password" />
         <a href="#">¿Olvidaste la contraseña?</a>
         <button type="submit" class="hvr-pulse-shrink" name="loginButton">Iniciar Sesión</button>
      </form>
      <?php
      error_reporting(0);
      if(array_key_exists('loginButton', $_POST)) 
      {
         $dato_usuario = $_POST['dato_usuario'];
         $dato_password = $_POST['dato_password'];

         $post = (isset($_POST['dato_usuario']) && !empty($_POST['dato_usuario'])) &&
                 (isset($_POST['dato_password']) && !empty($_POST['dato_password']));

         if($post)
         {
            $resultado = $connect->query("SELECT * FROM usuario WHERE usuario = '$dato_usuario' AND password = '$dato_password'");

            if($fila = mysqli_fetch_array($resultado)) 
            {
               if($fila['usuario'] === $dato_usuario && $fila['password'] === $dato_password)
               {
                  $_SESSION['usuario'] = $fila['usuario'];

                  $_SESSION['correo'] = $fila['correo'];

                  $_SESSION['nombre'] = $fila['nombre'];

                  $_SESSION['privilegios'] = $fila['privilegios'];

                  $_SESSION['acceso'] = "si";

                  header("Location: clinica-user.php"); 
                  die();
               }
            }
            else
               {
                  echo "<script> swal.fire({
                     icon: 'error',
                     title: '¡Error al iniciar sesión!',
                     text: 'Usuario o contraseña incorrectos',
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
         else
         {
            echo "<script> swal.fire({
                     icon: 'error',
                     title: '¡Error al iniciar sesión!',
                     text: 'Uno de los campos se encuentra vacio',
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
   ?>
   </div>
   <div class="overlay-container">
      <div class="overlay">
         <div class="overlay-panel overlay-left">
            <h1>¡Obtenga Más Beneficios!</h1>
            <p>Para poder agendar citas, cirugías y usar otros servicios, es necesario tener una cuenta</p>
            <button class="ghost" id="signIn">Iniciar Sesión</button>
         </div>
         <div class="overlay-panel overlay-right">
            <h1>¡Hola, Bienvenido!</h1>
            <p>Ingrese sus credenciales para iniciar sesión</p>
            <button class="ghost" id="signUp">Registrarse</button>
         </div>
      </div>
   </div>
</div>

<footer>
   <p>
      Contacto: christopher.encinas6524@alumnos.udg.mx - INNI (CUCEI)
      - Regresar a la pagina principal
      <a href="clinica-index.php">clic aqui</a>.
   </p>
</footer>
</body>