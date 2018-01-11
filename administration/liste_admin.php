<?php
if(session_start()){
    $username = $_SESSION['username'];
    $id_admin = $_SESSION['id_admin'];

    require '../admin/database.php';
    $code_secretError="";
}else{
    header("Location: index.php");
}
$loginError=$logError=$decryp=$cryp=$error=$crypError="";

$bd = database::connect();
$statement1 = $bd->prepare("SELECT * FROM `admin` WHERE username=?" );
$statement1->execute(array($username));
$admin = $statement1->fetch();

// on gère le bouton modifier un utilisateur
if(isset($_POST['search'])) {
    if(empty($_POST['login'])){
        $loginError = "entrer un login (le champ de doit pas etre vide vous aussi ahhh didon vous enervez même déjà a la fin)";
    }else{
        // on se connecte a la bd et on vérifie si le login existe
        extract($_POST);
        $db = Database::connect();
        $req = $db->prepare('SELECT login FROM users WHERE login = :login');
        $req->execute(array(
            'login' => $_POST['login']));

        $existe = $req->fetch();
        if ($existe) {
            header('Location: modifier_user.php?login='. $existe['login']);
        }else{
            $loginError = "Le login n'existe pas dans la bd";
        }
    }
}
// on gère le bouton suprimer un user
if(isset($_POST['suprimer'])) {
    if(empty($_POST['log'])){
        $logError = "entrer un login (le champ de doit pas etre vide vous aussi ahhh didon vous enervez même déjà a la fin)";
    }else{
        // on se connecte a la bd et on vérifie si le login existe
        extract($_POST);
        $db = Database::connect();
        $req = $db->prepare('SELECT login FROM users WHERE login = :log');
        $req->execute(array(
            'log' => $_POST['log']));

        $existe = $req->fetch();
        if ($existe) {
            header('Location: suprimer.php?login='.$existe['login']);
        }else{
            $logError = "Le login n'existe pas dans la bd";
        }
    }
}
// decrptage de mot de passe
if(isset($_POST['crypt'])){
    // on verifie si les deux champs ne sont pas vide
    extract($_POST);
    $mot_crypte = $_POST['mot_crypter'];
    $mot_decrypte = $_POST['mot_decrypter'];
    if(empty($mot_crypte) && empty($mot_decrypte)){
        $crypError = "les deux champs ne doivent pas etre vide en même temps";
    }else if(!empty($mot_crypte) && empty($mot_decrypte)){
        $decryp = sha1($mot_crypte);
        $cryp = $mot_crypte;
        $crypError = "Desoler mais je vous ai eu l'objectif du hasharche est justement de ne pas retrouver le mot de passe d'un utilisateur !!!<br> neamois 
            vous pouvez tester de multiple mot de passe et les comparer !!" ;
    }else{
        $cryp = sha1($mot_decrypte);
        $decryp = $mot_decrypte;
        $crypError = "Desoler mais je vous ai eu l'objectif du hasharche est justement de ne pas retrouver le mot de passe d'un utilisateur !!<br> neamois 
            vous pouvez tester de multiple mot de passe et les comparer !!" ;
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

    <title>Administrateur Burger Code</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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

<body >
<div id="main">



    <!-- Navigation -->
    <nav class="navbar navbar-inverse fixed"  >
        <div class="container">


            <img class = "img1" src="img/<?php echo $admin['image']; ?>" width="50" height="40" alt="Avatar"/>
            <a class="navbar-brand" href="#" onclick="openNav()"><?php echo $username ?> </a>

            <a class="btn btn-primary" href="../../">Connectez vous en tant qu'utilisateur </a><a class="btn btn-info" href="deconexion.php">deconnexion </a>

        </div>
    </nav>

    <!-- Icons Grid -->
    <section class="features-icons testimonials bg-light text-center">
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span><a href="index_admin.php"> Burger Code </a><span class="glyphicon glyphicon-cutlery"></span></h1>
        <h1>Nous sommes content de vous revoir parmis nous !!! </h1>
        <hr>
        <h2>Alors que voulez vous faire ?</h2>

        <button class="tablink" onclick="openPage('Home', this, '#867979')" id="defaultOpen">Modifier un Utilisateur</button>
        <button class="tablink" onclick="openPage('News', this, '#e4dff2')" >Ajouter utilisateur</button>
        <button class="tablink" onclick="openPage('Contact', this, '#979ab7')">Suprimer utilisateur</button>
        <button class="tablink" onclick="openPage('About', this, '#e8eac4')">Ajouter un administrateur</button>

        <div id="Home" class="tabcontent">
            <div class="container">
                <h3>Entrer le login de l'utilisateur </h3>
                <form action="#" method="post">
                    <input type="text" name="login" class="form-control form-control-lg" placeholder="Entrez le login...">
                    <span class="help-inline" style="color:#761c19;"><?php echo $loginError; ?></span>

                    <br>
                    <div class="col-3 offset-4">
                        <button type="submit" name ="search"class="btn btn-block btn-lg btn-primary">recherche</button>
                    </div>

                </form>
            </div>
        </div>

        <div id="News" class="tabcontent">

            <div class="container col-centered">
                <h3 style="color: black;">Cliquez sur le bouton ci-dessous !!!!!</h3>
                <br>
                <br>
                <a href="inscription.php" class="btn btn-block  btn-info"> Inscrire utilisateur </a>

            </div>
        </div>

        <div id="Contact" class="tabcontent">
            <div class="container">
                <h3> Entrer le login de l'utilisateur !!!</h3>
                <form action="#" method="post">
                    <input type="text" name="log" class="form-control form-control-md" placeholder="Entrez le login...">
                    <span class="help-inline" style="color:#761c19;"><?php echo $logError; ?></span>

                    <br>
                    <div class="col-3 offset-4">
                        <button type="submit" name ="suprimer"class="btn btn-block btn-lg btn-primary">recherche</button>
                    </div>

                </form>
            </div>
        </div>

        <div id="About" class="tabcontent">
            <div class="container col-centered">
                <h3 style="color: black;">Cliquez sur le bouton ci-dessous !!!!!</h3>
                <br>
                <br>
                <a href="inscription_admin.php" class="btn btn-block  btn-info"> Inscrire Administrateur </a>

            </div>
        </div>
        <br>
        <hr>

        <div class="container-fluid">
            <h1>Information de la base de données</h1>
            <div class="row">

                <div class="col-lg-12 text-center">
                    <h2>Liste des Adimistrateurs</h2>
                    <p>Vous pouvez avoir plus d'information sur le mot de passe en le decryptant</p>
                    <table class="table table-dark table-hover">
                        <thead class="text-center">
                        <tr >
                            <th class="text-center">#</th>
                            <th class="text-center">Nom</th>
                            <th class="text-center">Prenom</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Code secret</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $statement = $bd->query('SELECT * FROM admin');
                        while($user = $statement->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $user['id_admin'] . "</td>";
                            echo "<td>" . $user['nom'] . "</td>";
                            echo "<td>" . $user['prenom'] . "</td>";
                            echo "<td>" . $user['email'] . "</td>";
                            echo "<td>" . $user['username'] . "</td>";
                            echo "<td>" . $user['secret'] . "</td>";
                            echo "</tr>";
                        }
                        ?>

                        </tbody>
                    </table>
                    <hr>
                    <h2>Decrypter un mot de passe </h2>
                    <form action="" method="post">
                        <div class="row ">

                            <div class="col-4 offset-1">
                                <input class="form-control" id="ex3" type="text" placeholder="mot crypter" name="mot_crypter" value="<?php echo $cryp; ?>">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary form-control" type="input" name="crypt"><span class="glyphicon glyphicon-resize-horizontal"></span></button>
                            </div>
                            <div class="col-4">

                                <input class="form-control disabled" name="mot_decrypter" type="text" placeholder="mot de decripter" value="<?php echo $decryp; ?>">
                            </div>
                        </div>
                        <br>
                        <span class="help-inline" style="color:#761c19;"><?php echo $crypError; ?></span>
                    </form>
                </div>
            </div>


        </div>

    </section>


    <!-- Footer -->
    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item">
                            <a href="#">A propos de nous</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a href="#">Contact</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a href="https://patrice-pegaule.com/academy">Cours web I2 3il</a>
                        </li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; tout droit reserve</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fa fa-facebook fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fa fa-twitter fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-instagram fa-2x fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>

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

</body>

</html>
