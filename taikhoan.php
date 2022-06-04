<?php session_start();
include 'src/control.php';
if (empty($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}
$data = new Data();
$result = $data->select_user($_SESSION['user']);
$user = mysqli_fetch_assoc($result);
if ($user['role'] != 0) {
  header('Location: update.php');
  exit();
}

?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
  <meta charset="UTF-8">
  <title>Foods - Bhaccasyoniztas Beach Resort Website Template</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/main.css">
  <style>
    .body table {
      width: 100%;
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
              <table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse;">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Hobby</th>
                    <th>Avatar</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $r = $data->select_user('all');
                  while ($row = mysqli_fetch_assoc($r)) {
                    echo "<tr>";
                    echo "
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['hobby']}</td>
                    <td>{$row['avatar']}</td>
                    <td>{$row['role']}</td>
                    ";
                    echo "<td>
                      <a href='update.php?id={$row['id']}'>Sửa</a>
                      <a class='delete-btn' href='delete_user.php?id={$row['id']}'>Xóa</a>
                    </td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
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