<?php
session_start();

if (empty($_SESSION['user'])) {
	header('Location:login.php');
	exit();
}

include 'src/control.php';

$data = new Data();

$result = $data->select_user($_SESSION['user']);

$user = mysqli_fetch_assoc($result);

$username = $user['username'];
$email = $user['email'];
$avatar = $user['avatar'];

?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>News - Bhaccasyoniztas Beach Resort Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<style>
		.avatar-container {
			text-align: center;
			margin-bottom: 30px;
		}
		.avatar-container img {
			--lenght: 150px;
			width: var(--lenght);
			height: var(--lenght);
			border-radius: 50%;
		}
		.btn-primary {
			display: inline-block;
			padding: 8px 12px;
			background-color: #0d6efd;
			color: white;
			border-radius: 4px;
			text-decoration: none;
		}
		.btn-group {
			text-align: center;
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
						<div class="body">
							<?php
							if (!empty($user['avatar'])) {
								echo '<div class="avatar-container">';
								echo "<a href='update.php'><img src='{$user['avatar']}' onerror='onLoadAvatarErr(this)' /></a>";
								echo "<div>$username</div>";
								echo "<div>$email</div>";
								echo '</div>';
							}
							?>
							<div class="btn-group">
								<a class="btn-primary" href="logout.php">Logout</a>
								<a class="btn-primary" href="update.php">Update</a>
								<a class="btn-primary" href="changepassword.php">Đổi mật khẩu</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include 'src/footer.php' ?>

	</div>
	<script src="js/main.js"></script>
</body>

</html>