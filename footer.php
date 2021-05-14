<?php
session_start();

    $seleccion = $_GET['sel'];

    if (!isset($seleccion)){

        header("location: index.php");

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
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/footer.css">
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

      <div class = "content-selected mt-5">
              <h1>
                <?php
                   switch ($seleccion) {
                    case 'faq':
                       echo 'FAQ';
                        break;
                    case 'legal':
                       echo 'Legal';
                        break;   
                    case 'services':
                       echo 'Services';
                        break;
                    case 'contact':
                       echo 'Contact';
                        break;  
                    case 'why':
                       echo 'Why TravelBlog?';
                        break;
                    case 'advertising':
                       echo 'Advertising';
                        break;                     
                        
  
                    default:
                        # code...
                        break;
                }
                ?>
              </h1>
            <br>
            <p>
              <?php
              
                switch ($seleccion) {
                    case 'faq':
                      echo '<h3>What is TravelBlog?</h3><br>';
                      echo 'TravelBlog is exactly what their name says. A blog of travelers around the world.<br><br>';

                      echo '<h3>Do i have to pay for using TravelBlog?</h3><br>';
                      echo 'No. TravelBlog is completely free. Is a personal proyect developed by Jairo Gomez only for educational purposes.<br><br>';

                      echo '<h3>How can i take part of TravelBlog?</h3><br>';
                      echo 'You can sign up <a href = "index.php#formulario" class = "text-white">here.</a> Is totally free and fun!';

                        break;
                    case 'legal':
                      echo 'Travelblog is a personal proyect only for educational purposes designed and developed by Jairo Gomez. If you are interested of use this web site to other purposes contact: gomezjairo14@gmail.com.';
                        break;   
                    case 'services':
                      echo 'The only service provided by TravelBlog is to the people feel free of share their experiences and explore other people experiences.';
                        break;
                    case 'contact':
                      echo '<i class="fas fa-envelope"></i> gomezjairo14@gmail.com<br><br>';
                      echo '<i class = "fab fa-instagram"></i> instagram.com/Jayggo<br><br>';
                      echo '<i class = "fab fa-facebook"></i> facebook.com/jairo.gomez.5458<br><br>';
                      echo '<i class = "fab fa-twitter"></i> twitter.com/jairog14<br><br>';

                        break;  
                    case 'why':
                      echo "Because this is the everybody's blog. You can tell the world your travel experiences using TravelBlog. Make reviews, upload pictures of your trips and help others to travel safe and fun. Join NOW!";
                        break;
                    case 'advertising':
                      echo 'If you are interested on share your product in TravelBlog, contact me. Sure that i am interested: gomezjairo14@gmail.com.';
                        break;                     
                        

                    default:
                        # code...
                        break;
                }
              ?>  
            </p>

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