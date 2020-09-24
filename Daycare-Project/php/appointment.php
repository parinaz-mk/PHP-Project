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
						
						
			// connect to database
			$dbhost = "localhost";
			$dbuser = "root";
			$dbpass = "";
			$conn = mysqli_connect($dbhost, $dbuser, $dbpass, "daycaredb");
			
			if (!$conn){
				die("Could not connect: ".mysqli_error($conn));
			}

			mysqli_select_db($conn, "daycaredb");
			$day = $_POST['day'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$date = date("Y-m-d", mktime(0,0,0,$month, $day, $year));
			$b_id = $_POST['daycare'];
			//Define a query
			$query1 = "INSERT INTO appointment (a_name, a_email, a_subject, a_visitdate, a_comment , b_id) 
			Values ('$_POST[name]','$_POST[email]','$_POST[subject]','$date','$_POST[comment]',$b_id);";
			//Execute query
			$valueformResult = mysqli_query($conn,$query1) or die (mysqli_error($conn));
			
			echo "Your Message sent Successfully.<br/><br/> We will arreng a visit and send you a Message";
			
			
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

