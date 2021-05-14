<?php
      session_start();
      if (empty($_POST['txt-about'])){ // VALIDO SI VENGO DE EL FORMULARIO O DE OTRO LADO.
        
          if (empty($_GET['nickname'])){

              header("location:index.php");

          }else{

              $nickname = $_GET['nickname'];

          }
    

      }else{
        
        $nickname = $_SESSION["usuario"];
      }  
        //------------VALIDO SI LA DATA YA ESTA EN LA DB-----------------
        
        try{
            require_once('conexion.php');
            $connect = $conexion->getConn();
        
            $query = "SELECT * FROM usuarios_data WHERE nickname = '$nickname'";
            
            $resultado = $connect->query($query);
      
          }catch (Exception $e) {
      
              $error = $e->getMessage();
              echo $error;   
          } 
          
        $datos = $resultado->fetch_assoc();

        //---------------------------VALIDO SI LOS DATOS LLEGAN VACIOS----------------------------------

          //VALIDO FOTO
        if (!empty($_FILES['photo']['name'])){
            $tipo = $_FILES['photo']['type'];
            $size = $_FILES['photo']['size'];
            $nombre = $_FILES['photo']['name'];
            $abrir = fopen($_FILES['photo']['tmp_name'], 'r');
            $bin = fread($abrir, $size);
            $binarios = mysqli_escape_string($connect,$bin);

         }else{

            $tipo = $datos['tipo_img'];
            $binarios = mysqli_escape_string($connect,$datos['imagen']);
            
         }
        //VALIDO OTROS DATOS
         if (!empty ($_POST['txt-about'])){
             $temp = $_POST['txt-about'];
          $about = mysqli_real_escape_string($connect,$temp);
          $ig = $_POST['txt-ig'];
          $fb = $_POST['txt-fb'];
          $tw = $_POST['txt-tw'];
          $yt = $_POST['txt-yt'];      

         }else{
            $temp = $datos['about'];
          $about = mysqli_real_escape_string($connect,$temp);
          $ig = $datos['ig'];
          $fb = $datos['fb'];
          $tw = $datos['tw'];
          $yt = $datos['yt']; 

         }

         if (empty($datos['nickname'])){

          $nick = ' ';

         }else{

          $nick = $datos['nickname'];

         }
          
        if($nick == $nickname){
          
          try { // SI ESTA, ACTUALIZO
            require_once('conexion.php');
            $connect = $conexion->getConn();

            $query = "UPDATE usuarios_data SET imagen = '$binarios', tipo_img = '$tipo',about = '$about', ig = '$ig', fb = '$fb', tw = '$tw', yt = '$yt' WHERE nickname = '$nickname'";

            $resultado = $connect->query($query);

            $message = mysqli_error($connect);
            
          } catch (Exception $e) {
            $error = $e->getMessage();
            echo $error; 
          }

        }else{

            //---------------SI NO ESTA, LA INSERTO---------------
            try{
            require_once('conexion.php');
            $connect = $conexion->getConn();
            $query = "INSERT INTO usuarios_data (id, nickname, imagen, tipo_img, about, ig, fb, tw, yt) VALUES ('NULL', '$nickname', '$binarios', '$tipo', '$about', '$ig', '$fb', '$tw', '$yt')";
            
            $resultado = $connect->query($query);

            }catch (Exception $e) {
        
                $error = $e->getMessage();
                echo $error;   
            } 
            
        }  
        
            // Y VUELVO A BUSCAR PARA RECUPERAR LOS DATOS INSERTADOS....

            try{
              require_once('conexion.php');
              $connect = $conexion->getConn();
          
              $query = "SELECT * FROM usuarios_data WHERE nickname = '$nickname'";
              
              $resultado = $connect->query($query);
        
            }catch (Exception $e) {
        
                $error = $e->getMessage();
                echo $error;   
            } 

        $datos = $resultado->fetch_assoc();

        //---------------PARA BUSCAR Y MOSTRAR LOS TRIPS------------------------------

        try{

          $sql = "SELECT * FROM trips WHERE nickname = '$nickname'";
          
          $x= 0;
          $resultado = $connect->query($sql);
          while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
            $dato[$x] = $row;
            $x++;
          }
      
        }catch (Exception $e) {
        
          $error = $e->getMessage();
          echo $error;   
        } 
      
        //BUSCO LA FOTO
        if (!empty($dato)){
        for ($i=0; $i <count($dato) ; $i++) { 
        
          $id = $dato[$i]['id'];
          try{
      
              $sql = "SELECT * FROM trips_img WHERE id = '$id'";
              
              $x= 0;
              $resultado = $connect->query($sql);
              while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
                $foto[$i][$x] = $row;
                $x++;
              }
      
            }catch (Exception $e) {
          
            $error = $e->getMessage();
            echo $error;   
            }   
        }    
      }

      //BUSCO DATOS ADICIONALES EN USERS_DATA

      try {
        $sql = "SELECT * FROM usuarios WHERE nickname ='$nickname' ";

        $resultado = $connect->query($sql);

        $data = $resultado->fetch_assoc();

      } catch (Exception $e) {
          $error = $e->getMessage();
          echo $error;   
        }   
      

