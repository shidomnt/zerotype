<?php

include 'connect.php';
class Data
{
  public function delete_user($email) {
    global $conn;
    $sql = "
    DELETE FROM users
    WHERE email = '$email'
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public function change_password($old_password, $new_password, $user = null) {
    global $conn;
    $check = true;
    if (empty($user)) {
      $user = $_SESSION['user'];
    }
    $num = mysqli_num_rows($this->select_user($user));
    $is_exist = $num != 0;
    if (!$is_exist) {
      return 14;
    }
    if (!empty($old_password)) {
      // mật khẩu cũ có đúng không
      $check = $this->login($user, $old_password); 
    }
    if ($check) {
      $sql = "
      UPDATE users
      SET password = '$new_password'
      WHERE email = '{$user}'
      ";
      $run = mysqli_query($conn, $sql);
      return 0;
    } else {
      return 11;
    }
  }

  public function update($gender, $email, $phone, $hobby, $avatar = '', $user = null)
  {
    global $conn;
    $user = empty($user) ? $_SESSION['user'] : $user;
    $num = 0;
    if ($email != $user) { //Có đổi email mới hay không
      $run = $this->select_user($email); // Email mới đổi tồn tại hay chưa
      $num = (int) mysqli_num_rows($run);
    }
    if (!$num) {
      $sql = "
      UPDATE users
      SET gender = '$gender',
      email = '$email',
      phone = '$phone',
      hobby = '$hobby',
      avatar = '$avatar'
      WHERE email = '$user'
      ";
      $run = mysqli_query($conn, $sql);
      if ($user == $_SESSION['user']) {
        $_SESSION['user'] = $email; // Đổi email lưu trong session thành email mới
      }
      return $run;
    }
    return 13; // Email da duoc su dung
  }
  public function register($username, $gender, $email, $phone, $pass, $hobby, $avatar = '', $role = 2)
  {
    global $conn;
    $run = $this->select_user($email);
    $num = mysqli_num_rows($run);
    if (!$num) {
      $sql = "INSERT INTO users(username, gender, email, phone, password, hobby, avatar, role) 
    VALUES ('$username', '$gender', '$email', '$phone', '$pass', '$hobby', '$avatar', '$role')";
      $run = mysqli_query($conn, $sql);
      return 0;
    } else {
      return 13; // User da ton tai
    }
  }
  public function select_user_by_id($id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public function select_user($email)
  {
    global $conn;
    if ($email == 'all') {
      $sql = "SELECT * FROM users";
    } else {
      $sql = "SELECT * FROM users WHERE email = '$email'";
    }
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public function login_user($email, $password)
  {
    $run = $this->select_user($email);
    $num = mysqli_num_rows($run);
    if ($num == 1) {
      $check = $this->login($email, $password);
      if ($check) {
        $_SESSION['user'] = $email;
        return 0;
      } else {
        return 11; // Sai pass
      }
    } else {
      return 12; // Sai username
    }
  }
  public function statusCode($statusCode)
  {
    switch ($statusCode) {
      case 0:
        return 'Thanh cong';
      case 11:
        return 'Sai password';
      case 12:
        return 'Sai username';
      case 13:
        return 'Vui long nhap email khac';
      case 14:
        return 'Email khong ton tai';
      default:
        return 'Loi khong xac dinh';
    }
  }
  public function login($email, $password)
  {
    global $conn;
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $run = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($run);
    return $num == 1;
  }
  public function insert()
  {
    global $conn;
    $sql = "";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public function select()
  {
  }
  public function delete()
  {
  }
}
