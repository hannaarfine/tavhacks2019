<?php
  $current_page_id = "edittags";
  include('includes/init.php');
  include('includes/header.php');

  if (isset($_POST['tag_id']) and !empty($_POST['tag_id'])) {
    $tag_id =  $_POST['tag_id'];
    $image_id = $_POST['image_id'];

    $sql = "DELETE FROM image_tags WHERE image_id =:image_id AND tag_id =:tag_id ";
    $params = array(
      ':image_id' => $image_id,
      ':tag_id' => $tag_id
    );
    $records = exec_sql_query($db, $sql, $params);
  }

  if(isset($_POST['new_tag']) and !empty($_POST['new_tag'])) {
    $new_tag = filter_input(INPUT_POST, 'new_tag', FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM tags WHERE tag_name = :new_tag";
    $params = array(
      ':new_tag' => $new_tag
    );
    $records =exec_sql_query($db, $sql, $params)->fetchAll();
    if(isset($records) and !empty($records)) {}
    else {

      $sql = "INSERT INTO tags (tag_name) VALUES (:new_tag)";
      $params = array(
      ':new_tag' => $new_tag
      );
      $result = exec_sql_query($db, $sql, $params);
    }




    $sql = "SELECT id FROM tags WHERE tag_name = :new_tag";
    $params = array(
    ':new_tag' => $new_tag
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    $tag_id = $records[0][0];

    $image_id = $_POST['img_id'];

    $sql = "SELECT * FROM image_tags WHERE image_id = :image_id AND tag_id = :tag_id";
    $params = array(
      ':image_id' => $image_id,
      ':tag_id' => $tag_id
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if(isset($records) and !empty($records)) {}
      else{


    $sql = "INSERT INTO image_tags (image_id, tag_id) VALUES (:image_id, :tag_id)";
    $params = array(
      ':image_id' => $image_id,
      ':tag_id' => $tag_id
    );
    $result = exec_sql_query($db, $sql, $params);
  }
  }
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
  <div class="center">
    <div class="edit-tags">
        <?php
        $sql = "SELECT * FROM images WHERE id = :image_id ";
          $params = array(
            ':image_id' => $_GET['image_id']
          );
        $records = exec_sql_query($db, $sql, $params)->fetchAll();
        if (isset($records) and !empty($records)) {
          foreach($records as $record) {
            echo "
                <div class='view-photo'>
                  <img src='uploads/images/".$record[1]."'alt='photo'>";
            echo "<div class='user-info'><p>Photo by <strong>".$record[2]."</strong></p>";
          }
        }
        $sql_tag = "SELECT tags.id, tags.tag_name, image_tags.image_id FROM image_tags INNER JOIN images ON image_tags.image_id = images.id INNER JOIN tags ON tags.id = image_tags.tag_id WHERE images.id =  :image_id ";
        $params_tag = array(
          ':image_id' => $_GET['image_id']
        );
        $records_tag = exec_sql_query($db, $sql_tag, $params_tag)->fetchAll();
        if (isset($records_tag) and !empty($records_tag)) {

          if($record[2]==$current_user){
            echo "<h2>Remove Current Image Tags </h2>";
            echo "<div class='tag_details'>";
            echo "<div class='flex'>";
            foreach($records_tag as $record_tag) {
              echo "<form action='edittags.php?image_id=".$record_tag[2]."' method='POST'>";
              echo "<input type='hidden' name='tag_id' value='".$record_tag[0]."'>";
              echo "<input type='hidden' name='image_id' value='". $_GET['image_id']."'>";
              echo "<input class='tag-x' type='submit' value='x ".$record_tag[1]."'> ";
              echo "</form>";
            }
            echo "</div>";
          }
          else {
            echo "<h2> Current Image Tags </h2>";
            echo "<div class='tag_details'>";
            foreach($records_tag as $record_tag) {
              echo "<div class='tag'>".$record_tag[1]."</div>";
            }
          }
          echo "</div>";

        }
        echo "<h2>Add Tag</h2>";
        echo "<form action='edittags.php?image_id=".$_GET['image_id']."' method='POST'>
        <input type='hidden' name='img_id' value='". $_GET['image_id'] ."'><input type='text' id='new_tag' name='new_tag'><input type='submit' value='Add' class='btn-add'> ";
        ?>

  </div>
</div>
</div>
</div>
</div>

</body>
</html>
