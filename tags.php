<?php
  $current_page_id = "tags";
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
  <div class="center-panel">

      <h2> All image tags </h2>
        <?php
        $i = 1;
        $sql = "SELECT id, tag_name FROM tags";
        $params = array(
        );
        $records = exec_sql_query($db, $sql, $params)->fetchAll();
        if (isset($records) and !empty($records)) {
          echo "<div class='all_tags'><div class='tags_row'>";
          foreach($records as $record) {
            echo "<form action='index.php' method='GET'><input type='hidden' name='tag_id' value='".$record[0]."'>";
            echo "<input class='tag' type='submit' value='".$record[1]."'></form> ";
            if ($i % 3 === 0) {
              echo "</div><div class='tags_row'>";
            }
            $i++;
          }
          echo "</div>";

        }
        ?>
  </div>
</div>


</body>
