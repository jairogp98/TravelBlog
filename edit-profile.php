<?php
  session_start();
  if (!isset($_SESSION["usuario"])){

    header("location:index.php");

  }

  $nickname = $_SESSION["usuario"];

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
    
    if (!empty($datos['nickname'])){

      if($datos['nickname'] == $nickname){
        
        $imagen = $datos['imagen'];
        $tipo_imagen = $datos['tipo_img']; 
        $about = $datos['about'];
        $ig = $datos['ig'];
        $fb = $datos['fb'];
        $tw = $datos['tw'];
        $yt = $datos['yt'];
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
    
    <link rel="stylesheet" href="css/edit-profile.css"> 
    <link rel="stylesheet" href="css/index.css"> 
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

    <div class = "wrapper">
     <form class = "edit-profile-form" action= "profile.php" method= "post" enctype = "multipart/form-data">
     
        <div class = "photo-container">
              <div><h3>Picture</h3></div>

              <?php
              
              if (isset($imagen)){
                ?>
                <div class = "mt-4" style="width: 300px; height: 350px;">
                  <label class="dropimage m-auto" style="max-width: 300px; height: 100%; background-image: url('data:<?php echo $tipo_imagen?>;base64,<?php echo base64_encode($imagen);?>');">
                      <input title="Drop image or click me" type="file" name = "photo">
                  </label>
                </div>

              <?php
              }else{
                ?>
                <div class = "mt-4" style="width: 300px; height: 350px;">
                  <label class="dropimage" style="width: 300px; height: 350px;">
                    <input title="Drop image or click me" type="file" name = "photo">
                  </label>
                </div>
                
              <?php
              }
              ?>
        </div>

        <div class="about-container">
          <div class = "about-tittle">
              <h3>Tell the people about you</h3>
          </div>        
          <div class = "about-txt">
            <textarea class="form-control" id="txt-about" name = "txt-about" rows="6" required><?php
             if (isset($about)){
              echo $about;
             }
            ?></textarea>
          </div>
        </div>

        <div class="social-container">
            <div class = "social-tittle">
              <h3>Social Media</h3>
            </div>
            <div class = "mt-3">
              <div class="form-group">
                <label for="txt-ig"><i class = "fab fa-instagram"></i> Instagram</label>
                <input type="text" class="form-control" name = "txt-ig" id="txt-ig" value =<?php
                  if (!empty($ig)){
                    echo $ig;
                  }
                ?>>
              </div>
              <div class="form-group">
                <label for="txt-fb"><i class = "fab fa-facebook"></i> Facebook</label>
                <input type="text" class="form-control" name = "txt-fb" id="txt-fb" value=<?php
                  if (!empty($fb)){
                    echo $fb;
                  }
                ?>>
              </div>
              <div class="form-group">
                <label for="txt-tw"><i class = "fab fa-twitter"></i> Twitter</label>
                <input type="text" class="form-control" name = "txt-tw" id="txt-tw" value=<?php
                  if (!empty($tw)){
                    echo $tw;
                  }
                ?>>
              </div>
              <div class="form-group">
                <label for="txt-yt"><i class = "fab fa-youtube"></i> Youtube</label>
                <input type="text" class="form-control" name = "txt-yt" id="txt-yt" value=<?php
                  if (!empty($yt)){
                    echo $yt;
                  }
                ?>>
              </div>
            </div>
          </div>
          <div class = "submit-button">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
         </form>
   </div>



    <?php
                /* PARA PEDIR ALGUN USUARIO EN LA DB
          try {

            require_once('conexion.php');

            $sql = "SELECT * FROM usuarios WHERE id = 2";
            
            $connect = $conexion->getConn();
            $resultado = $connect->query($sql);
        } catch (Exception $e) {

            $error = $e->getMessage();
            
        }

          $datos = $resultado->fetch_assoc();

          echo "Mail: ".$datos["email"];
          echo "<br>";
          echo "El pass es: ".$datos["password"];
          echo "<br>";
          echo "Nombre es: ".$datos["name"];
          echo "<br>";
          echo "Nickname es: ".$datos["nickname"];
          echo "<br>";
          echo "Fecha de nacimiento es: ".$datos["dob"];

          */
      ?>

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
      <p class ="text-muted">&copy 2021 Jairo Gomez All Rights Reserved</p>
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