<?php
session_start();
include 'src/control.php';
include 'src/new.php';

if (empty($_GET['id'])) {
	echo '<script>
				let id;
				do {
					id = window.prompt("Vui long nhap id hop le: ");
					if (id) {
						window.location.href = `post.php?id=${id}`
					} else {
						window.location.href = `news.php`
					}
				} while(!id);
				</script>';
	exit();
}
$result = News::getNewById($_GET['id']);
$new = mysqli_fetch_assoc($result);
if (empty($new)) {
	echo '<script>
				let id;
				do {
					id = window.prompt("Vui long nhap id hop le: ");
					if (id) {
						window.location.href = `post.php?id=${id}`
					} else {
						window.location.href = `news.php`
					}
				} while(id === "")
				</script>';
	exit();
}
?>
<!DOCTYPE HTML>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>News title - Zerotype Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<style>
		p {
			word-break: break-word;
		}
	</style>
</head>

<body>
	<?php include 'src/header.php' ?>

	<div id="contents">
		<div class="post">
			<div class="date">
				<p>
					<span><?php echo date('m', strtotime($new['date'])) ?></span>
					<?php echo date('Y', strtotime($new['date'])) ?>
				</p>
			</div>
			<h1>
				<?php echo $new['title'] ?>
				<span class="author"><?php echo $new['author'] ?></span>
			</h1>
			<p>
				<?php echo $new['l_content']; ?>
			</p>
			<span><a href="news.php" class="more">Back to News</a></span>
		</div>
	</div>
	<?php include 'src/footer.php' ?>
</body>

</html>