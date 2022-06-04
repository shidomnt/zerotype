<?php 
include 'connect.php';

class Contact {
  public static function add(
    $name,
    $email,
    $subject,
    $note
  ) {
    global $conn;
    $sql = 
    "INSERT INTO contacts(name, email, subject, note)
    VALUES ('$name', '$email', '$subject', '$note')
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }

  public static function select_all() {
    global $conn;
    $sql = 'SELECT * FROM contacts';
    $run = mysqli_query($conn, $sql);
    return $run;
  }

  public static function getContactById($id) {
    global $conn;
    $sql =
    "SELECT * FROM contacts WHERE id = $id";
    $run = mysqli_query($conn, $sql);
    return $run;
  }

  public static function update(
    $id,
    $name,
    $email,
    $subject,
    $note
  ) {
    global $conn;
    $sql = 
    "UPDATE contacts
    SET 
    name = '$name',
    email = '$email',
    subject = '$subject',
    note = '$note'
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function delete($id) {
    global $conn;
    $sql = 
    "DELETE FROM contacts
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
}