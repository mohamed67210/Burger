<?php

    require 'database.php';
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);

    }

    $db = Database::connect();
    $statement = $db->prepare("SELECT items.id, items.name, items.description, items.price,items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id= ?");
    $statement ->execute(array($id));
    $item = $statement->fetch();
    Database::disconnect();


    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Burger Code</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    
    </head>
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
        <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Voir un item </strong></h1>
                    <br>
                    <form>
                        <div class="form-group">
                            <label>Nom :</label><?php echo ' ' . $item['name'] ; ?>
                        </div>
                        <div class="form-group">
                            <label>Description :</label><?php echo ' ' . $item['description'] ; ?>
                        </div>
                        <div class="form-group">
                            <label>Prix :</label><?php echo ' ' . number_format((float)$item['price'],2,'.','') . ' €' ; ?>
                        </div>
                        <div class="form-group">
                            <label>Catégorie :</label><?php echo ' ' . $item['category'] ;?>
                        </div>
                        <div class="form-group">
                            <label>Image :</label><?php echo ' ' . $item['image'] ; ?>
                        </div>
                        <div class="form-actions">
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                        </div>
                    
                    </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/' . $item['image']; ?>" alt="...">
                        <div class="price"><?php echo ' ' . number_format((float)$item['price'],2,'.','') . ' €' ; ?></div>
                        <div class="caption">
                        <h4><?php echo ' ' . $item['name'] ; ?></h4>
                            <p><?php echo ' ' . $item['description'] ; ?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-plus"></span>Commander</a>
                        </div>
                    </div>
                            
                </div>
                
            </div>
        </div>
    
    </body>
    
    

</html>