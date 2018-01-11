<?php
require 'database.php';

$nameError = $descriptionError = $priceError=$categoryError = $FileError = "";

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
        if(empty($desciption)){
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
            $fileError = 'Ce champ ne doit pas etre null';
            $isSuccess = false;
        }else{
            $isUploadSuccess = true;
            if($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "gif" && $fileExtension != "jpeg"){
                $fileError = "file autoris�s ";
                $isUploadSuccess = false;

            }if(file_exists($filePath)){
                $fileError = "file exist";
                $isUploadSuccess = false;
            }if($_FILES['image']["size"] > 500000)
            {
                $fileError = "file trop grand ";
                $isUploadSuccess = false;
            }if($isUploadSuccess){
                if(!move_uploaded_file($_FILES['image']["tmp_name"], $filePath )){
                    $fileError = "upload error ";
                    $isUploadSuccess = false;
                }
            }
        }

        if($isSuccess == true && $isUploadSuccess == true){
            $db = Database::connect();
            $statement =  $db->prepare("INSERT INTO items (name,description,price,category,image) values(?,?,?,?,?)");
            $statement->execute(array($name,$description,$price,$category,$file));
            Database::disconnect();

            header("Location: index_correc.php");
        }

    }else{
        $name = "";
        $description = "";
        $price ="";
        $category = "";

    }

    function checkInput($data)
    {
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
                <h1><strong>Ajouter un item</strong></h1>
                <br>
                <form class="form" action="insertItem.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                        <span class="help-inline"><?php echo $descriptionError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Prix: (en )</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                        <span class="help-inline"><?php echo $priceError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie:</label>
                        <select class="form-control" id="category" name="category">
                            <?php
                            $db = Database::connect();
                            $statement = $db->query('SELECT categories.id, categories.name FROM categories');


                            while($category = $statement->fetch()){

                               echo'  <option value="'.$category['id'].'">'.$category['name'].'</option>';

                            }
                            ?>
                         </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>



                    </div>
                    <div class="form-group">
                        <label for="image">Sélectionner une image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $FileError; ?></span>
                    </div>

                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" name="submit" value="Ajouter"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                   </div>
                </form>
            </div>
        </div>   
    </body>
</html>
9wwpukxo