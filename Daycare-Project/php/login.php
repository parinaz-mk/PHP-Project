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

			mysqli_select_db($conn, "daycaredb");
			// variable declaration
			$username = "";
			$email    = "";
			$password = "";
			$errors = array();

			// receive all input
			$username_or_email = $_POST['username_or_email'];
			$password = $_POST['password'];

			// make sure form is filled properly
			if (empty($username_or_email)) {
				array_push($errors, "Username or Email is required");
				trigger_error("Username or Email is required", E_USER_WARNING);
			}
			if (empty($password)) {
				array_push($errors, "Password is required");
				trigger_error("Password is required", E_USER_WARNING);
			}

			// attempt login if no errors on form
			if (count($errors) == 0) {
				

				$query_username = "SELECT * FROM account WHERE username='".$username_or_email."' AND password='".$password."';";
				$query_email = "SELECT * FROM account WHERE email='".$username_or_email."' AND password='".$password."';";
								
				$results_username = mysqli_query($conn, $query_username);
				$results_email = mysqli_query($conn, $query_email);

				if (mysqli_num_rows($results_username)== 1) { // user found

					$logged_in_user = mysqli_fetch_assoc($results_username);

			
					// put logged in user in session 
					session_start();
				
					$_SESSION['username'] = $logged_in_user["username"]; 
					$_SESSION['password'] = $logged_in_user["password"]; 
					$_SESSION['email'] = $logged_in_user["email"]; 
					$_SESSION['user_type'] = $logged_in_user["user_type"];
					$_SESSION['account_id'] = $logged_in_user["account_id"];
					$_SESSION['success']  = "You are now logged in";
					
					if ($_SESSION['user_type'] == "admin" ) {
							echo "Welcome " .$_SESSION['username']."<br/>";
							echo $_SESSION['success'];	
							header("Refresh:3; url=../admin/editproduct.php");

						}else{
							echo "Welcome " .$_SESSION['username']."<br/>";
							echo $_SESSION['success'];						
							header("Refresh:3; url=../main.htm");
					}
					


				}else if(mysqli_num_rows($results_email)== 1){

					// need to check if ADMIN or USER
					$logged_in_user = mysqli_fetch_assoc($results_email);
				
					// put logged in user in session
					session_start();
				
					$_SESSION['username'] = $logged_in_user["username"]; 
					$_SESSION['password'] = $logged_in_user["password"]; 
					$_SESSION['email'] = $logged_in_user["email"]; 
					$_SESSION['user_type'] = $logged_in_user["user_type"]; 
					$_SESSION['account_id'] = $logged_in_user["account_id"];
					$_SESSION['success']  = "You are now logged in";
					
					if ($_SESSION['user_type'] == "admin" ) {
							echo "Welcome " .$_SESSION['username']."<br/>";
							echo $_SESSION['success'];	
							header("Refresh:3; url=../admin/editproduct.php");

						}else{
							echo "Welcome " .$_SESSION['username']."<br/>";
							echo $_SESSION['success'];						
							header("Refresh:3; url=../main.htm");
					}
					
				}else{
					array_push($errors, "Wrong username/password combination");
					trigger_error("Wrong username/password combination", E_USER_WARNING);
					header("Refresh:3; url=../main.htm#login");
				}
			
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