<?php
  session_start();

  if (!isset($_SESSION["usuario"])){

    header("location: index.php");

  }

  

  if (isset($_GET['value'])){

    $value = $_GET['value'];
    if ($value == 'empty'){

      echo ("<script>alert ('ERROR: There is one picture that has not been uploaded succesfully.');</script>");
  
    }
    if ($value == 'size'){

      echo ("<script>alert ('ERROR: The pictures cannot be bigger than 2MB or 2048KB.');</script>");

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
    <link rel="stylesheet" href="css/register.css"> 
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/new-trip.css">
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

    <div class="wrapper">

      <div class = "tittle"><h1>New Trip</h1></div>
      
      <form action="trip.php" method = "post" enctype = "multipart/form-data">
        <div class = "trip-container">
          <div class = "trip-form form-group country">
              <label for="country"><h5>Which country did you travel to?</h5></label>
              <input type="text" class = "form-control" name = "country" required>
          </div>       
          <div class = "trip-form form-group city">
              <label for="city"><h5>Which city?</h5></label>
              <input type="text" class = "form-control" name = "city"
              required>
             
          </div>
          <div class = "trip-form resume form-group ">
              <label for="resume"><h5>Tell us why you traveled there, and a quick resume of your experience!</h5></label>
              <textarea name = "resume" class = "form-control" rows = "5" required></textarea>
          </div>
          <div class = "trip-form date form-group">
              <label for="calendar"><h5>When did you start your trip?</h5></label>
              <input type="date" class = "form-control" name = "calendar" required>
          </div>
          
          <div class = "trip-form photos-title d-flex mx-auto text-center" style = "margin-top: 80px;"><h4>Upload some photos, of course!</h4></div>
          <div class = "d-flex justify-content-center mb-3"><small>*Pictures cannot be bigger than 2MB or 2048KB*</small></div>
          

          <div class = "trip-form photos-container" id = "photos-container" style = "">
    
              <div class = "photo p-5 my-4">

                <label class = "text-center" for="description" style = "color: #e4e4e4;">Write a short resume of this picture</label>
                <div><textarea class = "form-control" name="description[0][description]" rows="2" required></textarea></div>
                <div class = "my-4 mx-auto" style="width: auto; height: auto;">
                    <label class="dropimage" style="">
                        <input title="Drop image or click me" type="file" name = "photo[0][photo]">
                    </label>
                </div>

              </div>
          
          </div>

       </div>
      <div class = "add-button-container d-flex justify-content-end">
        <div class = "btn btn-primary add-button" id = "add-button">Add photo</div>
      </div>
       <div class = "submit-button d-flex mb-5 justify-content-center">
            <button type="submit" class="btn btn-primary">Upload trip</button>
       </div>       
       
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