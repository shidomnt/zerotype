<?php
include 'src/control.php';
if (isset($_POST['txt_submit'])) {
	if (empty($_POST['txt_email']) || empty($_POST['txt_username'] || empty($_POST['txt_password']))) {
		echo "<script>alert('Vui long nhap day du cac truong')</script>";
	} else {
		$data = new Data();
		if (isset($_FILES['txt_avatar'])) {
			$check_type = true || $_FILES['txt_avatar']['type'];
			if ($check_type) {
				$url = 'upload/' . $_FILES['txt_avatar']['name'];
				move_uploaded_file($_FILES['txt_avatar']['tmp_name'], $url);
			}
		}
		$statusCode = $data->register(
			$_POST['txt_username'],
			$_POST['txt_gender'],
			$_POST['txt_email'],
			$_POST['txt_phone'],
			$_POST['txt_password'],
			isset($_POST['txt_hobby']) ? implode(",", $_POST['txt_hobby']) : '',
			isset($url) ? $url : ''
		);
		if ($statusCode == 0) {
			header('Location: login.php');
		}
	}
}
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>About - Bhaccasyoniztas Beach Resort Web Template</title>
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
		}

		.width-100 {
			width: 100%;
		}

		.row {
			margin: 12px 0;
			display: flex;
		}

		.row:last-child {
			display: flex;
			justify-content: center;
		}

		.row .left {
			width: 80px;
		}

		form {
			border: 1px solid #5a4535;
			padding: 20px;
		}

		input {
			padding: 4px;
		}

		input[type="submit"] {
			background-color: #868fff;
			padding: 8px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
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
						<div class="body main">
							<h1>Register</h1>
							<form action="" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="left">Username</div>
									<div class="right"><input required type="text" value="<?php if (isset($statusCode)) {
																																					echo $statusCode == 13 ? $_POST['txt_username'] : '';
																																				}  ?>" name="txt_username"></div>
								</div>
								<div class="row">
									<div class="left">Gender</div>
									<div class="right">
										<input checked type="radio" name="txt_gender" value="nam"> Male
										<input type="radio" name="txt_gender" value="nu"> Female
									</div>
								</div>
								<div class="row">
									<div class="left">Email</div>
									<div class="right">
										<input required type="email" name="txt_email">
										<br>
										<?php if (isset($statusCode)) {
											echo $statusCode == 13 ? "<span style='color: red;'>{$data->statusCode($statusCode)}</span>" : '';
										} ?>
									</div>
								</div>
								<div class="row">
									<div class="left">Phone</div>
									<div class="right"><input required type="text" value="<?php if (isset($statusCode)) {
																																					echo $statusCode == 13 ? $_POST['txt_phone'] : '';
																																				}  ?>" name="txt_phone"></div>
								</div>
								<div class="row">
									<div class="left">Password</div>
									<div class="right"><input required type="password" name="txt_password"></div>
								</div>
								<div class="row">
									<div class="left">Hobby</div>
									<div class="right">
										<input type="checkbox" name="txt_hobby[]" value="xemphim"> Xem phim <br>
										<input type="checkbox" name="txt_hobby[]" value="coding"> Coding <br>
										<input type="checkbox" name="txt_hobby[]" value="game"> Game <br>
									</div>
								</div>
								<div class="row">
									<div class="left">Avatar</div>
									<div class="right"><input type="file" name="txt_avatar"></div>
								</div>
								<div class="row">
									<input type="submit" name="txt_submit" value="Register">
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