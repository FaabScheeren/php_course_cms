<?php 
  function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
  }
?>

<?php 
  function users_online() {

    if(isset($_GET['onlineusers'])) {

      global $connection;

      if(!$connection) {
        session_start();
        include("../includes/db.php");

        $session = session_id();
        $time = time();
        $time_out_in_seconds = 60;
        $time_out = $time - $time_out_in_seconds;
      
        $query = "SELECT * FROM users_online WHERE session = '$session' ";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);
      
          if ($count == NULL) {
              mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
              
          } else {
              mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session' ");
          }
      
        $users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
        echo $count_user = mysqli_num_rows($users_online);
      }
    }
  }

  users_online()

?>

<?php 
  function insert_categories() {
    global $connection;

    if(isset($_POST['submit'])) {
      $cat_title = $_POST['cat_title'];

      if($cat_title == "" || empty($cat_title)) {
        echo "This field should not be empty!";
      } else {
        $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?)");
        mysqli_stmt_bind_param($stmt, 's', $cat_title);
        mysqli_stmt_execute($stmt);
        // $query = "INSERT INTO categories(cat_title)";
        // $query .= "VALUES('{$cat_title}')";
        // $create_category_query = mysqli_query($connection, $query);

        if(!$stmt) {
          die("Query failed!". mysqli_error($connection));
        }
      }
    }
  }
?>

<?php 
  function findAllCategories() {
    global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo 
        "<tr>
          <td>{$cat_id}</td>
          <td>{$cat_title}</td>
          <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
          <td><a href='categories.php?update={$cat_id}'>Update</a></td>
        </tr>";
    }
  }
?>

<?php 
  function delete_categories() {
    global $connection;
    if (isset($_GET['delete'])) {
      $the_cat_id = $_GET['delete'];
      $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
      $delete_query = mysqli_query($connection, $query);
      header("Location: categories.php");
    }
  }
?>

<?php 
  function confirm($result) { 
    global $connection;
    if (!$result) {
      die("Query failed " . mysqli_error($connection));
    }
}
?>

<?php 
function recordCount($table) {
  global $connection;

  $query = "SELECT * FROM " . $table;
  $select_all = mysqli_query($connection, $query);

  $count = mysqli_num_rows($select_all);
  confirm($count);

  return $count;
}
  
?>


<?php 
function checkStatus($table, $column, $value) {
  global $connection;

  $query = "SELECT * FROM $table WHERE $column = '$value' ";
  $select_all = mysqli_query($connection, $query);
  confirm($select_all);
  $count = mysqli_num_rows($select_all);
  return $count;
}
?>

<?php 
  function is_admin($username){
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirm($result);

    $row = mysqli_fetch_array($result);

    if($row['user_role'] ==  'admin') {
      return true;
    } else {
      return false;
    }
  }
?>

<?php 
  function username_exist($username) {
    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if (mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }
?>

<?php 
  function email_exist($email) {
    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if (mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }
?>

<?php
  function redirect($location) {
    return header("Location: $location");
    exit;
  }
?>

<?php 
  function ifItIsMethod($method = null) {
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
      return true;
    }

    return false;
  }
?>

<?php 
  function isLoggedIn() {
    if (isset($_SESSION['role'])) {
      return true;
    }
  }
?>

<?php 
  function checkIfUserIsLoggedInAndRedirect($location=null) {
    if(isLoggedIn()) {
      redirect($location);
    }
  }
?>

<?php 
  function register_user($username, $email, $password) {
    global $connection;

      $username   = mysqli_real_escape_string($connection, $username);
      $email      = mysqli_real_escape_string($connection, $email);
      $password   = mysqli_real_escape_string($connection, $password);
      $password   = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

      $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
      $query .= "VALUES('{$username}','{$email}','{$password}', 'subscriber')";
      $register_user_query = mysqli_query($connection, $query);

      confirm($register_user_query);

      $message = "Your registration has been submitted";
  }
?>

<?php 
  function login_user($username, $password) {
    global $connection;

    $username = trim(mysqli_real_escape_string($connection, $username));
    $password = trim(mysqli_real_escape_string($connection, $password));
 
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
 
    if (!$select_user_query) {
        die("Query failed " . mysqli_error($connection));
    }
 
    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

        if (password_verify($password, $db_user_password)) {
          $_SESSION['username'] = $db_username;
          $_SESSION['firstname'] = $db_user_firstname;
          $_SESSION['lastname'] = $db_user_lastname;
          $_SESSION['role'] = $db_user_role;
          redirect("/cms/admin");
        } else {
          // header("Location: /cms/index.php");
        return false;
      }
    }
  }
?>