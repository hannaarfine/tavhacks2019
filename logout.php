<?php
include("includes/init.php");

// declare the current location, utilized in header.php
$current_page_id="logout";

log_out();
if (!$current_user) {
  record_message("You've been successfully logged out.");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Log in- <?php echo $title;?></title>
</head>

<body>
  <?php include("includes/header.php");?>

  <div id="content-wrap">
    <div class="messages">
    <?php
      print_messages();
    ?>
  </div>
  <div class="center">
    <a class="btn-fill" href="index.php">Browse Gallery </a>
  </div>
  </div>
</body>

</html>
