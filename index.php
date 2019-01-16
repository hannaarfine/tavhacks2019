<?php
  $current_page_id = "index";
  include('includes/init.php');
  include('includes/header.php');

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <title>Home</title>
</head>

<body>
  <div class="messages">
  <?php
    print_messages();
  ?>
  </div>

  <?php
    $i = 1;

    if(isset($_GET['tag_id'])) {
      $sql = "SELECT * FROM images INNER JOIN image_tags ON image_tags.image_id = images.id INNER JOIN tags ON tags.id = image_tags.tag_id WHERE tags.id = :tag_id";
      $params = array(
        ':tag_id' => $_GET['tag_id']
      );

      $sql_tag = "SELECT tag_name FROM tags WHERE id = :tag_id ";
      $params_tag = array(
        ':tag_id' => $_GET['tag_id']
      );
      $records = exec_sql_query($db, $sql_tag, $params_tag)->fetchAll();
        if (isset($records) and !empty($records)) {
          foreach($records as $record) {
            echo "<div class='center'><div class='tag'>".$record[0] ."</div></div>";
          }
        }
    }

    else {
      $sql = "SELECT * FROM images";
      $params = array();
    }

    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if (isset($records) and !empty($records)) {
      echo "<div class='panels_row'>";
      foreach($records as $record) {
        echo "<form action='details.php' method='GET'><div class='park_panel'>";
        echo "<div class='park_img'>
              <img src='uploads/images/".$record[1]."'alt='photo'>
              <input type='hidden' name='image_id' value='".$record[0]."'></div>
              <div class='img_cap'>
                <p>".$record[2] ."</p>
              <input type='submit' value='Details' class='details'>
              </div></form>";
        echo "</div>";
        if ($i % 4 === 0) {
          echo "</div><div class='panels_row'>";
        }
        $i++;
      }
    }

    else {
      echo "<div class='center'> There are no images for this tag yet. </div>";
    }
  ?>

</body>
</html>
