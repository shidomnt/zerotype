<?php
session_start();
include 'src/control.php';

if (isset($_SESSION['user'])) {
	header('Location: profile.php');
}
if (isset($_POST['txt_submit'])) {
	$data = new Data();
	$statusCode = $data->login_user($_POST['txt_email'], $_POST['txt_password']);
	if ($statusCode == 0) {
		header('Location: profile.php');
	}
}
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>Contact - Bhaccasyoniztas Beach Resort Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		.main {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		form {
			text-align: center;
			width: 250px;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		input {
			padding: 6px;
			margin: 5px 0;
			width: 100%;
		}

		input[type="submit"] {
			background-color: #868fff;
			padding: 8px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		.actions {
			width: 100%;
			display: flex;
			justify-content: space-between;
		}
		#contact form input {
			height: unset;
			width: 100%;
		}
		
		#contents {
			width: 100%;
		}
		
.main {
  float: unset !important;
  width: unset !important;
}
	</style>
</head>

<body>
	<div id="background">
		<div id="page">
			<?php include 'src/header.php' ?>
			<div id="contents">
				<div class="box">
					<div>
						<div id="contact" class="body main">
							<h1>Login</h1>
							<form method="POST" autocomplete="on">
								<input required type="email" name="txt_email" placeholder="Email" value="<?php if (isset($statusCode)) {
																																														echo $statusCode == 11 ? $_POST['txt_email'] : '';
																																													} ?>"> <br />
								<input required type="password" name="txt_password" placeholder="Password"> <br>
								<input type="submit" name="txt_submit" value="Login"> <br>
								<div class="actions">
									<a href="register.php">Register</a>
									<a href="changepassword.php">Forgot Password?</a>
								</div>
							</form>
							<?php
							if (isset($statusCode)) {
								echo $data->statusCode($statusCode);
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include 'src/footer.php' ?>
		
	</div>
</body>

</html>