<?php
session_start();
include 'src/control.php';
include 'src/contact.php';
if (empty($_SESSION['user'])) {
	header('Location: login.php');
	exit();
}

$data = new Data();

$result = $data->select_user($_SESSION['user']);

$user = mysqli_fetch_array($result);

if ($user['role'] != 0) {
	echo '
	<script>
		window.alert("Ban khong co quyen!")
		window.location.href = "profile.php"
	</script>
	';
	exit();
}

$state = !empty($_GET['state']) ? $_GET['state'] : '';
?>
<!DOCTYPE HTML>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>Contact - Zerotype Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/main.css">
	<style>
		.table {
			/* width: 100%; */
			border-collapse: collapse;
			margin-bottom: 20px;
			margin-top: 40px;
		}

		.center {
			display: flex;
			flex-direction: column;
			align-items: center;
			min-height: 600px;
		}

		input[type="email"] {
			color: #aeaeae;
			font-size: 13px;
			height: 33px;
			line-height: 33px;
			width: 380px;
			border: 1px solid #d5d5d5;
			margin: 0 0 6px;
			padding: 0 4px;
		}
	</style>
</head>

<body>
	<?php include 'src/header.php' ?>
	<?php if ($state == 'new' || $state == 'update') {
		if ($state == 'update') {
			if (empty($_GET['id'])) {
				echo '<script>
				do {
					var id = window.prompt("Vui long nhap id hop le: ");
					if (id) {
						window.location.href = `contact.php?state=update&id=${id}`
					} else {
						window.location.href = `contact.php`
					}
				} while(!id);
				</script>';
				exit();
			}
			$result = Contact::getContactById($_GET['id']);
			$contact = mysqli_fetch_assoc($result);
			if (empty($contact)) {
				echo '<script>
				do {
					var id = window.prompt("Vui long nhap id hop le: ");
					if (id) {
						window.location.href = `contact.php?state=update&id=${id}`
					} else {
						window.location.href = `contact.php`
					}
				} while(id === "")
				</script>';
				exit();
			}
		}
	?>
		<div id="contents">
			<div class="section">
				<h1>Contact</h1>
				<p>
					You can replace all this text with your own text. Want an easier solution for a Free Website? Head straight to Wix and immediately start customizing your website! Wix is an online website builder with a simple drag & drop interface, meaning you do the work online and instantly publish to the web. All Wix templates are fully customizable and free to use. Just pick one you like, click Edit, and enter the online editor.
				</p>
				<form action="" method="post" class="message">
					<?php if ($state == 'update') { ?>
						<input hidden type="text" name="txt_id" value="<?= isset($contact) ? $contact['id'] : '' ?>">
					<?php } ?>
					<input type="text" value="<?= isset($contact) ? $contact['name'] : '' ?>" required name="txt_name" placeholder="Name" onFocus="this.select();" onMouseOut="javascript:return false;" />
					<input type="email" value="<?= isset($contact) ? $contact['email'] : '' ?>" required name="txt_email" placeholder="Email" onFocus="this.select();" onMouseOut="javascript:return false;" />
					<input type="text" value="<?= isset($contact) ? $contact['subject'] : '' ?>" required name="txt_subject" placeholder="Subject" onFocus="this.select();" onMouseOut="javascript:return false;" />
					<textarea name="txt_note"><?= isset($contact) ? $contact['note'] : '' ?></textarea>
					<input type="submit" name="txt_submit" value="<?= isset($contact) ? 'Update' : 'Send' ?>" />
				</form>
				<?php
				if ($state == 'new') {
					if (!empty($_POST['txt_submit'])) {
						$result = Contact::add(
							$_POST['txt_name'],
							$_POST['txt_email'],
							$_POST['txt_subject'],
							empty($_POST['txt_note']) ? '' : $_POST['txt_note']
						);
						if ($result) {
							echo '
						<script>
						window.alert("Thanh cong")
						window.location.href = "contact.php"
						</script>
						';
						} else {
							echo '
						<script>window.alert("That bai")</script>
						';
						}
					}
				} else if ($state == 'update') {
					if (!empty($_POST['txt_submit'])) {
						$result = Contact::update(
							$_POST['txt_id'],
							$_POST['txt_name'],
							$_POST['txt_email'],
							$_POST['txt_subject'],
							empty($_POST['txt_note']) ? '' : $_POST['txt_note']
						);
						if ($result) {
							echo '
							<script>
							alert("thanhcong")
							window.location.href = "contact.php"
							</script>';
						} else {
							echo '<script>alert("thatbai")</script>';
						}
					}
				}
				?>
			</div>
			<div class="section contact">
				<p>
					For Inquiries Please Call: <span>877-433-8137</span>
				</p>
				<p>
					Or you can visit us at: <span>ZeroType<br> 250 Business ParK Angel Green, Sunville 109935</span>
				</p>
			</div>
		</div>
	<?php
	} else if ($state == 'delete') {
		if (empty($_GET['id'])) {
			echo '<script>
						do {
							var id = window.prompt("Vui long nhap id hop le: ");
							if (id) {
								window.location.href = `contact.php?state=delete&id=${id}`
							} else {
								window.location.href = `contact.php`
							}
						} while(!id);
						</script>';
			exit();
		}
		$result = Contact::delete($_GET['id']);
		if ($result) {
			echo '
					<script>window.location.href = `contact.php`</script>
					';
		} else {
			echo '
					<script>window.alert("Xay ra loi khi xoa")</script>
					';
		}
	} else {
		$result = Contact::select_all();
	?>
		<div class="contents center">
			<table class="table" border="1" cellpadding="4" cellspacing="0">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Subject</th>
						<th>Note</th>
						<th colspan="2">Option</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($result as $contact) {
						echo "
					<tr>
						<td>{$contact['id']}</td>
						<td>{$contact['name']}</td>
						<td>{$contact['email']}</td>
						<td>{$contact['subject']}</td>
						<td>{$contact['note']}</td>
						<td>
							<a href='?state=update&id={$contact['id']}'>Sửa</a>
						</td>
						<td>
							<a href='?state=delete&id={$contact['id']}' class='delete-btn'>Xóa</a>
						</td>
						</tr>
					";
					}
					?>
				</tbody>
			</table>
			<div style="text-align: center;">
				<a href="?state=new" class="btn-primary">New</a>
			</div>
		</div>
	<?php } ?>
	<div id="footer">
		<div class="clearfix">
			<div id="connect">
				<a href="http://freewebsitetemplates.com/go/facebook/" target="_blank" class="facebook"></a><a href="http://freewebsitetemplates.com/go/googleplus/" target="_blank" class="googleplus"></a><a href="http://freewebsitetemplates.com/go/twitter/" target="_blank" class="twitter"></a><a href="http://www.freewebsitetemplates.com/misc/contact/" target="_blank" class="tumbler"></a>
			</div>
			<p>
				© 2023 Zerotype. All Rights Reserved.
			</p>
		</div>
	</div>
	<script src="js/main.js"></script>
</body>

</html>