<html>
	<head>
		<!--
		Author: Parinaz Malek
		Date : 2020-05-27
		-->
		<meta name = "author" contact="Parinaz Malek"/>
		<meta name= "descreption" contact = "A site for Child Care"/>
		<meta name="keywords" content = "Child Care,Garderie,Daycare"/>
		<title>Daycare | Child Care | Garderie</title>
		<link href="../css/pageformat.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<img src="../img/logo.png" width=1330 height=332 alt="Child Care" usemap="#logomap" style="border-width: 0" />
		<map id = "logomap" name="logomap">
			<area shape="rect" coords="185, 290, 250, 332" href="../main.htm" alt="Home"/>
			<area shape="rect" coords="280, 290, 365, 332" href="../about.htm" alt="About Us"/>
			<area shape="rect" coords="400, 290, 480, 332" href="../program.htm" alt="Programs"/>
			<area shape="rect" coords="520, 290, 575, 332" href="../tution.htm" alt="Tution"/>
			<area shape="rect" coords="610, 290, 705, 332" href="../enrollment.htm" alt="Enrollment"/>
			<area shape="rect" coords="740, 290, 820, 332" href="../nutrition.htm" alt="Nutrition"/>
			<area shape="rect" coords="855, 290, 920, 332" href="../gallery.htm" alt="Gallery"/>
			<area shape="rect" coords="955, 290, 1020, 332" href="../contact.htm" alt="Contact Us"/>
			<area shape="rect" coords="1055, 290, 1120, 332" href="product.php" alt="product"/>
			<area shape="rect" coords="1155, 290, 1220, 332" href="../register.htm" alt="sign up"/>
			<area shape="rect" coords="1255, 290, 1300, 332" href="cart.php" alt="sign up"/>
		</map>
	    <div class="bodyContent">
		<?php
			
			include ("AccountTemplate.php");
			
			// connect to database
			$dbhost = "localhost";
			$dbuser = "root";
			$dbpass = "";
			$conn = mysqli_connect($dbhost, $dbuser, $dbpass, "daycaredb");
			
			if (!$conn){
				die("Could not connect: ".mysqli_error($conn));
			}
			echo "Connect Successfully<br/>";

			// variable declaration
			$username = "";
			$email    = "";
			$password_1 = "";
			$password_2 = "";
			$errors = array();

			$username = $_POST['username'];
			$email = $_POST['email'];
			$password_1 = $_POST['password_1'];
			$password_2 = $_POST['password_2'];

			// form validation
			if (empty($username)) { 
				array_push($errors, "Username is required");
				trigger_error("Username is required",E_USER_WARNING);
			}
			if (empty($email)) { 
				array_push($errors, "Email is required");
				trigger_error("Email is required",E_USER_WARNING);
			}
			if (empty($password_1)) { 
				array_push($errors, "Password is required");
				trigger_error("Password is required",E_USER_WARNING);
			}
			if ($password_1 != $password_2) {
				array_push($errors, "passwords are not match");
				trigger_error("passwords are not match",E_USER_WARNING);
			}
			
			$user_check_query = "SELECT * FROM account WHERE username='".$username."' OR email='".$email."' LIMIT 1;";
			mysqli_select_db($conn, "daycaredb");
			$result = mysqli_query($conn, $user_check_query);
			$user = mysqli_fetch_assoc($result);
  
			if ($user) { 
				if ($user['username'] === $username) {
					array_push($errors, "Username already exists");
					trigger_error("Username already exists",E_USER_WARNING);
				}

				if ($user['email'] === $email) {
					array_push($errors, "email already exists");
					trigger_error("email already exists",E_USER_WARNING);
				}
			}
			
			// register user if there are no errors in the form
			if (count($errors) == 0) {
				$password =($password_1);
				$user_account = new Account($username, $email, $password, "USER");
				$insert_query = "INSERT INTO account (date_account_open, username, password, email, user_type) 
								VALUES(CURDATE(), '".$user_account->getUsername()."', '".$user_account->getPassword()."', '".$user_account->getEmail()."', '".$user_account->getUser_type()."');";
				mysqli_query($conn, $insert_query);
		
				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($conn);
				$select_query = "SELECT * FROM account WHERE account_id=".$logged_in_user_id;
				$result = mysqli_query($conn, $select_query);
				$logged_in_user = mysqli_fetch_assoc($result);

				// put logged in user in session
				session_start();

				$_SESSION['username'] = $logged_in_user["username"]; 
				$_SESSION['password'] = $logged_in_user["password"]; 
				$_SESSION['email'] = $logged_in_user["email"]; 
				$_SESSION['user_type'] = $logged_in_user["user_type"]; 
				$_SESSION['account_id'] = $logged_in_user["account_id"]; 
				$_SESSION['success']  = "New user successfully created!!";		
				
				echo "You Successfully sign up<br/>";
				header("Refresh:3; url=../main.htm#login");
			
			}else{
					trigger_error("Please retry to register", E_USER_WARNING);
					header("Refresh:5; url=../register.htm");
				}
		?>
	</div>
		<div class="footerPnl">
			<ul>
				<li><a href="../main.htm" target="window">Home</a></li>
				<li><a href="../about.htm" target="window">About Us</a></li>
				<li><a href="../program.htm" target="window">Programs</a></li>
				<li><a href="../tution.htm" target="window">Tution</a></li>
				<li><a href="../enrollment.htm" target="window">Enrollment</a></li>
				<li><a href="../nutrition.htm" target="window">Nutrition</a></li>
				<li><a href="../gallery.htm" target="window">Gallery</a></li>
				<li><a href="../contact.htm" target="window">Contact Us</a></li>
				<li><a href="product.php" target="window">Product</a></li>
				<li><a href="../register.htm" target="window">Sign Up</a></li>
				<li><a href="cart.php" target="window">checkout</a></li>
			</ul>
		</div>
		<footer>&copy; Copyright 2020 God’s Little Treasures</footer>
		<br/>		
	</body>
</html>
