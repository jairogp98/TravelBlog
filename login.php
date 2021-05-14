<?php
$message = '';
session_start();

if (isset($_SESSION['usuario'])){

  header("location:index.php");

}

if(!empty($_POST['login-email']) ||!empty($_POST['login-pass'])){

  $mail= $_POST['login-email'];
  $pass= $_POST['login-pass'];

  try {

    require_once('conexion.php');

    $sql = "SELECT * FROM usuarios WHERE email = '$mail'";

    $connect = $conexion->getConn();
    $resultado = $connect->query($sql);

    

  } catch (Exception $e) {

      $error = $e->getMessage();
      
  }

  $datos = $resultado->fetch_assoc();
  
  $hash_DB = $datos['password'];

  

  if (password_verify($pass, $hash_DB)){

    $_SESSION["usuario"] = $datos['nickname'];

     header('location:index.php');

  }else{
    
    $message = 'Invalid credentials. Please try again.';
  }
  
}

?>



<!doctype html>
<html lang="es">
  <head>
    <title>TravelBlog</title> 
    <link rel="shortcut icon" href="img/avion.png">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Personalized Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
  
    <!-- Personalized CSS -->
    <link rel="stylesheet" href="css/index.css"> 
    <link rel="stylesheet" href="css/login.css"> 
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">

    <!---------Smooth Scrolling Script--------->

    <script src = "js/smooth-scroll.polyfills.min.js"></script>

  </head>
  <body>
      <!--------------- NAVBAR---------------->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php">TravelBlog <i class="fas fa-plane-departure"></i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mr-4">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?#experiences">Experiences</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="index.php?#people">People</a>
        </li>
        <li class="nav-item">
          <a data-scroll href="index.php?#formulario" class="nav-link">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-info my-2 my-sm-0" href="#top">Log in</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" method= "get" action = "search.php">
        <input class="form-control mr-sm-2" name = "search" type="search" placeholder="Search..." aria-label="Search">
        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

    <div class = "wrapper">


    <form class = "formulario" action = "login.php" method = "POST">
        <h3>Welcome Back!</h3>
        <div class="form-group">
            
            <input type="email" class="form-control" id="login-email" aria-describedby="emailHelp" placeholder="Enter email" name ="login-email" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="login-pass" placeholder="Password" name = "login-pass" required>
        </div>
        <div class = "forgot mb-4">
        <small id="emailHelp" class="form-text text-muted error-text">                  
        <?php
          
          echo $message;

          ?>
        </small>

        <small id="emailHelp" class="form-text text-muted ml-2"> <a href="index.php?#formulario">Sign Up</a></small>
        </div>

        <button type="submit" class="btn btn-primary login-btn">Log In</button>
    </form>
    
    </div>




    <footer class = "mt-4">
      <div class ="footer-lists">
        <ul>
          <li><a href="footer.php?sel=faq">FAQ</a></li>
          <li><a href="footer.php?sel=legal">Legal</a></li>
          <li><a href="footer.php?sel=services">Services</a></li>
        </ul>
        <ul>
          <li><a href="footer.php?sel=contact">Contact</a></li>
          <li><a href="footer.php?sel=why">Why TravelBlog?</a></li>
          <li><a href="footer.php?sel=advertising">Advertising</a></li>
        </ul>
        <ul>
          <li><a href="https://www.instagram.com/Jayggo"><i class ="fab fa-instagram"></i> Instagram</a></li>
          <li><a href="https://www.twitter.com/Jairog14"><i class ="fab fa-twitter"></i> Twitter</a></li>
          <li><a href="https://www.facebook.com/jairo.gomez.5458"><i class ="fab fa-facebook"></i> Facebook</a></li>
        </ul>
      </div>
      <p class ="text-muted copy">&copy 2021 Jairo Gomez All Rights Reserved</p>
    </footer>











    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

     <!---------Smooth Scrolling Script--------->
    <script>

      var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 400
      });

    </script>
  </body>
</html>