<?php
    header('context.type: text/html; charset-8');
    require '../admin/database.php';


    if(isset($_GET['username'])){
    echo $_GET['username'];

        $critere = $_GET['username'].'%';
        $bd = database::connect();
        $req =$bd->prepare("SELECT * FROM admin where username LIKE ?");
        $req->execute(array($critere));
        $table = $req->fetchAll(PDO::FETCH_OBJ);
        if(count($table)>0){
            echo"<h3>".count($table)." Administrateurs trouvé(s)  </h3>";
            foreach ($table as $ligne){
                $nom= $ligne->nom;
                $prenom= $ligne->prenom;
                $username= $ligne->username;
                $pic= $ligne->image;

                echo " <img src='img/$pic' width='40px' height='40' style='border-radius: 50px;'/>  $nom  $prenom et de login $username </br></br>";
            }
        }else echo"<p>0 resultat(s) trouvé(s) </h3>";

        $req1 =$bd->prepare("SELECT * FROM users where login LIKE ?" );
        $req1->execute(array($critere));
        $table1 = $req1->fetchAll(PDO::FETCH_OBJ);
        if(count($table)>0){
            echo"<h3>".count($table1)." utilisateurs trouvé(s) </h3>";
            foreach ($table1 as $ligne){
                $nom= $ligne->nom;
                $prenom= $ligne->prenom;
                $username= $ligne->login;
                echo " $nom  $prenom et de login $username </br></br>";
            }
        }else echo"<p>0 resultat(s) trouvé(s) </h3>";

    }