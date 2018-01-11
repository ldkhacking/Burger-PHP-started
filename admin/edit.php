
<?php

require 'database.php';
if(session_start()){
    $login=$_SESSION['login'];
}else{
    $login = "";
}
$prenomError = $nomError=$emailError=$loginError = $passwordError=$ConfirmpasswordError = $pwdError = $logError=$oldpasswordError= "";
$info="Modification";
$countuser = 0;
$countemail = 0;


if(isset($_POST['register']))
{
    $db = Database::connect();
    extract($_POST);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $log = $_POST['login'];
    $password = $_POST['password'];
    $pwd = $_POST['oldpassword'];
    $Confirmpassword = $_POST['Confirmpassword'];
    $errors = 0;

    //Verification du nom
    if(!preg_match('/^[a-z A-Z]+$/',$nom) || empty($nom)){
        $nomError = "Nom invalide (alphanumerique)";
        $errors ++;
    }

    //Verification du prénom
    if(!preg_match('/^[a-z A-Z]+$/',$prenom) || empty($prenom)){
        $prenomError = "Prenom invalide (alphanumerique)";
        $errors ++;
    }

    //Verification du login
    if(!preg_match('/^[a-z A-Z0-9_]+$/',$log)){
        $loginError = " Pseudo invalide (alphanumerique)";
        $errors ++;
    }
    else{


        $req = $db->prepare('SELECT login FROM users WHERE login = ?');
        $req->execute(array($login));
        while($user = $req->fetch()){
            $countuser++;
        }

        if($countuser > 1){
            $loginError = ' vous ne pouvez pas modifier un login par un existant ';
            $errors ++;
        }

    }


    //Verification d'email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailError= "Format d'email invalide";
        $errors ++;
        //echo $errors['email'];
    }
    else{

        $req = $db->prepare('SELECT email FROM users WHERE  email = ?');
        $req->execute(array($email));
        while ($user = $req->fetch()){
            $countemail++;
        }
        if($countemail > 1){
            $emailError = 'vous ne pouvez pas modifier l\'email par un existant ';
            $errors ++;
        }
    }
    //on verifie l'ancien password
    if (empty($_POST['oldpassword'])) {
        $oldpasswordError = 'le mots de passe ne doit pas etre vide';
        $errors ++;
    }else{
        $req = $db->prepare('SELECT password FROM users WHERE login = ? and password = ?');
        $req->execute(array($login,sha1($pwd)));
        $pass = $req->fetch();

        if(!$pass){
            $errors++;
            $oldpasswordError = 'le mot de passe ne correspond pas !!!!';
            echo "error mot de pass";
        }
    }
    // on vérifie que le password entré correspond bien
    if($password!= $Confirmpassword){
        $passwordError=$ConfirmpasswordError = "les password ne sont pas indentique (alphanumerique)";
        $errors ++;
    }

    //Modification lorsqu'il n'ya pas d"erreurs
    if($errors==0){
        $req = $db->prepare("UPDATE users SET  nom =?,prenom =?,email=?,login=?,password=? WHERE login = ?");
        $mat = sha1($password);
        $req->execute(array($nom, $prenom, $email, $login,$mat,$login));

        $info  = "Vous pouvez vous connecter";
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
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <![endif]-->


</head>

<body>

<!-- Top content -->
<div class="top-content">
    <div class="container">


        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text">
                <h1>Burger Shop Login </h1>
                <div class="description">
                    <p>
                        Modification de vos coordonnées c'est genial le php
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 show-forms">
                <span class="show-register-form active">Vos coordonées</span>
            </div>
        </div>

        <div class="row register-form">
            <div class="col-sm-9 col-sm-offset-3">

                <form role="form" action="" method="post" class="r-form">
                    <div class="alert alert-warning" style="color:#ffff00;"><h1><?= $info ?></h1></div>
                    <?php
                                $bd = database::connect();
                                $statement1 = $bd->query("SELECT * FROM `users` WHERE login='$login'");
                                $user = $statement1->fetch();
                                $bd =  database::disconnect();

                                ?>
                    <div class="form-group">
                        <label class="sr-only" for="prenom">Prenom</label>
                        <input type="text" name="prenom" placeholder="" value="<?php echo $user['prenom']?>" class="r-form-first-name form-control" id="r-form-first-name">
                        <span class="help-inline"><?php echo $prenomError; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="nom">Nom</label>
                        <input type="text" name="nom" placeholder="" value="<?php echo $user['nom']?>" class="r-form-last-name form-control" id="r-form-last-name">
                        <span class=" help-inline" style="color:#761c19;"><?php echo $nomError; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="email">Email</label>
                        <input type="text" name="email" placeholder="Email..." value="<?php echo $user['email']?>" class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $emailError; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="login">Login</label>
                        <input type="text" name="login" placeholder="Login..." value="<?php echo $user['login']?>" class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $loginError; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" name="oldpassword" placeholder="ancien password..." class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $oldpasswordError; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="Confirmpassword">Password</label>
                        <input type="password" name="password" placeholder="nouveau password..." class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $passwordError; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="Confirmpassword">Password</label>
                        <input type="password" name="Confirmpassword" placeholder="Confirm nouveau password..." class="r-form-email form-control" id="r-form-email">
                        <span class="help-inline" style="color:#761c19;"><?php echo $ConfirmpasswordError; ?></span>
                    </div>
                    <button type="submit" class="btn" name="register" >Sign up!</button>
                    <a  class="btn btn=danger" href="index.php" >retour!</a>
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