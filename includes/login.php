<?php include "db.php"; ?>
<?php session_start(); ?>
 
<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
 
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
    }
 
    $query = "SELECT user_randSalt FROM users";
    $select_randsalt_query = mysqli_query($connection, $query);
 
    if (!$select_randsalt_query) {
        die("Query failed" . mysqli_error($connection));
    }
 
    $row = mysqli_fetch_array($select_randsalt_query);
    $salt = $row['user_randSalt'];
    $password = crypt($password, $salt);
 
    if ($username !== $db_username && $password !== $db_user_password) {
        header("Location: ../index.php");
        // echo "if";
    } else if ($username == $db_username && $password == $db_user_password) {
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['role'] = $db_user_role;
        header("Location: ../admin");
        // echo "else if";
    } else {
        header("Location: ../index.php");
        // echo "else";
    }
  
}
?>