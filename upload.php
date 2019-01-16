<?php
  $current_page_id = "upload";
  include('includes/init.php');
  include('includes/header.php');

  const IMG_UPLOADS_PATH = "uploads/images/";

  if(isset($_POST['submit']) and !empty($_POST['submit'])) {
  $upload_info = $_FILES["image_file"];

  if ($_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $image_name = basename("/uploads/images/".$upload_info['name']);

    $sql = "INSERT INTO images (image_name, user_id) VALUES (:image_name, :user_id)";
    $params = array(':image_name' => $image_name, ':user_id' => $current_user);
    $result = exec_sql_query($db, $sql, $params);

    $destination = IMG_UPLOADS_PATH . $image_name;
    move_uploaded_file($upload_info['tmp_name'], $destination);
    if ($result) {
        array_push($messages, "Your image has been uploaded. Thank you!");
      } else {
        array_push($messages, "Failed to add image.");
      }
  }
  else {
    throw new UploadException($_FILES['image_file']['error']);
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
  <div class="center-panel">
    <form action="upload.php" method="post" id="uploadForm" enctype="multipart/form-data">
      <h2> Upload new image </h2>
      <div id="img_upload">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <input type="file" name="image_file" id="image_file" required>
      </div>
      <input type="submit" class="btn-filled" id="btn-upload" value="Upload Image" name="submit">
    </form>
  </div>
</div>

</body>
</html>
