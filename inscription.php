<?php
    require 'admin/database.php';
?>
<!DOCTYPE html>
<html>
    <head> 
         <title> McMo </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    </head>
    
    <body>
        <header>
           
        </header>
        <div class="form-group col-md-4 ">
        </div>
        
        <div class="container">
        <div class="form-group col-md-4 inscription-box">
            <h3>Vous n'avez pas un compte ?</h3>
            <form>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Nom</label>
                  <input type="text" class="form-control" name="inputnom" placeholder="">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">Prénom</label>
                  <input type="text" class="form-control" name="inputprenom" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="inputAddress">email</label>
                <input type="email" class="form-control" name="inputemail" placeholder="">
              </div>
              <div class="form-group">
                <label for="inputAddress2">mot de passe</label>
                <input type="password" class="form-control" name="inputpassword" placeholder="">
              </div>
              
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="gridCheck">
                  <label class="form-check-label" for="gridCheck">
                    Check me out
                  </label>
                </div>
              </div>
              <center><button type="submit" class="btn btn-primary">Je m'inscris</button></center>
            </form>
            <br>
            <div class="separation">
            <h3></h3></div>
            <br>
            <h3>Vous avez deja un compte ?</h3>
            <form method="post" action="checklogin.php">
                <div class="form-group">
                <label for="inputAddress">email</label>
                <input type="email" class="form-control" name="email" placeholder="">
              </div>
              <div class="form-group">
                <label for="inputAddress2">mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder="">
              </div>
              <center><button type="submit" class="btn btn-primary" name="login">Je me connecte</button></center>
            </form>
        </div>
        </div>
    </body>

</html>