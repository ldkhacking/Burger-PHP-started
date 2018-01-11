
<?php
  require 'database.php';
  if(!empty($_GET['id'])){
    $id = trim($_GET['id']);
    $id = stripslashes($_GET['id']);
    $id= htmlspecialchars($_GET['id']);
  }

  $db = database::connect();
  $statement = $db->prepare('SELECT items.id,items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?');
  $statement ->execute(array($id));
  $item = $statement->fetch();
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Burger Code</title>
        <meta charset="utf-8"/>
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
               <div class="col-sm-6">
                    <h1><strong>Voir un item</strong></h1>
                    <br>
                    <form>
                      <?php
                      echo '

                      <div class="form-group">
                        <label>Nom:</label>'.$item['name'] .'</div>
                      <div class="form-group">
                        <label>Description:</label> '.$item['description'] .'  </div>
                      <div class="form-group">
                        <label>Prix:</label>  '.$item['price'] .'€ </div>
                      <div class="form-group">
                        <label>Catégorie:</label>'.$item['category'] .' </div>
                      <div class="form-group">
                        <label>Image:'.$item['image'] .'</label> </div>


                       ';
                       ?>

                    </form>
                    <br>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                      <?php
                        echo '   <img src="../images/'.$item['image'].'" alt="...">

                                 <div class="price">'.$item['price'] .'€</div>
                                                  <div class="caption">
                                                    <h4>'.$item['name'] .'</h4>
                                                    <p>'.$item['description'] .'</p>
                                                    <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                                                  </div>
                                            </div>';

                         ?>

                </div>
            </div>
        </div>
    </body>
</html>
