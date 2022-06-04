<?php
session_start();
include 'src/control.php';
include 'src/new.php';
$data = new Data();
$is_admin = 0;

if (!empty($_SESSION['user'])) {
  $result = $data->select_user($_SESSION['user']);
  $user = mysqli_fetch_assoc($result);
  if ($user['role'] == 0) {
    $is_admin = 1;
  }
}
$state = !empty($_GET['state']) ? $_GET['state'] : '';

?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
  <meta charset="UTF-8">
  <title>About - Bhaccasyoniztas Beach Resort Web Template</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/main.css">
  <style>
    .m-b {
      margin-bottom: 16px;
    }

    .width-100 {
      width: 100%;
    }

    .row {
      margin: 12px 0;
      display: flex;
      justify-content: space-between;
    }

    .row.j-center {
      display: flex;
      justify-content: center;
    }

    .row .left {
      width: 40%;
      text-align: right;
    }

    .row .right {
      width: 50%;
    }

    form {
      border: 1px solid #5a4535;
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    input {
      padding: 4px;
    }

    input[type="submit"] {
      background-color: #868fff;
      padding: 8px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    textarea {
      resize: none;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table td {
      text-align: justify;
    }

    .btn-primary {
      display: inline-block;
      padding: 8px 12px;
      background-color: #0d6efd;
      color: white;
      border-radius: 4px;
      text-decoration: none;
    }

    div.main>ul>li>h2>div {
      display: flex;
      justify-content: space-between;
    }

    div.main>ul>li>h2>div>a {
      font-size: 16px;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <?php include 'src/header.php' ?>
  <div id="contents">
    <div class="main">
      <h1>News</h1>
      <ul class="news">
        <?php if ($state == 'new' || $state == 'update' && $is_admin) {
          if ($state == 'update') {
            if (empty($_GET['id'])) {
              echo '<script>
                    do {
                      var id = window.prompt("Vui long nhap id hop le: ");
                      if (id) {
                        window.location.href = `news.php?state=update&id=${id}`
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
                    do {
                      var id = window.prompt("Vui long nhap id hop le: ");
                      if (id) {
                        window.location.href = `news.php?state=update&id=${id}`
                      } else {
                        window.location.href = `news.php`
                      }
                    } while(id === "")
                    </script>';
              exit();
            }
          }
        ?>
          <?php if ($state == 'update') { ?>
            <h1>Update Post</h1>
          <?php } else { ?>
            <h1>New Post</h1>
          <?php } ?>
          <form action="" method="post" autocomplete="off">
            <?php if ($state == 'update') { ?>
              <input hidden type="text" name="txt_id" value="<?= isset($new) ? $new['id'] : '' ?>">
            <?php } ?>
            <div class="row">
              <div class="left">Title</div>
              <div class="right">
                <input required type="text" name="txt_title" value="<?= isset($new) ? $new['title'] : '' ?>">
              </div>
            </div>
            <div class="row">
              <div class="left">Category</div>
              <div class="right">
                <select name="txt_category">
                  <?php
                  $result = News::getAllCategories();
                  foreach ($result as $row) {
                    $is_selected = '';
                    if ($state == 'update' && $row['id'] == $new['category_id']) {
                      $is_selected = 'selected';
                    }
                    echo "
                      <option $is_selected value='{$row['id']}'>{$row['name']}</option>
                    ";
                  } ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="left">Summary</div>
              <div class="right">
                <textarea name="txt_summary" cols="30" rows="8"><?= isset($new) ? $new['s_content'] : '' ?></textarea>
              </div>
            </div>
            <div class="row">
              <div class="left">Content</div>
              <div class="right">
                <textarea name="txt_content" required cols="30" rows="8"><?= isset($new) ? $new['l_content'] : '' ?></textarea>
              </div>
            </div>
            <div class="row j-center">
              <input type="submit" name="txt_submit" value="<?php echo $state == 'new' ? 'Create' : 'Update' ?>">
            </div>
            <?php
            if ($state == 'new') {
              if (!empty($_POST['txt_submit'])) {
                $result = News::create(
                  $_POST['txt_title'],
                  $_POST['txt_category'],
                  $_POST['txt_summary'],
                  $_POST['txt_content']
                );
                if ($result) {
                  echo '<script>alert("thanhcong")</script>';
                  echo '<script>window.location.href = "news.php"</script>';
                } else {
                  echo '<script>alert("thatbai")</script>';
                }
              }
            } else if ($state == 'update') {
              if (!empty($_POST['txt_submit'])) {
                $result = News::update(
                  $_POST['txt_id'],
                  $_POST['txt_title'],
                  $_POST['txt_category'],
                  $_POST['txt_summary'],
                  $_POST['txt_content']
                );
                if ($result) {
                  echo '<script>alert("thanhcong")</script>';
                  echo '<script>window.location.href = "news.php"</script>';
                } else {
                  echo '<script>alert("thatbai")</script>';
                }
              }
            }
            ?>
          </form>
        <?php
        } else if ($state == 'delete' && $is_admin) {
          if (empty($_GET['id'])) {
            echo '<script>
                    do {
                      var id = window.prompt("Vui long nhap id hop le: ");
                      if (id) {
                        window.location.href = `news.php?state=delete&id=${id}`
                      } else {
                        window.location.href = `news.php`
                      }
                    } while(!id);
                    </script>';
            exit();
          }
          $result = News::delete($_GET['id']);
          if ($result) {
            echo '
                  <script>window.location.href = `news.php`</script>
                  ';
          } else {
            echo '
                  <script>window.alert("Xay ra loi khi xoa")</script>
                  ';
          }
        } else { ?>
          <?php
          $result = News::getAllNews();
          foreach ($result as $new) {
            $result = News::getCategoryById($new['category_id']);
            $category = mysqli_fetch_assoc($result);
          ?>
            <li>
              <div class="date">
                <p>
                  <span><?php echo date('m', strtotime($new['date'])) ?></span>
                  <?php echo date('Y', strtotime($new['date'])) ?>
                </p>
              </div>
              <h2>
                <div>
                  <?php echo $new['title'] ?>
                  <?php if ($is_admin) { ?>
                    <a href="?state=update&id=<?php echo $new['id'] ?>">&#128397;</a>
                  <?php } ?>
                </div>
                <span><?php echo $new['author'] ?></span>
              </h2>
              <p>
                <?php echo $new['s_content'] ?>
                <span><a href="post.php?id=<?php echo $new['id'] ?>" class="more">Read More</a></span>
              </p>
            </li>
          <?php } ?>
          <?php if ($is_admin) { ?>
            <div style="text-align: center;">
              <a href="?state=new" class="btn-primary">New</a>
            </div>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <div class="sidebar">
      <h1>Popular Posts</h1>
      <ul class="posts">
        <?php
        $result = News::getPopularPosts();
        foreach ($result as $new) {
          $result = News::getCategoryById($new['category_id']);
          $category = mysqli_fetch_assoc($result);
        ?>
          <li>
            <h4 class="title"><a href="post.php?id=<?php echo $new['id'] ?>"><?php echo $new['title'] ?></a></h4>
            <p>
              <?php echo $new['s_content'] ?>
            </p>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <?php include 'src/footer.php' ?>
  <script src="js/main.js"></script>
</body>

</html>