<?php
      session_start();


      if (empty($_POST['country'])){

            //significa que no viene de el formulario. recibo por GET el id del viaje a mostrar

            $id = $_GET['id'];

            if (empty($id)){

            header("location: index.php");

            }
        
            require_once('conexion.php');
            $connect = $conexion->getConn();

      }else{//VIENE DEL FORMULARIO

            $compruebo = $_FILES['photo']['name'];

            // AQUI VALIDO SI LA FOTO ES MAYOR A 2MB

            $array = $_FILES['photo']['size'];
            $var = 0;
            foreach ($array as $value) {
                $big[$var]= $value['photo'];
                $var++;
            } 

            $bandera = false;
            for($i=0;$i<count($big);$i++){

              if ($big[$i]>= 2097152){

                $bandera = true;

              }

            }
            
            $banderaDos = false; // VALIDATING IF THERE IS ANY PIC EMPTY
            for ($i=0;$i<count($compruebo);$i++){ 

              if (empty($compruebo[$i]['photo'])){
                $banderaDos = true;
              }
              
            }


            if ($banderaDos){

                header("location: new-trip.php?value=empty");
                die();

            }else{

                if ($bandera){

                  header("location: new-trip.php?value=size");
                  die();
                }

            require_once('conexion.php');
            $connect = $conexion->getConn();

            $nickname = $_SESSION['usuario'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $resume = $_POST['resume'];
            $date = $_POST['calendar'];

            //INSERTO LOS DATOS DEL TRIP
            try{

            $sql = "INSERT INTO trips (id, nickname, pais, ciudad, resumen, fecha) VALUES ('NULL', '$nickname', '$country', '$city', '$resume','$date')";
            
            $resultado = $connect->query($sql);

            }catch(Exception $e){

                $error = $e->getMessage();

            }

          //RECIBO EL ID BASADO EN EL RESUMEN

            try {
                
                $sql = "SELECT id FROM trips WHERE resumen = '$resume'";

                $resultado = $connect->query($sql);

            } catch (Exception $e) {
                $error = $e->getMessage();
            }

            $dato = $resultado->fetch_assoc();
            $id = $dato['id'];


            //OBTENGO CADA DATO DE LAS FOTOS ACCEDIENDO A LOS ARRAYS ASOCIATIVOS CORRESPONDIENTES
            $array = $_FILES['photo']['type'];
            $var = 0;
            foreach ($array as $value) {
                $tipos[$var]= $value['photo'];
                $var++;
            } 

            $array = $_FILES['photo']['size'];
            $var = 0;
            foreach ($array as $value) {
                $size[$var]= $value['photo'];
                $var++;
            } 

            $array = $_FILES['photo']['tmp_name'];
            $var = 0;
            foreach ($array as $value) {
                $tmp[$var]= $value['photo'];
                $var++;
            }

          //OBTENGO LOS BINARIOS CON LOS DATOS QUE YA CONSEGUI
            for ($i=0; $i < count($tmp) ; $i++) { 

              if (empty($tmp[$i])){// VALIDO QUE NO ESTE VACIO EL ESPACIO

                  $i++;

              }else{

                  $abrir = fopen($tmp[$i], 'r');
                  $bin = fread($abrir, $size[$i]);
                  $binarios[$i] = mysqli_escape_string($connect,$bin);

              }     

            }

          //OBTENGO LAS DESCRIPCIONES

          $y = 0;
          foreach ($_POST['description'] as $value) {
              
              $descripciones[$y]= $value['description'];
              $y++;

          }
          
          //FINALMENTE INSERTO EN LA DATA BASE
        try {
            for ($i=0; $i <count($descripciones); $i++) { 
                
               $consulta = "INSERT INTO trips_img (id, tipo_img, imagen, descripcion) VALUES ('$id', '$tipos[$i]', '$binarios[$i]','$descripciones[$i]');";

               $connect->query($consulta);
              }
        } catch (Exception $e) {
            $error = $e->getMessage();
          }
        
        }
      
    }
    //VALIDATING THE TRIP CONTENT TO BE SHOWN
    
    try{

        $sql = "SELECT * FROM trips WHERE id = '$id'";

        $resultado = $connect->query($sql);
        

    }catch (Exception $e) {
      
              $error = $e->getMessage();
              echo $error;   
          } 

    

    $data = $resultado->fetch_assoc();

    $nickname = $data['nickname'];
    $pais = $data['pais'];
    $ciudad = $data['ciudad'];
    $fecha = $data['fecha'];
    $resumen = $data['resumen'];


    //SHOWING THE PICTURES


    try{
  
      $x=0;
      $query = "SELECT * FROM trips_img WHERE id = '$id'";
      
      $resultado = $connect->query($query);
      while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
        $datos[$x] = $row;
        $x++;
      }
      

    }catch (Exception $e) {

        $error = $e->getMessage();
        echo $error;   
    } 

    

    
    mysqli_close($connect);

    
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
    <link rel="stylesheet" href="css/register.css"> 
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/new-trip.css">
    <link rel="stylesheet" href="css/trip.css">
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
          <a class="nav-link" href="index.php#experiences">Experiences</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="index.php#people">People</a>
        </li>
          <?php       

              if (!isset($_SESSION["usuario"])){
                ?>
              <li class="nav-item">
              <a data-scroll href="#formulario" class="nav-link">Sign up</a>
              </li>
                <?php
              }

          ?>
        <li class="nav-item dropdown">
        
          <?php
              
              if (isset($_SESSION["usuario"])){

                ?>
                <a class="btn btn-info my-2 my-sm-0 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                  echo $_SESSION["usuario"];
                ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="profile.php?nickname=<?php echo $_SESSION['usuario']?>">My Profile</a>
                  <a class="dropdown-item" href="my-trips.php">My trips</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="edit-profile.php">Edit profile</a>
                  <a class="dropdown-item" href="sign-out.php">Sign out</a>
                </div>
                <?php
                

              }else{
                ?>
                  <a class = "btn btn-info my-2 my-sm-0" href="login.php">
                    Log in
                  </a>
               <?php
              }
                ?>

          </a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action = "search.php" method = "get">
        <input class="form-control mr-sm-2" name = "search" type="search" placeholder="Search..." aria-label="Search">
        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

    <div class="wrapper">

        <div class = "presentation-container" style = "background-image: url('data:<?php echo $datos[0]['tipo_img']?>;base64,<?php echo base64_encode($datos[0]['imagen']);?>')">
            <div class = "background-container">
              <div class = "date"><?php echo $fecha?></div>
              <div class = "country"><h1 class = "ml-5"><strong><?php echo $pais?></strong></h1></div>
              <div class = "by-who"><strong>
                  <?php echo "By ".$nickname;?>
              </strong></div>
            </div>
        </div>

        <div class = "description-container my-5">
            <h1 class = "text-white"><?php echo $ciudad?></h1>
            <p class = "text-justify"><?php echo $resumen?></p>
        </div>

        <div class = "photos-container">

            <?php // MUESTRO LAS FOTOS 
              for ($i=0; $i < count($datos); $i++) { 
                
                ?>
                <div class = "photo p-4 my-4">
                    <div class = "my-4 mx-auto img-container">
                        <img src="data:<?php echo $datos[$i]['tipo_img']?>;base64,<?php echo base64_encode($datos[$i]['imagen']);?>"alt="trip-pic">
                    </div>
                    <p class = "photo-description text-center"><?php echo $datos[$i]['descripcion'];?></p>
                </div>

                <?php

              }
            
            ?>
 


        </div>





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






        <!-- Javascript for the upload image frame -->
    <script>
            document.addEventListener("DOMContentLoaded", function() {
    [].forEach.call(document.querySelectorAll('.dropimage'), function(img){
      img.onchange = function(e){
        var inputfile = this, reader = new FileReader();
        reader.onloadend = function(){
          inputfile.style['background-image'] = 'url('+reader.result+')';
        }
        reader.readAsDataURL(e.target.files[0]);
      }
    });
  });
    </script>

    <script src = "js/new-trip.js"></script>
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