mysqli_close($connect);
 /*
    echo $about;
    echo $ig;
    echo $fb;
    echo $tw;
    echo $yt;

    ESTO MUESTRA LA FOTO O CUALQUIER DATO DE USUARIOS_DATA
            if ($resultado){

        $connect = $conexion->getConn();
        $query = "SELECT * FROM usuarios_data WHERE nickname = '$nickname'";
        $consulta = $connect->query($query);     
        $resultado = $consulta->fetch_assoc();
        ?>
        
            <img width = "260" height = "300" src="data:<?php echo $resultado['tipo_img']?>;base64,<?php echo base64_encode($resultado['imagen']);?>">

        <?php
      
        }else{
            $error = $connect->error;
            echo $error;
        }
    
    */
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

    <div class="wrapper container-fluid">

       <div class = "section-one container-fluid">
            <div class = "one-photo">
              <img src="data:<?php echo $datos['tipo_img']?>;base64,<?php echo base64_encode($datos['imagen']);?>" alt="profile-pic" style= "width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class = "one-about">
              <h1><?php echo $datos['nickname']?></h1>
              <p><?php echo $datos['about']?></p>
              <div class = "small-container">
              <small><strong><?php echo $data['country']?></strong></small>
              <small class = ""><?php echo $data['dob']?></small>
              </div>
            </div>
       </div>

       <div class = "section-two">
          <div class = "two-tittle-one">
            <h1>Trips</h1>
          </div>

          <?php 
                if (!empty($dato)){
              
              ?>
          <div class = "two-grid-one">
                <?php
                  for ($i=0; $i <count($dato) ; $i++) {
                    $obtener_foto = $foto[$i][0]; 
                ?>
                <a href= "trip.php?id=<?php echo $dato[$i]['id'];?>" class = "grid-one-content" style = "background-image: url('data:<?php echo $obtener_foto['tipo_img']?>;base64,<?php echo base64_encode($obtener_foto['imagen']);?>'); object-fit: cover; width:100%; ">    
                    <h1><?php echo $dato[$i]['ciudad'];?></h1>  
                </a> 
                <?php
                  }
                  ?>
          </div>
              <?php
                }else{

                ?>  
                  <div class ="no-trips"><h4><?php echo $nickname." does not have any trips by now."?></h4></div>
                <?php
                }
              ?>    
       </div>

       <div class="section-three">
          <div class = "three-tittle-one m-auto">
                <h1>Social Media</h1>
          </div>

          <div class = "three-social-container"> 
              <?php //---------------VALIDO QUE SI EXISTA EL REGISTRO DE RED SOCIAL------------------
                if (!empty($ig)){
                  ?>
                <div class = "social-content"><h5><i class = "fab fa-instagram"></i> <?php echo $ig?></h5></div>
              <?php
                }
              ?>
              
              <?php
                if (!empty($fb)){
                  ?>
                <div class = "social-content"><h5><i class = "fab fa-facebook"></i> <?php echo $fb?></h5></div>
              <?php
                }
              ?>

              <?php
                if (!empty($tw)){
                  ?>
                <div class = "social-content"><h5><i class = "fab fa-twitter"></i> <?php echo $tw?></h5></div>
              <?php
                }
              ?>

              <?php
                if (!empty($yt)){
                  ?>
                <div class = "social-content"><h5><i class = "fab fa-youtube"></i> <?php echo $yt?></h5></div>
              <?php
                }
              ?>

          </div>
          
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