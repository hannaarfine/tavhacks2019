<?php
  $current_page_id = "login";
  include('includes/init.php');


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
  <?php include('includes/header.php'); ?>
  <div class="messages">
  <?php
    print_messages();
  ?>
  </div>
  <div class="center">

  <form id="loginForm" action="login.php" method="post">
    <div>
      <ul>
        <li>
          <label>Username:</label>
          <input type="text" name="username" required/>
        </li>
        <li>
          <label>Password:</label>
          <input type="password" name="password" required/>
        </li>
        <li>
          <button name="login" type="submit" id="login">Log In</button>
        </li>
      </ul>
    </form>
    </div>
  </div>

</body>
</html>
