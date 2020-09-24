<?php
	session_start();
	$con = mysqli_connect("localhost","root","","daycaredb");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
		}
	$status="";
	if (isset($_POST['code']) && $_POST['code']!=""){
		$code = $_POST['code'];
		$result = mysqli_query($con,"SELECT * FROM `product` WHERE `code`='$code' ");
		$row = mysqli_fetch_assoc($result);
		$name = $row['name'];
		$code = $row['code'];
		$price = $row['price'];
		$image = $row['image'];

		$cartArray = array(
		$code=>array(
		'name'=>$name,
		'code'=>$code,
		'price'=>$price,
		'quantity'=>1,
		'image'=>$image));

		if(empty($_SESSION["shopping_cart"])) {
			$_SESSION["shopping_cart"] = $cartArray;
			$status = "<div class='box'>Product is added to your cart!</div>";
		}else{
			$array_keys = array_keys($_SESSION["shopping_cart"]);
			if(in_array($code,$array_keys)) {
				$status = "<div class='box' style='color:red;'>
				Product is already added to your cart!</div>";	
			} else {
				$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
				$status = "<div class='box'>Product is added to your cart!</div>";
			}

		}
	}
?>
<html>
	<head>
		<!--
		Author: Parinaz Malek
		Date : 2020-05-28
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
			<form method="POST" action="searchproduct.php">
				<input type="text" name="search" placeholder="Search for products ...">
				<input  type="submit" value=">>" />
			</form>
		<?php
			if(!empty($_SESSION["shopping_cart"])) {
			$cart_count = count(array_keys($_SESSION["shopping_cart"]));
			?>
			<div class="cart_div">
				<a href="cart.php"><img src="../img/cart-icon.png" /><span><?php echo $cart_count; ?></span></a>
			</div>
			<?php
			}
			if(isset($_POST['search'])){
					$searchq = $_POST['search'];
					$searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
					$result = mysqli_query($con,"SELECT * FROM product WHERE name LIKE '%$searchq%' ");
			while($row = mysqli_fetch_assoc($result)){
					echo "<div class='product_wrapper'>
						  <form method='post' action=''>
							<input type='hidden' name='code' value=".$row['code']." />
							<div class='image'><img src='".$row['image']."' /></div>
							<div class='name'>".$row['name']."</div>
							<div class='price'>$".$row['price']."</div>
							<button type='submit' class='buy'>Buy Now</button>
						  </form>
						  </div>";
				}
			
					}
			mysqli_close($con);
			?>

			<div style="clear:both;"></div>
			<div class="message_box" style="margin:10px 0px;">
			<?php echo $status; ?>
        </div>
		</div>
		<div class="footerPnl">
			<ul>
				<li><a href="main.htm" target="window">Home</a></li>
				<li><a href="about.htm" target="window">About Us</a></li>
				<li><a href="program.htm" target="window">Programs</a></li>
				<li><a href="tution.htm" target="window">Tution</a></li>
				<li><a href="enrollment.htm" target="window">Enrollment</a></li>
				<li><a href="nutrition.htm" target="window">Nutrition</a></li>
				<li><a href="gallery.htm" target="window">Gallery</a></li>
				<li><a href="contact.htm" target="window">Contact Us</a></li>
				<li><a href="product.php" target="window">Product</a></li>
				<li><a href="../register.htm" target="window">Sign Up</a></li>
				<li><a href="cart.php" target="window">checkout</a></li>
			</ul>
		</div>
		<footer>&copy; Copyright 2020 God’s Little Treasures</footer>
		<br/>		
	</body>
</html>