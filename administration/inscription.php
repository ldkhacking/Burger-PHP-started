<?php
require '../admin/database.php';
$prenomError = $nomError=$emailError=$loginError = $passwordError=$ConfirmpasswordError = $pwdError = $logError=$log= "";
$info="Inscription";
$erreur="Connexion";
if(session_start()){
    $username = $_SESSION['username'];
    $id_admin = $_SESSION['id_admin'];
}else{
    header("Location: index.php");
}
$bd = database::connect();
$statement1 = $bd->query("SELECT * FROM `admin` WHERE username='$username'" );
$admin = $statement1->fetch();

if(isset($_POST['register']))
{
    $db = Database::connect();
    extract($_POST);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $Confirmpassword = $_POST['Confirmpassword'];
    $errors = 0;

    //Verification du nom
    if(!preg_match('/^[a-z A-Z]+$/',$nom) || empty($nom)){
        $nomError = "Nom invalide (alphanumerique)";
        $errors ++;

        //echo $errors['nom'];
    }

    //Verification du prénom
    if(!preg_match('/^[a-z A-Z]+$/',$prenom) || empty($prenom)){
        $prenomError = "Prenom invalide (alphanumerique)";
        $errors ++;
        // echo $errors['prenom'];
    }

    //Verification du login
    if(!preg_match('/^[a-z A-Z0-9_]+$/',$login)){
        $loginError = " Pseudo invalide (alphanumerique)";
        $errors ++;
        //echo $errors['username1'];
    }
    else{


        $req = $db->prepare('SELECT login FROM users WHERE login = ?');
        $req->execute(array($login));
        $user = $req->fetch();
        if($user){
            $loginError = ' Ce login existe déja';
            $errors ++;
            //echo $errors['username1'];
        }

    }


    //Verification d' email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailError= "Format d'email invalide";
        $errors ++;
        //echo $errors['email'];
    }
    else{

        $req = $db->prepare('SELECT email FROM users WHERE email = ?');
        $req->execute(array($email));
        $user = $req->fetch();
        if($user){
            $emailError = 'Cet email existe déja';
            $errors ++;
            //echo $errors['email'];
        }
    }
    // on vérifie que le password entré correspond bien
    if($password!= $Confirmpassword){
        $passwordError=$ConfirmpasswordError = "les password ne sont pas indentique (alphanumerique)";
        $errors ++;
        //echo $errors['password1'];
    }

    //Insertion lorsqu'il n'ya pas d"erreurs
    if($errors==0){
        $req = $db->prepare('INSERT INTO users SET nom =?,prenom =?,email=?,login=?,password=?');
        $mat = sha1($password);
        $req->execute(array($nom, $prenom, $email, $login,$mat,));

        header("Location: index.php");


    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Burger shop register</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/form-elements.css">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

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
<nav class="navbar navbar-inverse fixed"  >
    <div class="container">


        <img class = "img1" src="img/<?php echo $admin['image']; ?>" width="50" height="40" alt="Avatar"/>
        <a class="navbar-brand" href="#" onclick="openNav()"><?php echo $username ?> </a>

        <a class="btn btn-primary" href="../">Connectez vous en tant qu'utilisateur </a><a class="btn btn-info" href="deconnexion.php">deconnexion </a>

    </div>
</nav>

<!-- Top content -->
<div class="top-content">
    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text">
                <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
                <div class="description">
                    <p>
                        Vous inscrivez un nouveau utilisateur en tant que administrateur
                    </p>
                </div>
            </div>
        </div>

        <div class="row register-form">
            <div class="col-sm-10 col-sm-offset-2">

                <form role="form" action="" method="post" class="r-form">
                    <div class="alert alert-warning" style="color:#ffff00;"><h1><?= $info ?></h1></div>
                    <div class="form-group">
                        <label class="sr-only" for="prenom">Prenom</label>
                        <input type="text" name="prenom" placeholder="First name..." class="r-form-first-name form-control" id="r-form-first-name">
                        <span class="help-inline"><?php echo $prenomError; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="nom">Nom</label>
                        <input type="text" name="nom" placeholder="nom..." class="r-form-last-name form-control" id="r-form-last-name">
                        <span class=" help-inline" style="color:#761c19;"><?php echo $nomError; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="email">Email</label>
                        <input type="text" name="email" placeholder="Email..." class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $emailError; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="login">Login</label>
                        <input type="text" name="login" placeholder="Login..." class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $loginError; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" name="password" placeholder="password..." class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $passwordError; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="Confirmpassword">Password</label>
                        <input type="password" name="Confirmpassword" placeholder="Confirmer votre password..." class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $ConfirmpasswordError; ?></span>
                    </div>
                    <button type="submit" class="btn" name="register" >Sign up!</button>
                    <a  class="btn btn=danger" href="index_admin.php" >retour!</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">

            <div class="col-sm-8 col-sm-offset-2">
                <div class="footer-border"></div>
                <p>Made by <a href="#" target="_blank">Loic And Karelle</a>.</p>
            </div>

        </div>
    </div>
</footer>
<div id="mySidenav" class="sidenav" style="color: white">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="text-center">
        <h4><?php echo $admin['prenom']." ".$admin['nom'] ?> </h4>
        <img src="img/<?php echo $admin['image']; ?>" alt="Avatar"  style="width:50%;height: 100px; margin-left: 0px; border-radius: 50%;">
        <em> <h4>Administrateur</h4></em>
    </div>




    <div class="profile-usertitle-job"><u>Vos Coordonnées  </u> </div>
    <h6>  <span class="glyphicon glyphicon-user"></span> Username :<?php echo $admin['username'] ?> </h6>
    <h6>  <span class="glyphicon glyphicon-send"></span> Email :<?php echo $admin['email'] ?> </h6>
    <br>
    <hr>
    <a  class="btn btn-success btn-sm" href=""><span class="glyphicon glyphicon-cog"></span> Modifier</a>
    <hr>
    <a class="btn btn-primary" href="deconnexion.php">deconnexion </a>

</div>


<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    function openPage(pageName,elmnt,color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = color;

    }
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
        document.body.style.backgroundColor = "white";
    }
</script>


<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>

<!--[if lt IE 10]>
<script src="assets/js/placeholder.js"></script>
<![endif]-->

</body>

</html>