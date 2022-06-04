<?php
if (!session_id()) {
	session_start();
}
include_once 'connect.php';
include_once 'control.php';
$data = new Data();
if (!empty($_SESSION['user'])) {
	$result = $data->select_user($_SESSION['user']);
	$user = mysqli_fetch_assoc($result);
}
?>
<div id="header">
	<script>
		function onLoadAvatarErr(_this) {
			_this.src = 'images/avatar_default.png';
			_this.onerror = '';
		}
	</script>
	<div>
		<div class="logo">
			<a href="index.php">Zero Type</a>
		</div>
		<ul id="navigation">
			<li class="active">
				<a href="index.php">Home</a>
			</li>
			<li>
				<a href="news.php">News</a>
			</li>
			<li>
				<a href="contact.php">Contact</a>
			</li>
			<li>
				<a href="taikhoan.php">Tai khoan</a>
			</li>
			<li>
				<?php if (empty($_SESSION['user'])) { ?>
						<a href="login.php">Login</a> |
						<a href="register.php">Register</a>
				<?php } else {
					echo "<div>";
					if (!empty($user['avatar'])) {
						echo "<a href='update.php'><img style='width: 30px;height: 30px;border-radius: 50%;' src='{$user['avatar']}' onerror='onLoadAvatarErr(this)' /></a>";
					}
				?> |
					<a href="logout.php">Logout</a>
				<?php echo "</div>";
				} ?>
			</li>
		</ul>
	</div>
</div>