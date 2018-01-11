
<?php
require '../admin/database.php';
if(!empty($_GET['login'])){
    $log = trim($_GET['login']);
    $log = stripslashes($_GET['login']);
    $log = htmlspecialchars($_GET['login']);
}
if(!empty($_POST)){

    $db = database::connect();
    $statement = $db->prepare('DELETE FROM users WHERE login = ? ');
    $statement ->execute(array($log));
    database::disconnect();
    header("Location: index_admin.php");
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
        <form class="form" action="" role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $log; ?>"/>
            <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
            <div class="form-actions">
                <button type="submit" class="btn btn-warning">Oui</button>
                <a class="btn btn-default" href="index_admin.php">Non</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
