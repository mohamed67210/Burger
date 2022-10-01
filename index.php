
<!DOCTYPE html>
<html>
    <head>
        <title> McMo </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
        
    </head>
    <body>
        <div class="container site">
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> fastfood <span class="glyphicon glyphicon-cutlery"></span></h1>
            
            <?php
                require 'admin/database.php';
                echo '<nav>
                <ul class="nav nav-pills">';
                $db=Database::connect();
                $statement=$db->query('SELECT * FROM categories');
                $categories=$statement->fetchAll();
                foreach($categories as $category)
                {
                    if($category['id']== 1)
                    {
                        echo '<li role="presentation" class="active"><a href="#' .$category['id'] .'"data-toggle="tab">' . $category['name'] .'</a></li>';
                    }
                    else
                    {
                        echo '<li role="presentation"><a href="#' .$category['id']. '" data-toggle="tab">' . $category['name'] .'</a></li>';
                    }
                }
            echo '</ul>';
            echo '</nav>';
            
            echo '<div class="tab-content">';
            foreach($categories as $category)
            {
                if($category['id']== 1)
                    {
                        echo '<div class="tab-pane active" id="' .$category['id'] . '">';
                    }
                    else
                    {
                        echo '<div class="tab-pane " id="' .$category['id'] . '">';
                    }
                echo '<div class="row">';
                $statement=$db->prepare('select * from items WHERE items.category= ?');
                $statement->execute(array($category['id']));
                while($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4">';
                    echo '<div class="thumbnail">';
                    echo '<img src="images/'. $item['image'].'" alt="..">
                    <div class="price">' .  number_format((float)$item['price'],2,'.','') . '</div>
                    <div class="caption">
                    <h4>' .$item['name'] . '</h4>
                    <p>' .$item['description'] . '</p>
                    <a href="inscription.php" class="btn btn-order" role="button"><span class="glyphicon glyphicon-plus"></span>Commander</a>
                    </div>
                    </div>
                           
                    </div>';
                    
                }
               echo ' </div>
                </div>';
            }
            Database::disconnect();
            echo '</div>';
            ?>
                             
                
                
        </div>
        
    
    </body>
    
</html>