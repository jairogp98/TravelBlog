<?php
        $message= "";
        
        if(!empty($_POST['form-email']) && !empty($_POST['form-pass']) && !empty($_POST['form-name']) && !empty($_POST['form-lastname']) && !empty($_POST['form-country'])&& !empty($_POST['form-nickname']) && !empty($_POST['form-dob'])){

          $mail= $_POST['form-email'];
          $pass= $_POST['form-pass'];
          $name= $_POST['form-name']." ".$_POST['form-lastname'];
          $country= $_POST['form-country'];
          $nickname= $_POST['form-nickname'];
          $dob= $_POST['form-dob'];

          try {

            require_once('conexion.php');

            $sql_one = "SELECT * FROM usuarios WHERE email = '$mail' OR nickname = '$nickname'";

            $connect = $conexion->getConn();
            $resultado = $connect->query($sql_one);

  
          } catch (Exception $e) {
    
              $error = $e->getMessage();
              
          }

          $dato = $resultado->fetch_assoc();


          

          function validar($dato_DB,$dato_form){

            if ($dato_DB == $dato_form){

              return false;

            }else{

              return true;

            }

          }

          if (isset($dato['nickname'])){

            $nick = $dato['nickname'];
            $correo = $dato['email'];
          }else{
            $nick = ' ';
            $correo = ' ';
          }

          $hash = password_hash($pass, PASSWORD_DEFAULT);
         
          if (validar($nick,$nickname) && validar($correo,$mail)){

            try {

              

              $sql_two = "INSERT INTO usuarios (nickname,email,password,name,country,dob) VALUES ('$nickname', '$mail', '$hash', '$name', '$country','$dob')";
    
              $connect_two = $conexion->getConn();
              $resultado_two = $connect_two->query($sql_two);

            } catch (Exception $e) {

                $error = $e->getMessage();
            }

            if ($resultado_two){
              
              session_start();
              $_SESSION["usuario"] = $nickname;
              header ("location:edit-profile.php");

            }

          }else{

            $message = "There is already a registered user with this email or nickname.";

        }

          
        }

      //----------------------------PARA MOSTRAR LOS TRIPS-------------------------  

      try{
        require_once('conexion.php');
        $connect = $conexion->getConn();
        $sql = "SELECT * FROM trips"; //BUSCO LOS TRIPS  
        $x= 0;
        $resultado = $connect->query($sql);
        session_start();
        if (isset($_SESSION["usuario"])){

          $nick = $_SESSION["usuario"];
        }else{

          $nick = " ";

        }
        
        $dato = array();
        while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){

          $temp[$x] = $row;
          if ($temp[$x]['nickname'] != $nick){ // VALIDO QUE NO SE MUESTREN TRIPS DE LA PERSONA LOGUEADA ACTUALMENTE.
            array_push($dato, $temp[$x]);
          }
          $x++;
        }
    
      }catch (Exception $e) {
      
        $error = $e->getMessage();
        echo $error;   
      } 



       //BUSCO LA FOTO-------------------
    if (!empty($dato)){
      for ($i=0; $i <count($dato) ; $i++) { 
      
        $id = $dato[$i]['id'];
        try{

            $sql = "SELECT * FROM trips_img WHERE id = '$id'";
            
            $x= 0;
            $resultado = $connect->query($sql);
            while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
              $foto[$i][$x] = $row;//[IDTRIP][NUMERO DE FOTO]
              $x++;
          }

          }catch (Exception $e) {
        
          $error = $e->getMessage();
          echo $error;   
          }   
      }
    }

    //BUSCO LOS PERFILES

      
        
        try {

          $sql = "SELECT * FROM usuarios_data";
          
          $resultado = $connect->query($sql);
          $x=0;
          $profiles = array();

          while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){

            $temp[$x] = $row;

            if ($temp[$x]['nickname']!= $nick){ // VALIDO QUE NO SE MUESTREN DEL MISMO USUARIO QUE ESTA LOGUEADO EN EL MOMENTO

              array_push($profiles, $row);

            }
            $x++;
        }
           
        } catch (Exception $e) {    
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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Personalized Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
  
    <!-- Personalized CSS -->
    <link rel="stylesheet" href="css/index.css"> 
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">

    <!---------Smooth Scrolling Script--------->

    <script src = "js/smooth-scroll.polyfills.min.js"></script>

  </head>
  <body>
      <!--------------- NAVBAR---------------->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">TravelBlog <i class="fas fa-plane-departure"></i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mr-4">
        <li class="nav-item">
          <a class="nav-link" href="#top">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#experiences">Experiences</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="#people">People</a>
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
  <!-----------FIRST CONTAINER-------------->

    <div class = "first-container">

      <?php
        if (!isset($_SESSION["usuario"])){
      ?>
      <h1>Welcome to TravelBlog!</h1>
      <p>This is the everybody's blog. You can tell the world your travel experiences using TravelBlog. Make reviews, upload pictures of your trips and help others to travel safe and fun!</p>
      <div><a href="#formulario" class = "btn btn-outline-light">Join now!</a></div>
      <?php    
        }else{
          ?>
          <div class = "user-container">
          <h1>
          <?php echo "Welcome back, ".$_SESSION["usuario"];?>
          </h1>
          <div class = ""><a href="sign-out.php" class = "btn btn-outline-light">
          <?php echo "Not ".$_SESSION["usuario"]."? Sign out."?>
          </a></div>
          </div>
      <?php
        }
      ?>         
      

      

    </div>
  <!-----------SECOND CONTAINER-------------->
    <div class = "second-container" id = "experiences">
      <h1 class = "text-center">Explore people's trips</h1>
      <div class = "content-container">
        
        <?php
        $rand= array();
          for ($i=0; $i < 4 ; $i++) { 
            $random = rand(0,(count($dato)-1));// -1 PORQUE EMPIEZA DESDE EL 0 EL ARRAY.

            // ALGORITMO QUE DECIDE ALEATORIAMENTE QUE TRIPS SE VAN A MOSTRAR.

            if (!isset($rand)){ //VALIDO SI LA ARRAY ES IGUAL A NULL PARA PUSHEARLE EL PRIMER VALOR

              array_push($rand, $random);

            }else{

              if (in_array($random, $rand)){ // EVALUO SI EL ARRAY CONTIENE EL RANDOM ASIGNADO

                do{

                  $random= rand(0,(count($dato)-1));

                }while(in_array($random, $rand)); // GENERO UN RANDOM HASTA QUE NO SEA IGUAL A ALGUNO DEL ARRAY

                array_push($rand, $random);

              }else{

                array_push($rand, $random);// SI NO LO CONTIENE LO PUSHEO.

              }

            }
          }

          for ($i=0; $i < 4; $i++) { //MUESTRO SOLO 4 TRIPS.
            
            $obtener_foto = $foto[$rand[$i]][0]; 
        ?>
        <a href="trip.php?id=<?php echo $dato[$rand[$i]]['id']?>" class = "content" style = "background-image: url('data:<?php echo $obtener_foto['tipo_img']?>;base64,<?php echo base64_encode($obtener_foto['imagen']);?>')">        
          <h1><?php echo $dato[$rand[$i]]['ciudad'];?></h1>
          <p class = "">By <?php echo $dato[$rand[$i]]['nickname'];?></p>  
        </a>
        <?php
          } 
        ?>        
      </div>
    </div>
    <!-----------FOURTH CONTAINER-------------->
    <div class="fourth-container" id ="people">
      <h1>Who are us?</h1>
      <p class = "m-auto text-center">We are a bunch of travel-lovers who believe in the importance of share your experiences with another travel-lovers.</p>
      <div class ="cards">
        <?php
            $rand= array();
            for ($i=0; $i < 3 ; $i++) { 
              $random = rand(0,(count($profiles)-1));// -1 PORQUE EMPIEZA DESDE EL 0 EL ARRAY.
  
              // ALGORITMO QUE DECIDE ALEATORIAMENTE QUE PERFILES SE VAN A MOSTRAR.
  
              if (!isset($rand)){ //VALIDO SI EL ARRAY ES IGUAL A NULL PARA PUSHEARLE EL PRIMER VALOR
  
                array_push($rand, $random);
  
              }else{
  
                if (in_array($random, $rand)){ // EVALUO SI EL ARRAY CONTIENE EL RANDOM ASIGNADO
  
                  do{
  
                    $random= rand(0,(count($profiles)-1));
  
                  }while(in_array($random, $rand)); // GENERO UN RANDOM HASTA QUE NO SEA IGUAL A ALGUNO DEL ARRAY
  
                  array_push($rand, $random);
  
                }else{
  
                  array_push($rand, $random);// SI NO LO CONTIENE LO PUSHEO.
  
                }
  
              }
            }

            for ($i=0; $i < 3 ; $i++) { 
        ?>
        <a href = "profile.php?nickname=<?php echo $profiles[$rand[$i]]['nickname'];?>" class="card mt-5" style="width: 16rem;">
          <img class="card-img-top" src="data:<?php echo $profiles[$rand[$i]]['tipo_img']?>;base64,<?php echo base64_encode($profiles[$rand[$i]]['imagen']);?>" alt="Card image cap" style = " object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><b><?php echo $profiles[$rand[$i]]['nickname'];?></b></h5>
            <p class="card-text"><?php echo $profiles[$rand[$i]]['about'];?></p>
          </div>
        </a>
         <?php
          }
         ?>     
      </div> 
    </div>



    <!-----------FIFTH CONTAINER-------------->
    <?php
    
      if (!isset($_SESSION["usuario"])){
      ?>

      <div class="fifth-container" id = "formulario"> 
          <h1 class = "text-center">You can be part of us!</h1>
          <div class = "form-container">
            <h5 class = "m-auto text-center">Create an user, upload your own travel experiences and tell other people what you have lived around the world!</h5>
            <form class = "my-5 w-50 mx-auto" action = "index.php#formulario" method ="post">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <input type="email" class="form-control" id="form-email" name = "form-email" placeholder="Email" required>
                </div>
                <div class="form-group col-md-6">
                  <input type="password" class="form-control" id="form-pass" name = "form-pass" placeholder="Password" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <input type="text" class="form-control" id="form-name" name = "form-name" placeholder="Name" required>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" class="form-control" id="form-lastname" name ="form-lastname" placeholder="Last Name" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <input type="text" class="form-control" id="form-country" name = "form-country" placeholder= "Country" required>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" class="form-control" id="form-nickname"  name = "form-nickname" placeholder= "Nickname" required>
                </div>
              </div>
              <div class="form-group">
                  <label for="date" class= "col-form-label">Date of Birth:</label>
                  <div class="col-6`">
                    <input class="form-control" type="date" value="" id="form-dob" name = "form-dob" required>
                  </div>
                </div>

              <button type="submit" class="btn btn-primary">Sign up!</button>
              <div class = "">
              <p style = "color: red;">
                <?php
                  echo $message;
                ?>
              </p>
              </div>
            </form>
        </div>
      </div>

      <?php
      }
    
    ?>



  </div>


  <footer class = "mt-5">
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