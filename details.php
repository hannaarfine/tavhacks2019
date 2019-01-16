<?php
  $current_page_id = "details";
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
  <div class="center">
  <?php
  if (isset($_GET)) {
    $sql = "SELECT * FROM images WHERE id = :image_id";
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



        $sql_tag = "SELECT tags.id, tags.tag_name FROM image_tags INNER JOIN images ON image_tags.image_id = images.id INNER JOIN tags ON tags.id = image_tags.tag_id WHERE images.id = :image_id ";
        $params_tag = array(
          ':image_id' => $_GET['image_id']
        );
        $records_tag = exec_sql_query($db, $sql_tag, $params_tag)->fetchAll();
        if (isset($records_tag) and !empty($records_tag)) {
          echo "<h4> Image tags: </h4><div class='tag_details'>";
          foreach($records_tag as $record_tag) {
            // echo $record[0]." ";
            echo "<form action='index.php' method='GET'><input type='hidden' name='tag_id' value='".$record_tag[0]."'>";
            echo "<input class='tag' type='submit' value='".$record_tag[1]."'></form> ";

          }
          echo "</div>";
        }
        else {
          echo "This photo has no tags.";
        }

        echo "<form action='edittags.php' method='GET'><input type='hidden' name='image_id' value='".$record[0]."'><input class='btn-filled' type='submit' value='Edit Tags'></form>" ;

        if($record[2]==$current_user){
          echo "<form method='post' action='index.php' id='deleteForm'>
          <input type='hidden' name='del_image_id' value='".$record[0]."'>
          <input type='submit' value='Delete Image' class='btn-filled'></form>
          </form>";
        }

        echo "</div></div>";

      }
    }

     // $sql = "SELECT tags.tag_name FROM tags INNER JOIN image_tags ON images.id = images_tags.image_id";

    // $sql = "SELECT tags.tag_name FROM tags INNER JOIN image_tags INNER JOIN images ON image_tags.image_id = images.id
    // image_tags.tag_id FROM image_tags INNER JOIN images ON image_tags.image_id = images.id";


  }
  ?>
  </div>
</body>
