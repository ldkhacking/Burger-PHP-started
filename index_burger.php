
<?php
  require 'admin/database.php';


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
    <link rel="stylesheet" href="css/styles.css">
</head>


<body>
<div class="container site">
    <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
    <nav>
        <ul class="nav nav-pills"><li role="presentation" class="active"><a href="#1" data-toggle="tab">Menus</a></li><li role="presentation"><a href="#2" data-toggle="tab">Burgers</a></li><li role="presentation"><a href="#3" data-toggle="tab">Snacks</a></li><li role="presentation"><a href="#4" data-toggle="tab">Salades</a></li><li role="presentation"><a href="#5" data-toggle="tab">Boissons</a></li><li role="presentation"><a href="#6" data-toggle="tab">Desserts</a></li></ul>
    </nav>
    <div class="tab-content">
        <div class="tab-pane active" id="1">
            <div class="row">
                <?php
                $db = database::connect();
                $statement = $db->query('SELECT items.id,items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id where items.category = 1');

                while($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4">';
                    echo ' <div class="thumbnail">';
                    echo '<img src="images/'.$item['image'].'" alt="...">';
                    echo '<div class="price">'.$item['price'].'</div>';
                    echo '<div class="caption">';
                    echo '<h4>'.$item['category'].'</h4>';
                    echo '<p>'.$item['description'].'</p>';
                    echo '<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                    echo '</div>
                              </div>
                              </div>';

                }

                ?>
        </div>
        </div>
        <div class="tab-pane" id="2">
            <div class="row">
                <?php
                $id = 1;
                $db = database::connect();
                $statement = $db->query('SELECT items.id,items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id where items.category = 2');

                while($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4">';
                    echo ' <div class="thumbnail">';
                    echo '<img src="images/'.$item['image'].'" alt="...">';
                    echo '<div class="price">'.$item['price'].'</div>';
                    echo '<div class="caption">';
                    echo '<h4>'.$item['category'].'</h4>';
                    echo '<p>'.$item['description'].'</p>';
                    echo '<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                    echo '</div>
                              </div>
                              </div>';

                }

                ?>
              </div>
        </div>
        <div class="tab-pane" id="3">
            <div class="row">
                <?php
                $id = 1;
                $db = database::connect();
                $statement = $db->query('SELECT items.id,items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id where items.category = 3');

                while($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4">';
                    echo ' <div class="thumbnail">';
                    echo '<img src="images/'.$item['image'].'" alt="...">';
                    echo '<div class="price">'.$item['price'].'</div>';
                    echo '<div class="caption">';
                    echo '<h4>'.$item['category'].'</h4>';
                    echo '<p>'.$item['description'].'</p>';
                    echo '<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                    echo '</div>
                              </div>
                              </div>';

                }

                ?>
               </div>
        </div>
        <div class="tab-pane" id="4">
            <div class="row">
                <?php
                $db = database::connect();
                $statement = $db->query('SELECT items.id,items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id where items.category = 4');

                while($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4">';
                    echo ' <div class="thumbnail">';
                    echo '<img src="images/'.$item['image'].'" alt="...">';
                    echo '<div class="price">'.$item['price'].'</div>';
                    echo '<div class="caption">';
                    echo '<h4>'.$item['category'].'</h4>';
                    echo '<p>'.$item['description'].'</p>';
                    echo '<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                    echo '</div>
                              </div>
                              </div>';

                }

                ?>

            </div>
        </div>
        <div class="tab-pane" id="5">
            <div class="row">
                <?php
                $db = database::connect();
                $statement = $db->query('SELECT items.id,items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id where items.category = 5');

                while($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4">';
                    echo ' <div class="thumbnail">';
                    echo '<img src="images/'.$item['image'].'" alt="...">';
                    echo '<div class="price">'.$item['price'].'</div>';
                    echo '<div class="caption">';
                    echo '<h4>'.$item['category'].'</h4>';
                    echo '<p>'.$item['description'].'</p>';
                    echo '<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                    echo '</div>
                              </div>
                              </div>';

                }

                ?>
            </div>
        </div>
        <div class="tab-pane" id="6">
            <div class="row">
                <?php

                $db = database::connect();
                $statement = $db->query('SELECT items.id,items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id where items.category = 6');

                while($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4">';
                    echo ' <div class="thumbnail">';
                    echo '<img src="images/'.$item['image'].'" alt="...">';
                    echo '<div class="price">'.$item['price'].'</div>';
                    echo '<div class="caption">';
                    echo '<h4>'.$item['category'].'</h4>';
                    echo '<p>'.$item['description'].'</p>';
                    echo '<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                    echo '</div>
                              </div>
                              </div>';

                }

                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

