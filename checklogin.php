<! DOCTYPE html>
<html>
	<head>
		<title>connexion </title>
		
		<!-- CSS only -->
		<link rel="stylesheet" href="mystyle.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	</head>

		<body>
		
		<?php 
		//reprendre une session existante
		if(isset($_POST['login']))
		{
			$email = $_POST['email'];//le variable $id= id qu'on recupere de la page precedente 
			
			$password = $_POST['password'];
			
			$connection = $con = mysqli_connect("localhost","root","","burger_code");//connexion a la base de donnée 
			
			$select_customer = "select * from user where email='$email' AND motdepasse='$password' "; //selectionner tout les element de la base de donnée où ID= le variable $id et Nom=$nom
			
			$run_customer = mysqli_query($connection,$select_customer);//envoie de la requete au serveur

			$check_customer = mysqli_num_rows($run_customer);//Retourne le nombre de lignes de la resultat 
			
			if($check_customer==0)//connexion echouée 
			{
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
				echo "<script>alert('identifients incorrecte.')</script>"; 
				echo"<center><h2>ID ou Nom incorecte !</h2></center>";
				echo '<center><a class="btn btn-success" href="inscription.php">ressayer</a></center>';
				exit();				
			}
			if($check_customer==1)//connexion reussie
			{
				$_SESSION['email']=$email;			
				include("index.php");
			   //echo "<script>alert('Bienvenue sur Parking.')</script>"; 			
			   //echo "<script>window.open('page.php')</script>";				
			}
		}
		?>
	</body>
</html>
