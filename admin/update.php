<?php
    require 'database.php';
  if(!empty($_GET['id'])){
    $id = trim($_GET['id']);
    $id = stripslashes($_GET['id']);
    $id= htmlspecialchars($_GET['id']);
  }

$nameError = $descriptionError = $priceError=$categoryError = $FileError = $name=$price=$category=$file="";

    if (!empty($_POST))
        {
            $name = checkInput($_POST['name']);
            $description = checkInput($_POST['description']);
            $price = checkInput($_POST['price']);
            $category = checkInput($_POST['category']);
            $file = checkInput($_FILES["image"]['name']);
            $filePath = '../images/'.basename($file);
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
            $isSuccess = true;
            $isUploadSuccess = false;


        if(empty($name)){
            $nameError = 'Ce champ ne doit pas etre null';
            $isSuccess = false;
        }
        if(empty($description)){
            $descriptionError = 'la description ne doit pas etre null';
            $isSuccess = false;
        }
        if(empty($price)){
            $priceError = 'Ce champ ne doit pas etre null';
            $isSuccess = false;
        }
        if(empty($category)){
            $categoryError = 'Ce champ ne doit pas etre null';
            $isSuccess = false;
        }
        if(empty($file)){
            $isImageUpdated = false;

        }else{
            $isImageUpdated = true;
            $isUploadSuccess = true;

            if($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "gif" && $fileExtension != "jpeg"){
                $FileError = "file autorisés png, jpg, jpeg, gif  ";
                $isUploadSuccess = false;

            }if(file_exists($filePath)){
                $FileError = "file exist";
                $isUploadSuccess = false;
            }if($_FILES['image']["size"] > 500000)
            {
                $FileError = "file trop grand (<500Ko) ";
                $isUploadSuccess = false;
            }if($isUploadSuccess){
                if(!move_uploaded_file($_FILES['image']["tmp_name"], $filePath )){
                    $FileError = "upload error ";
                    $isUploadSuccess = false;
                }
            }
    }

        if($isSuccess && $isImageUpdated && $isUploadSuccess || ($isSuccess && !$isImageUpdated))
            {
            $db = Database::connect();
                if($isImageUpdated)
                {
                    $statement =  $db->prepare("UPDATE items SET name = ?,description = ?,price = ?,category = ?,image = ? WHERE id = ?");
                    $statement->execute(array($name,$description,$price,$category,$file,$id));
                }
                else
                {
                    $statement =  $db->prepare("UPDATE items SET name = ?,description = ?,price = ?,category = ?,WHERE id = ?");
                    $statement->execute(array($name,$description,$price,$category,$id));
                }
                  Database::disconnect();
                header("Location: index.php");
             }else if($isImageUpdated && !$isUploadSuccess)
             {
                 $db = database::connect();
                 $statement = $db->prepare('SELECT image FROM items  WHERE items.id = ?');
                 $statement ->execute(array($id));
                 $item = $statement->fetch();
                 $file = $item['image'];
                 database::disconnect();

             }
        }else
        {
            $db = database::connect();
            $statement = $db->prepare('SELECT * FROM items  WHERE items.id = ?');
            $statement ->execute(array($id));
            $item = $statement->fetch();
            $name = $item['name'];
            $description = $item['description'];
            $price = $item['price'];
            $category = $item['category'];
            $file = $item['image'];
            database::disconnect();

    }

function checkInput($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
                <div class="col-sm-6">
                    <h1><strong>Modifier un item</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'update.php?id='. $id ?>" role="form" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                          <label for="name">Nom: </label>
                             <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value=" <?php echo $name ?>">
                             <span class="help-inline"><?php echo $nameError ?></span>
                      </div>

                      <div class="form-group">
                          <label for="description">Description: </label>
                              <input type="text" class="form-control" id="description" name="description" placeholder="Description" value=" <?php echo $description ?>">
                              <span class="help-inline"><?php echo $descriptionError ?></span>
                      </div>
                        <div class="form-group">
                            <label for="price">Prix: (en €) </label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price ?>">
                                <span class="help-inline"> <?php echo $priceError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="category">Catégorie: </label>
                                <select class="form-control" id="category" name="category">
                                    <?php
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM categories') as $cat)
                                        {
                                          if($cat['id'] == $category)
                                            echo '<option selected = "selected" value="'.$cat['id'].'">'.$cat['name'].'</option>';
                                          else
                                             echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                                        }
                                            Database::disconnect();
                                            ?>
                                </select>
                                             <span class="help-inline"><?php echo $categoryError ?></span>
                                            </div>
                         <div class="form-group">
                                                <label for="image">Image:</label>
                                                <p><?php echo $file ?></p>
                                                <label for="image">Sélectionner une nouvelle image:</label>
                                                <input type="file" id="image" name="image">
                                                <span class="help-inline"><?php echo $FileError ?></span>
                                            </div>



                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php" name="update">
                                <span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                    </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                      <?php
                        echo '  <img src="../images/'.$file.'" alt="...">
                                                <div class="price">'.$price.'€</div>
                                                  <div class="caption">
                                                    <h4>'.$name.'</h4>
                                                    <p>'.$description.'</p>
                                                    <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                                                  </div>';

                       ?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
