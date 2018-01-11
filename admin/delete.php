
<?php
  require 'database.php';
  if(!empty($_GET['id'])){
    $id = trim($_GET['id']);
    $id = stripslashes($_GET['id']);
    $id= htmlspecialchars($_GET['id']);
  }
  if(!empty($_POST)){

    $id = trim( $_POST['id']);
    $id = stripslashes($_POST['id']);
    $id= htmlspecialchars($_POST['id']);
    $db = database::connect();
    $statement = $db->prepare('DELETE FROM items WHERE id = ? ');
    $statement ->execute(array($id));
    $item = $statement->fetch();
    database::disconnect();
    header("Location: index.php");
  }
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
                <h1><strong>Supprimer un Menu</strong></h1>
                <br>
                <form class="form" action="delete.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-warning">Oui</button>
                      <a class="btn btn-default" href="index.php">Non</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
