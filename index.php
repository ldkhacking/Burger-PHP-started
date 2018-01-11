<?php

require 'admin/database.php';
    $prenomError = $nomError=$emailError=$loginError = $passwordError=$ConfirmpasswordError = $pwdError = $logError=$log= "";
$info="Inscription";
$erreur="Connexion";

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

            $info  = "Vous pouvez vous connecter";


        }
    }



if(isset($_POST['login'])) {

    $isSuccess = true;

    if (empty($_POST['log'])) {
        $logError = 'Ce champ ne doit pas etre null';
        $isSuccess = false;
    }
    if (empty($_POST['pwd'])) {
        $pwdError = 'le mots de passe ne doit pas etre vide';
        $isSuccess = false;
    }
    if ($isSuccess == true) {
        extract($_POST);
        $db = Database::connect();
        $req = $db->prepare('SELECT * FROM users WHERE login = :log AND password = :pwd');
        $req->execute(array(
            'log' => $_POST['log'],
            'pwd' => sha1($_POST['pwd'])));

        $existe = $req->fetch();
        if ($existe) {
            session_start();
            $_SESSION['id'] = $existe['id'];
            $_SESSION['login'] = $existe['login'];
            header('Location: admin/index.php');

        }else{
            $erreur = 'Mot de passe ou login invalide ';

        }


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
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>

        <![endif]-->
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
                background-color: #204d740;
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
            <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>

            <a class="btn btn-primary" href="administration/">Connectez vous en tant qu'administrateur </a>
        </div>
    </nav>


    <!-- Top content -->
        <div class="top-content">
        	<div class="container">

                	
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 text">
                        <h1>Burger Shop Login </h1>
                        <div class="description">
                        	<p>
	                         	Connectez vous enfin d'acceder à la page principale du burger code vous permettant de passer des commandes via notre plateforme
                        	</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 show-forms">
                    	<span class="show-register-form active">Inscription</span>
                    	<span class="show-forms-divider">/</span>
                    	<span class="show-login-form">Connexion</span>
                    </div>
                </div>
                
                <div class="row register-form">
                    <div class="col-sm-9 col-sm-offset-3">

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
						</form>
                    </div>
                </div>
                
                <div class="row login-form">
                    <div class="col-sm-9 col-sm-offset-3">
						<form role="form" action="" method="post" class="l-form">
                            <div class="alert alert-error" style="color:red;"><h1><?= $erreur ?></h1></div>
	                    	<div class="form-group">
	                    		<label class="sr-only" for="log">Login</label>
	                        	<input type="text" name="log" placeholder="Login..." class="l-form-username form-control" id="l-form-username">
                                <span class="help-inline"><?php echo $logError; ?></span>
	                        </div>
	                        <div class="form-group">
	                        	<label class="sr-only" for="pwd">Password</label>
	                        	<input type="password" name="pwd" placeholder="Password..." class="l-form-password form-control" id="l-form-password">
                                <span class="help-inline"><?php echo $pwdError; ?></span>
	                        </div>
				            <button type="submit" class="btn" name="login">Sign in!</button>
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