<?php
    require 'database.php';
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    $nameError = $descriptionError = $priceError = $categoryError =  $imageError = $name = $description = $price = $category = $image = "";

if(!empty($_POST))/* est ce que la variable POST n'est pas vide 2eme passe quand on appuie sur le bouton modifer*/
{
    $name = checkInput($_POST['name']);
    $description  = checkInput($_POST['descreption']);
    $price = checkInput($_POST['price']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES['image']['name']);
    $imagePath = '../images/' .basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSucces = true;
    
    
    if(empty($name))
    {
        $nameError = "Ce champ ne peut pas etre vide !";
        $isSucces = false;
    }
    if(empty($description))
    {
        $descriptionError = "Ce champ ne peut pas etre vide !";
        $isSucces = false;
    }
    if(empty($price))
    {
        $priceError = "Ce champ ne peut pas etre vide !";
        $isSucces = false;
    }
    if(empty($category))
    {
        $categoryError = "Ce champ ne peut pas etre vide !";
        $isSucces = false;
    }
    if(empty($image))
    {
        $isImageUpdated = false ;
    }
    else
    {
        $isImageUpdated = true ;
        $isUploadSucces = true;
        if($imageExtension!="jpg" && $imageExtension!="png" && $imageExtension!="jpeg" && $imageExtension!="gif")
        {
            $imageError = "le format de l'image autorisé sont : jpg,png,jpeg,gif";
            $isUploadSucces = false;
        }
        if(file_exists($imagePath))
        {
            $imageError = "l'image existe deja";
            $isUploadSucces = false;
        }
        if($_FILES['image']['size'] > 500000)
        {
            $imageError = "le fichier ne doit pas depasser les 500kb";
            $isUploadSucces = false;
        }
        if($isUploadSucces)
        {
            if(!move_uploaded_file($_FILES['image']['tmp_name'],$imagePath))
            {
                $imageError = "il y'a eu une erreur lors de l'upload";
                $isUploadSucces = false;
            }
        }
    }
    if(($isSucces && $isUploadSucces && $isImageUpdated) || ($isSucces && !$isImageUpdated))
    {
        $db = Database::connect();
        if($isImageUp)
        {
            $statement = $db->prepare("UPDATE items SET name=?, description=?, price=?, category=?,image=? WHERE id=? ");
            $statement->execute(array($name,$description,$price,$category,$image,$id));
        }
        else
        {
            $statement = $db->prepare("UPDATE items SET name=?, description=?, price=?, category=? WHERE id=? ");
            $statement->execute(array($name,$description,$price,$category,$id));
        }
        
        Database::disconnect();
        header("location: index.php");
    }
    else if($isImageUpdated && !$isUploadSucces)
    {
        $db = Database::connect();
        $statement = $db->prepare('select * from items where id=?');
        $statement->execute(array($id));
        $item = $statement->fetch();
        $image = $item['image'];
        Database::disconnect();
    }
}

else /* premier passage quand on clique sur modifier de la page admin.php on va afficher les elements qu'on va modifier (avant la modification) */
{
    $db = Database::connect();
    $statement = $db->prepare('select * from items where id=?');
    $statement->execute(array($id));
    $item = $statement->fetch();
    
    $name = $item['name'];
    $description = $item['description'];
    $price = $item['price'];
    $category = $item['category'];
    $image = $item['image'];
    Database::disconnect();
}


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
                    <h1><strong>Modifier un item </strong></h1>
                    <br>
                    <form class="form" role="form" action="<?php echo'update.php?id=' . $id ;?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom :</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="entrer nom" value="<?php echo $name;?>"/>
                            <span class="help-inline"><?php echo $nameError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description :</label>
                            <input type="text" class="form-control" id="description" name="descreption" placeholder="entrer description" value="<?php echo $description; ?>"/>
                            <span class="help-inline"><?php echo $descriptionError; ?></span>
                            
                        </div>
                        <div class="form-group">
                            <label for="price">Prix : (en €) </label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="entrer prix" value="<?php echo $price; ?>"/>
                            <span class="help-inline"><?php echo $priceError; ?></span>

                        </div>
                        <div class="form-group">
                            <label for="category">Catégorie :</label>
                            <select class="form-control" id="category" name="category">
                                <?php
                                    $db=Database::connect();
                                    foreach($db->query("SELECT * FROM categories") as $row)
                                    {
                                        if($row['id']==$category)
                                            echo '<option selected="selected" value="'. $row['id'] . '">' .$row['name'] .'</option>';
                                        else
                                            echo '<option  value="'. $row['id'] . '">' .$row['name'] .'</option>';
                                    }
                                    
                                ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError; ?></span>
                            
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <p><?php echo $image ?></p>
                            <label for="image">Selectionner une image :</label>
                            <input type="file" id="image" name="image"/>
                            <span class="help-inline"><?php echo $imageError; ?></span>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-success" type="submit" ><span class="glyphicon glyphicon-plus"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                        </div>
                    
                    </form>
                </div>
                
                <div class="col-sm-6">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/' . $image; ?>" alt="...">
                        <div class="price"><?php echo  number_format((float)$price,2,'.','') . ' €' ; ?></div>
                        <div class="caption">
                        <h4><?php echo  $name ; ?></h4>
                            <p><?php echo  $description; ?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-plus"></span>Commander</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    
    </body>
    
    

</html>