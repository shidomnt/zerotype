<?php
session_start();
include 'src/control.php';

$current_user_email = $_SESSION['user'];

if (empty($current_user_email)) {
	header('Location:login.php');
	exit();
}

$data = new Data();

$run = $data->select_user($current_user_email);

if (!empty($_GET['id'])) {
	$curr_user = mysqli_fetch_assoc($run);
	if ($curr_user['role'] == 0) {
		$run = $data->select_user_by_id($_GET['id']);
		if (!mysqli_num_rows($run)) {
			header('Location: update.php');
			exit();
		}
	}
}

foreach ($run as $value) {
	$id = $value['id'];
	$username = $value['username'];
	$email = $value['email'];
	$gender = $value['gender'];
	$hobby = $value['hobby'];
	$phone = $value['phone'];
	$avatar = $value['avatar'];
	$role = $value['role'];
}

$target_change = $email;

?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>Foods - Bhaccasyoniztas Beach Resort Website Template</title>
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

		.row {
			margin: 12px 0;
			display: flex;
		}

		.row:nth-child(7) {
			display: flex;
			justify-content: center;
		}

		.row .left {
			width: 120px;
		}

		.row .right {
			flex: 1;
		}

		.row .right input:not([type="radio"]):not([type="checkbox"]) {
			width: 100%;
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
							<h1>Thông tin tài khoản</h1>
							<form action="" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="left">Username</div>
									<div class="right"><input disabled required type="text" value="<?php echo $username ?>" name="txt_username"></div>
								</div>
								<div class="row">
									<div class="left">Gender</div>
									<div class="right">
										<input <?php echo $gender == 'nam' ? 'checked' : '' ?> type="radio" name="txt_gender" value="nam"> Male
										<input <?php echo $gender == 'nu' ? 'checked' : '' ?> type="radio" name="txt_gender" value="nu"> Female
									</div>
								</div>
								<div class="row">
									<div class="left">Email</div>
									<div class="right">
										<input required type="email" name="txt_email" value="<?php echo $email ?>">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="left">Phone</div>
									<div class="right"><input required type="text" value="<?php echo $phone ?>" name="txt_phone"></div>
								</div>
								<div class="row">
									<div class="left">Hobby</div>
									<div class="right">
										<input type="checkbox" name="txt_hobby[]" value="xemphim" <?php if (strstr($hobby, 'xemphim')) {
																																								echo 'checked';
																																							} ?>> Xem phim <br>
										<input type="checkbox" name="txt_hobby[]" value="coding" <?php if (strstr($hobby, 'coding')) {
																																								echo 'checked';
																																							} ?>> Coding <br>
										<input type="checkbox" name="txt_hobby[]" value="game" <?php if (strstr($hobby, 'game')) {
																																							echo 'checked';
																																						} ?>> Game <br>
									</div>
								</div>
								<div class="row">
									<div class="left">Avatar</div>
									<div class="right">
										<h5>Old Avatar</h5>
										<img style="width: 300px" src="<?php echo $avatar ?>" alt="old_avatar">
										<h5>New Avatar</h5>
										<input type="file" name="txt_avatar">
									</div>
								</div>
								<div class="row">
									<input type="submit" name="txt_submit" value="Update">
								</div>
								<div class="row">
									<div class="left">
										<a href="changepassword">Đổi mật khẩu</a>
									</div>
								</div>
							</form>
							<?php

							if (isset($_POST['txt_submit'])) {
								if (isset($_FILES['txt_avatar'])) {
									$avatar_src = "upload/{$_FILES['txt_avatar']['name']}";
									move_uploaded_file($_FILES['txt_avatar']['tmp_name'], $avatar_src);
								}
								$run = $data->update(
									$_POST['txt_gender'],
									$_POST['txt_email'],
									$_POST['txt_phone'],
									isset($_POST['txt_hobby']) ? implode(",", $_POST['txt_hobby']) : '',
									isset($avatar_src) ? $avatar_src : '',
									$target_change
								);
								if ($run) {
										header('Location: taikhoan.php');
								} else {
									echo 'Update that bai!';
								}
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