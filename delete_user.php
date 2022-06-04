<?php
session_start();
include 'src/control.php';

$current_user_email = $_SESSION['user'];

if (empty($current_user_email)) {
  header('Location:login.php');
  exit();
}

if (empty($_GET['id'])) {
  header('Location:taikhoan.php');
  exit();
}

$data = new Data();

$run = $data->select_user($current_user_email);
$curr_user = mysqli_fetch_assoc($run);

$run = $data->select_user_by_id($_GET['id']);

if (!mysqli_num_rows($run)) {
  header('Location: taikhoan.php');
  exit();
}

$target_user = mysqli_fetch_assoc($run);

if ($curr_user['role'] == 0) {
  $run = $data->delete_user($target_user['email']);
  if ($run) {
    header('Location: taikhoan.php');
  } else {
    echo "Co loi xay ra khi xoa user";
  }
}
