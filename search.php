<?php
session_start();
    $message = "";
    $search = $_GET['search'];
    require_once('conexion.php');
    $connect = $conexion->getConn();
    
    try { // BUSCO LOS TRIPS 
        
        $sql = "SELECT id, nickname, ciudad FROM trips WHERE pais LIKE '%$search%' OR ciudad LIKE '%$search%' OR nickname LIKE '%$search%'";
        $resultado = $connect->query($sql);

        $x = 0;
        while($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){

            $trips[$x] = $row;
            $x++;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }


   

//BUSCO LAS FOTOS DE LOS TRIPS--------------------------
    
    if (!empty($trips)){
        try{
                
            for ($i=0; $i <count($trips) ; $i++) { 
                     
                    $id = $trips[$i]['id']; // GETTING THE ID OF EACH TRIP
                    $sql= "SELECT tipo_img, imagen FROM trips_img WHERE id = '$id';";
                    $resultado = $connect->query($sql);
                    $dato = $resultado->fetch_assoc();
                    $foto[$i]['tipo_img'] = $dato['tipo_img'];
                    $foto[$i]['imagen'] = $dato['imagen'];
            }                
                      
        }catch (Exception $e) {
            
            $error = $e->getMessage();
            echo $error;   
        }
    }

    try { // SEARCHING THE PROFILES
      
      $sql = "SELECT * FROM usuarios WHERE nickname LIKE '%$search%' OR name LIKE '%$search%' OR country LIKE '%$search%'";
      $resultado = $connect->query($sql);
      $x = 0;
      while($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){

          $profiles[$x] = $row;
          $x++;
      }

  } catch (Exception $e) {
      $error = $e->getMessage();
  }

// SEARCHING THE PROFILE PICS
    
  if (isset($profiles)){

  for ($i=0; $i < count($profiles) ; $i++) {
     
        $nickname = $profiles[$i]['nickname'];
          try {     
            $sql = "SELECT * FROM usuarios_data WHERE nickname = '$nickname'";
            $resultado = $connect->query($sql);
            $resul = $resultado->fetch_assoc();
        
            $fotos_usuarios[$i]['tipo_img']= $resul['tipo_img'];
            $fotos_usuarios[$i]['imagen']= $resul['imagen'];
        
            } catch (Exception $e) {
              $error = $e->getMessage();
            }
    }
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
    <link rel="stylesheet" href="css/login.css"> 
    <link rel="stylesheet" href="css/search.css">
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

      <div class="search-container">
            <div class = "search-trips-container">
              <h1 class = "mb-3 text-white title-trips"><i class="fas fa-globe-americas"></i>  Trips</h1>
              <div class = "search-trips">
              <?php
                  if (!empty($trips)){

                       for ($i=0; $i < count($trips); $i++) { 
                          ?>
                            <a href = "trip.php?id=<?php echo $trips[$i]['id']?>" class ="search search-trips-grid" style = "background-image: url('data:<?php echo $foto[$i]['tipo_img']?>;base64,<?php echo base64_encode($foto[$i]['imagen']);?>');  object-fit: cover;">
                            
                              <h3 class = ""><?php echo $trips[$i]['ciudad'];?></h3>
                              <p class = "">By <?php echo $trips[$i]['nickname'];?></p>  
                            </a>
                        <?php
                      } 
                      

                  }else{

                      ?>
                      <h2>Nothing found</h2>
                      <?php

                  }
              ?>
              </div>
            </div>
        
            <div class = "search-profiles-container">
              <h1 class = "mb-3 text-white title-profiles"><i class="fas fa-users"></i>  Profiles</h1>
              <div class = "search-profiles">
                <?php
                  if (!empty($profiles)){

                      for ($i=0; $i < count($profiles); $i++) { 
                        ?>
                        <div class = "search search-profiles-grid">
                          <a href = "profile.php?nickname=<?php echo $profiles[$i]['nickname'];?>" class="card" style="width: 16rem;">
                              <img class="card-img-top" src="data:<?php echo $fotos_usuarios[$i]['tipo_img'];?>;base64,<?php echo base64_encode($fotos_usuarios[$i]['imagen']);?>" alt="Card image cap" style = "object-fit: cover;">
                              <div class="card-body">
                                <h5 class="card-title"><b><?php echo $profiles[$i]['nickname'];?></b></h5>
                                <p class="card-text"><?php echo $profiles[$i]['name'];?></p>
                                <p class="card-text"><?php echo $profiles[$i]['country'];?></p>
                              </div>
                          </a>
                        </div>
                      <?php
                      }
                      

                  }else{

                      
                    ?>
                    <h2>Nothing found</h2>
                    <?php

                  }   
                ?>
              </div>
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