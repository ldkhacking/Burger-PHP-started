<?php
    session_start();
    session_destroy();
    require '../admin/database.php';
    $code_secretError="";

if (!empty($_POST))
{
    if (empty($_POST['code_secret'])) {
        $code_secretError= 'Ce champ ne doit pas etre null';
    }else{
        extract($_POST);
        $db = Database::connect();
        $req = $db->prepare('SELECT * FROM admin WHERE secret = :code_secret');
        $req->execute(array(
            'code_secret' => sha1($_POST['code_secret'])));

        $existe = $req->fetch(); 
        if ($existe) {
            session_start();
            $_SESSION['id_admin'] = $existe['id_admin'];
            $_SESSION['username'] = $existe['username'];
            header('Location: index_admin.php');

        }else{
            $code_secretError= 'code secret incorrect';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BurgerCode-administrateur </title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">

      <style>
          body {
              margin:0;
              font-family: "Lato", sans-serif;
              transition: background-color .5s;
          }

          .icon-bar {
              width: 90px;
              background-color: #555;
          }

          .icon-bar a {
              display: block;
              text-align: center;
              padding: 16px;
              transition: all 0.3s ease;
              color: white;
              font-size: 36px;
          }

          .icon-bar a:hover {
              background-color: #000;
          }

          .active {
              background-color: #4CAF50 !important;
          }

          /* Style tab links */
          .tablink {
              background-color: #555;
              color: white;
              float: left;
              border: none;
              outline: none;
              cursor: pointer;
              padding: 14px 16px;
              font-size: 17px;
              width: 25%;
          }

          .tablink:hover {
              background-color: #777;
          }

          /* Style the tab content (and add height:100% for full page content) */
          .tabcontent {
              color: white;
              display: none;
              padding: 100px 20px;
              height: 100%;
          }
          .img1 {

              margin-right: -140px;
          }

          #Home {background-color: #867979;}
          #News {background-color: #e4dff2;}
          #Contact {background-color: #979ab7;}
          #About {background-color: #e8eac4;}


          .sidenav {
              height: 100%;
              width: 0;
              position: fixed;
              z-index: 1;
              top: 0;
              left: 0;
              background-color: #111;
              overflow-x: hidden;
              transition: 0.5s;
              padding-top: 60px;
          }

          .sidenav a {
              padding: 8px 8px 8px 32px;
              text-decoration: none;
              font-size: 25px;
              color: #818181;
              display: block;
              transition: 0.3s;
          }

          .sidenav a:hover {
              color: #f1f1f1;
          }

          .sidenav .closebtn {
              position: absolute;
              top: 0;
              right: 25px;
              font-size: 36px;
              margin-left: 50px;
          }

          #main {
              transition: margin-left .5s;
              padding: 16px;
          }

          @media screen and (max-height: 450px) {
              .sidenav {padding-top: 15px;}
              .sidenav a {font-size: 18px;}
          }
          .text-logo
          {
              font-family: 'Holtwood One SC', sans-serif;
              color: #e7480f;
              text-shadow: 2px 2px #ffd301;
              font-size: 50px;
              padding: 40px 0px;
              text-align: center;
          }
          .text-logo .glyphicon
          {
              color: #ffd301;
              text-shadow: 0px 0px #ffd301;
          }
      </style>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="#">Administrateur Burger shop </a>
        <a class="btn btn-primary" href="../">Connectez vous en tant qu'utilisateur </a>
      </div>
    </nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
              <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>

            <h1 class="mb-5">Vous etes un administrateur ? </h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <form action="#" method="post">
              <div class="form-row">
                <div class="col-12 col-md-9 mb-2 mb-md-0">
                  <input type="password" name="code_secret" class="form-control form-control-lg" placeholder="Entrez votre code secret...">
                    <span class="help-inline" style="color:#761c19;"><?php echo $code_secretError; ?></span>
                </div>
                <div class="col-12 col-md-3">
                  <button type="submit" name ="connection"class="btn btn-block btn-lg btn-primary">Connection!</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </header>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
