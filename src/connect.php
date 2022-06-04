<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'zerotype';
$conn = mysqli_connect($server, $user, $pass, $db);
mysqli_query($conn, 'set names "utf8"');
?>