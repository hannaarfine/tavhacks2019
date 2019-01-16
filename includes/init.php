<?php

$pages = array(
  "index" => "Home", "tags" => "Tags", "upload" => "Upload", "login" => "Login"
);

$messages = array();
function record_message($message) {
  global $messages;
  array_push($messages, $message);
}

function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<p>" . htmlspecialchars($message) . "</p>\n";
  }
}

// show database errors during development.
function handle_db_error($exception) {
  echo '<p><strong>' . htmlspecialchars('Exception : ' . $exception->getMessage()) . '</strong></p>';
}

// execute an SQL query and return the results.
function exec_sql_query($db, $sql, $params = array()) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
}

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        handle_db_error($exception);
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

$db = open_or_init_sqlite_db('gallery.sqlite', 'init/init.sql');

function check_login() {
  global $db;

  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $sql = "SELECT * FROM accounts WHERE session = :session_id;";
    $params = array (
      ":session_id" => $session,
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      $account = $records[0];
      return $account["username"];
    }
  }
  return NULL;
}

function log_in($username, $password) {
  global $db;
  global $pages;

  if ($username && $password) {
    $sql = "SELECT * FROM accounts WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {

      $account = $records[0];
      if ( password_verify($password, $account['password']) ) {

        $session = uniqid();
        $sql = "UPDATE accounts SET session = :session WHERE id = :user_id;";
        $params = array (
          ":user_id" => $account['id'],
          ":session" => $session
        );
        $result = exec_sql_query($db, $sql, $params);
        if ($result) {
          // Success, session stored in DB

          // Send this back to the client
          setcookie("session", $session, time()+3600);

          record_message("Logged in as $username");
          // $user_array = array($username => $username);
          // $pages = array_merge($pages, $user_array);
          return $username;
        }
      } else {
        record_message("Invalid username or password.");
      }
    } else {
      record_message("Invalid username or password.");
    }
  } else {
    record_message("No username or password given.");
  }
  return NULL;
}

function log_out() {
  global $current_user;
  global $db;

  if ($current_user) {
    $sql = "UPDATE accounts SET session = :session WHERE username = :username;";
    $params = array (
      ":username" => $current_user,
      ":session" => NULL
    );
    if (!exec_sql_query($db, $sql, $params)) {
      record_message("log out failed.");
    }

    //
    setcookie("session", "", time()-3600);
    $current_user = NULL;
  }
}

if (isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);
}

$current_user = check_login();

//delete image
if(isset($_POST['del_image_id'])) {
  $image_id = filter_input(INPUT_POST, 'del_image_id', FILTER_SANITIZE_STRING);
  $sql = "SELECT image_name FROM images WHERE id = :image_id";
  $params = array (
    ":image_id" => $image_id
  );
  $records = exec_sql_query($db, $sql, $params)->fetchAll();
  $img_name = $records[0][0];

  $sql = "DELETE FROM images WHERE id = :image_id;";
  $params = array (
    ":image_id" => $image_id
  );
  if (exec_sql_query($db, $sql, $params)) {
    record_message("image deleted.");
    unlink("uploads/images/" .$img_name );
  }
  else {
    record_message("image was not deleted");
  }
}

class UploadException extends Exception
{
    public function __construct($code) {
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }
}
?>
