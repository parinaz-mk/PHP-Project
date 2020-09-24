<?php
	session_start();
	$con = mysqli_connect("localhost","root","","daycaredb");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
		}
		$status="";
		if (isset($_POST['action']) && $_POST['action']=="remove"){
		if(!empty($_SESSION["shopping_cart"])) {
		foreach($_SESSION["shopping_cart"] as $key => $value) {
		if($_POST["code"] == $key){
		unset($_SESSION["shopping_cart"][$key]);
		$status = "<div class='box' style='color:red;'>
		Product is removed from your cart!</div>";
		}
		if(empty($_SESSION["shopping_cart"]))
		unset($_SESSION["shopping_cart"]);
			}		
		}
}

	if (isset($_POST['action']) && $_POST['action']=="change"){
	  foreach($_SESSION["shopping_cart"] as &$value){
		if($value['code'] === $_POST["code"]){
			$value['quantity'] = $_POST["quantity"];
			break; // Stop the loop after we've found the product
    }
}
  	
}
		$account_id = $_SESSION['account_id'];
		$query = "SELECT * FROM 
			account a , child c ,  parent p , department d
			WHERE a.account_id = c.account_id and a.account_id=p.account_id and d.d_id=c.d_id and c.d_id = d.b_id ;";
			
			/*Execute query*/
			$Result = mysqli_query($con,$query) or die (mysqli_error($con));
			
			$total = 0;
			
			while ($Record = mysqli_fetch_assoc($Result))
			{
				$u_email = $Record["email"];
				$u_accountid = $Record["account_id"];
				$u_firstname= $Record["p_fname"];
				$u_lastname = $Record["p_lname"];
				$u_price = $Record["d_price"];
				$u_dname = $Record["d_name"];


				if ($u_accountid == $account_id ){
				 
					$total = $total +$u_price;

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

			<?php
				if(!empty($_SESSION["shopping_cart"])) {
				$cart_count = count(array_keys($_SESSION["shopping_cart"]));
			?>
			<div class="cart_div">
				<a href="cart.php"><img src="../img/cart-icon.png" /><span><?php echo $cart_count; ?></span></a>
			</div>
			<?php
			}
			?>

			<div class="cart" >
				<?php
					if(isset($_SESSION["shopping_cart"])){
					$total_price = 0;
				?>	
				<table class="table">
					<caption style="color:red">Products Bill</caption>
					<thead style="color:blue">
						<tr>
							<td></td>
							<td>ITEM NAME</td>
							<td>QUANTITY</td>
							<td>UNIT PRICE</td>
							<td>ITEMS TOTAL</td>
						</tr>
					</thead>
					<tbody>
						<?php		
							foreach ($_SESSION["shopping_cart"] as $product){
						?>
						<tr>
							<td><img src='<?php echo $product["image"]; ?>' width="50" height="40" /></td>
							<td><?php echo $product["name"]; ?><br />
								<form method='post' action=''>
									<input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
									<input type='hidden' name='action' value="remove" />
									<button type='submit' class='remove'>Remove Item</button>
								</form>
							</td>
							<td>
								<form method='post' action=''>
									<input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
									<input type='hidden' name='action' value="change" />
									<select name='quantity' class='quantity' onchange="this.form.submit()">
										<option <?php if($product["quantity"]==1) echo "selected";?> value="1">1</option>
										<option <?php if($product["quantity"]==2) echo "selected";?> value="2">2</option>
										<option <?php if($product["quantity"]==3) echo "selected";?> value="3">3</option>
										<option <?php if($product["quantity"]==4) echo "selected";?> value="4">4</option>
										<option <?php if($product["quantity"]==5) echo "selected";?> value="5">5</option>
									</select>
								</form>
							</td>
							<td><?php echo "$".$product["price"]; ?></td>
							<td><?php echo "$".$product["price"]*$product["quantity"]; ?></td>
						</tr>
						<?php
							$total_price += ($product["price"]*$product["quantity"]);
							}
						?>
						<tr>
							<td colspan="5" align="right">
								<strong>TOTAL: <?php echo "$".$total_price; ?></strong>
							</td>
						</tr>
						</tbody>
					</table>
					<?php
						}else{
						 $total_price = 0;
						}
					?>
				<div style="clear:both;"></div>
				<div class="message_box" style="margin:10px 0px;">
					<?php echo $status; ?>
				</div>
			</div>
			
			<table class="table">
				<caption style="color:red">Service Bill</caption>
				<thead style="color:blue">
					<tr>
						<td></td>
						<td>SERVICE NAME</td>
						<td>PERIOD</td>
						<td>PRICE per DAY</td>
						<td>TOTAL</td>
					</tr>
				<thead>
				<tbody>
					<?php
					if(!isset($u_price)){
						$period = 365; 
						$totalservice= 0;
						$u_price=0;
					}
					else {
						$period = 365; 
						$totalservice= 0;
						$totalservice = $period*$u_price;}
						$text = "no registration record "?>
					
					
					<tr>
						<td></td>
						<td><?php if(isset($u_dname)){echo $u_dname;} else {echo $text;} ?></td>
						<td>365 days (1year contract)</td>
						<td><?php echo "$".$u_price; ?></td>
						<td><?php echo "$".$totalservice; ?></td>
					<tr>				
				</tbody>
			</table>

			</div>
			<div class="contactPnl">
					<?php if(isset($u_firstname)&&($u_firstname) ){?>
						<p> name:&emsp;<?php echo $u_firstname." ".$u_lastname; ?></h5><br/>
							email:&emsp;<?php echo $u_email; ?></h5><br/>
							date:&emsp;<?php
							$currentDateTime = date('Y-m-d H:i:s');
							echo $currentDateTime;
							?><br/></p>
				
						
					<?php }else{?>

							<p> name:&emsp;please first <a href="../register.htm"> sign up</a><br/>
							email:&emsp;please first <a href="../register.htm"> sign up</a><br/>
							date:&emsp;<?php
							$currentDateTime = date('Y-m-d H:i:s');
							echo $currentDateTime;
							?><br/></p>
						
					<?php } ?>

					
					<table>
					<caption style="color:white">Final Bill</caption>
					<hr style="color:white"/>
					<hr style="color:white"/>
						<tr style="color:white">
							<td><strong>Total Product&emsp;</strong></td>
							<td><?php echo "$".$total_price; ?></td>
						</tr>
						<tr style="color:white">
							<td style="color:white"><strong>Total Service&emsp;</strong></td>
							<td ><?php echo "$".$totalservice ?></td>
						</tr>
						<tr style="color:white">
							<td><strong>Total&emsp;</strong></td>
							<td><strong> <?php echo "$".($totalservice+$total_price); ?></strong></td>
						</tr>
					<table>
					
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