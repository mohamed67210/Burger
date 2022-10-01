<?php
    require 'database.php';
    $nameError = $descriptionError = $priceError = $categoryError =  $imageError = $name = $description = $price = $category = $image = "";
if(!empty($_POST))
{
    $name = checkInput($_POST['name']);
    $description  = checkInput($_POST['descreption']);
    $price = checkInput($_POST['price']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES['image']['name']);
    $imagePath = '../images/' .basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSucces = true;
    $isUploadSucces = false;
    
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
        $imageError = "Ce champ ne peut pas etre vide !";
        $isSucces = false;
    }
    else
    {
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
    if($isSucces && $isUploadSucces )
    {
        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO items(name,description,price,category,image) values(?,?,?,?,?)");
        $statement->execute(array($name,$description,$price,$category,$image));
        Database::disconnect();
        header("location: index.php");
    }
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
                 
                    <h1><strong>Ajouter un item </strong></h1>
                    <br>
                    <form class="form" role="form" action="insert.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom :</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="entrer nom" value="<?php echo $name; ?>"/>
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
                                        echo '<option value="'. $row['id'] . '">' .$row['name'] .'</option>';
                                        
                                    }
                                    
                                ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError; ?></span>
                            
                        </div>
                        <div class="form-group">
                            <label for="image">Selectionner une image :</label>
                            <input type="file" id="image" name="image"/>
                            <span class="help-inline"><?php echo $imageError; ?></span>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-success" type="submit" ><span class="glyphicon glyphicon-plus"></span> Ajouter</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                        </div>
                    
                    </form>
                
                
                
            </div>
        </div>
    
    </body>
    
    

</html>