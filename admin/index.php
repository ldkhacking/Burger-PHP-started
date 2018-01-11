<?php
  require 'database.php';

  if(session_start()){
      $login=$_SESSION['login'];
  }else{
      $login = "";
  }



 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Burger Code</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/styles.css">


    </head>

    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
        <div class="container admin">
            <div class="row">
                <div class="col-sm-7">
                    <h1><strong>Liste des items   </strong><a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a> </h1>

                </div>
                <div class="col-sm-5 well">



                    <h3><?php if($login != ""){
                      echo "  <div class=\"row\">";
                         echo" <div class=\"col-md-6\">";
                            echo " <h4><span class=\"glyphicon glyphicon-user\"></span>: <a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal\"> ".$_SESSION['login']."</a></h4>";
                           echo  "</div>";
                           echo "<div class=\"col-md-6\">";
                            echo " <h4><span class=\"glyphicon glyphicon-off\"></span> :<a href=\"deconnec.php\">  Deconnexion</a></h4>";
                            echo "</div>";
                            echo "</div>";

                            echo "  <div class=\"text-center\">";
                             echo "<h4><span class=\"glyphicon glyphicon-link\"></span>: <a href='../administration/' > Vous êtes un administrateur ? </a> </h4>";
                            echo  "</div>";



                        }

                        else echo "<span class=\"glyphicon glyphicon-on\"></span><a href=\"../index.php\" > Se Connecter </a>";


                        ?></h3>


                </div>

                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Description</th>
                      <th>Prix</th>
                      <th>Catégorie</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $bd = database::connect();
                    $statement = $bd->query('SELECT items.id,items.name, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');

                    while ($item = $statement->fetch()) {
                      echo ' <tr>
                        <td>'.$item['name'].'</td>';

                        echo '<td>'.$item['description'].'</td>';
                        echo '<td>'.$item['price'].'</td>';
                        echo '<td>'.$item['category'].'</td>';
                        echo '<td width=300><a class="btn btn-default" href="view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a> <a class="btn btn-primary" href="update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a> <a class="btn btn-danger" href="delete.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a></td>
';
                        echo '</tr>';
                        $bd =  database::disconnect();

                    }

                     ?>


                  </tbody>
                </table>
            </div>
        </div>

    <!-- Modal -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="profile-usertitle">
                           <?php
                                $bd = database::connect();
                                $statement1 = $bd->query("SELECT * FROM `users` WHERE login='$login'");
                                $user = $statement1->fetch();

                                echo " <h4 class=\"modal-title  profile-usertitle-name\">". $user['nom']." ". $user['prenom'] ."
                    
                                    </br>
                                    <span class=\"glyphicon glyphicon-user\"></span>
                                    </h4>
                                 
                                    ";
                                echo " <div class=\"profile-usertitle-job\"> Utilisateur </div>";

                           $bd =  database::disconnect();
                          ?>
                        </div>
                        <div class="profile-userbuttons">
                            <a  class="btn btn-success btn-sm" href="edit.php"><span class="glyphicon glyphicon-cog"></span> Modifier</a>

                        </div>
                    </div>
                    <div class="modal-body">
                               <div class="container">
                                   <div class="profile-usertitle-job"><u>Vos Coordonnées  </u> </div>
                                   <h5>  <span class="glyphicon glyphicon-user"></span> Login :<?php echo $user['login'] ?> </h5>
                                   <h5>  <span class="glyphicon glyphicon-send"></span> Login :<?php echo $user['email'] ?> </h5>

                               </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        </div>




    </body>
</html>
