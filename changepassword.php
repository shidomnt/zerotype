<?php
session_start();
include 'src/control.php';

$is_forgot = empty($_SESSION['user']);

// if (empty($_SESSION['user'])) {
// 	header('Location:login.php');
// 	exit();
// }
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>Dive Sites - Bhaccasyoniztas Beach Resort Website Template</title>
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

		.row:last-child {
			display: flex;
			justify-content: center;
		}

		.row .left {
			width: 200px;
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
							<?php 
							if ($is_forgot) {
							?>
							<h2>Quên mật khẩu</h2>
							<?php } else { ?>
							<h2>Đổi mật khẩu</h2>
							<?php } ?>
							<form action="" method="post" enctype="multipart/form-data">
							<?php 
							if (!$is_forgot) {
							?>
								<div class="row">
									<div class="left">Mật khẩu cũ</div>
									<div class="right"><input placeholder="Mật khẩu cũ" required type="password" name="txt_old_password"></div>
								</div>
							<?php } else { ?>
								<div class="row">
									<div class="left">Email</div>
									<div class="right"><input placeholder="Nhập email" required type="email" name="txt_email"></div>
								</div>
								<?php } ?>
								<div class="row">
									<div class="left">Mật khẩu mới</div>
									<div class="right"><input placeholder="Mật khẩu mới" required type="password" name="txt_new_password"></div>
								</div>
								<div class="row">
									<div class="left">Nhập lại mật khẩu mới</div>
									<div class="right"><input placeholder="Nhập lại mật khẩu mới" required type="password" name="txt_confirm_new_password"></div>
								</div>
								<div class="row">
									<input type="submit" name="txt_submit" value="Thay đổi">
								</div>
							</form>
							<?php
							$data = new Data();

							if (isset($_POST['txt_submit'])) {
								if ($_POST['txt_new_password'] == $_POST['txt_confirm_new_password']) {
									$statusCode = $data->change_password(
										$is_forgot ? '' : $_POST['txt_old_password'],
										$_POST['txt_new_password'],
										$is_forgot ? $_POST['txt_email'] : $_SESSION['user']
									);
									if (!$statusCode) {
										unset($_SESSION['user']); // xóa session user, bắt đăng nhập lại
										header('Location: login.php');
									} else {
										echo $data->statusCode($statusCode);
									}
								} else {
									echo 'Xác nhận mật khẩu không chính xác';
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