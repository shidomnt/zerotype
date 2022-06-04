<?php
if (!session_id()) {
  session_start();
}
include_once 'src/connect.php';
include_once 'control.php';

class News
{
  public static function getPopularPosts() {
    global $conn;
    $sql =
    "SELECT news.*, users.username as author 
    FROM 
    news INNER JOIN users 
    ON news.user_id = users.id 
    ORDER BY number DESC
    LIMIT 3
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function delete( $id) {
    global $conn;
    $sql = 
    "DELETE FROM news
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function update(
     $id,
     $title,
     $category_id,
     $summary,
     $content
  ) {
    global $conn;
    $sql = 
    "UPDATE news
    SET title='$title',
    category_id = '$category_id',
    s_content = '$summary',
    l_content = '$content'
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getNewById( $id)
  {
    global $conn;
    $sql =
      "SELECT news.*, users.username as author 
      FROM 
      news INNER JOIN users 
      ON news.user_id = users.id 
    WHERE news.id = $id";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getCategoryById($id)
  {
    global $conn;
    $sql = "SELECT * FROM categories
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getAuthorById( $id)
  {
    $data = new Data();
    $run = $data->select_user_by_id($id);
    return $run;
  }
  public static function getAllNews()
  {
    global $conn;
    $sql =
    "SELECT news.*, users.username as author 
    FROM 
    news INNER JOIN users 
    ON news.user_id = users.id 
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getAllCategories()
  {
    global $conn;
    $sql = 'SELECT * FROM categories';
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function create(
     $title,
     $category_id,
     $summary,
     $content
  ) {
    global $conn;
    $data = new Data();
    $result = $data->select_user($_SESSION['user']);
    $user = mysqli_fetch_assoc($result);
    $date = date('Y/m/d');
    $user_id = $user['id'];
    $sql = "INSERT INTO
    news(category_id, user_id, title, s_content, l_content, date)
    VALUES
    ($category_id, $user_id, '$title', '$summary', '$content','$date')
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
}
