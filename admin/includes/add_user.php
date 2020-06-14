<?php
   if (isset($_POST['create_user'])) {
      $user_firstname = $_POST['user_firstname'];
      $user_lastname = $_POST['user_lastname'];
      $user_role = $_POST['user_role'];
      $user_username = $_POST['user_username'];
      $user_email = $_POST['user_email'];
      $user_password = $_POST['user_password'];
      $user_randSalt = 'blabla';

      $user_image        = $_FILES['image']['name'];
      $user_image_temp   = $_FILES['image']['tmp_name'];

      move_uploaded_file($user_image_temp, "../images/$user_image" );

      $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

      $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password, user_image, user_randSalt) ";
      $query .= "VALUES('{$user_firstname}', '{$user_lastname}','{$user_role}', '{$user_username}','{$user_email}','{$user_password}', '{$user_image}', '{$user_randSalt}') ";  

      $create_user_query = mysqli_query($connection, $query);

      confirm($create_user_query);

      echo "User created: " . " " . "<a href='users.php'>View users</a> ";

      // header("Location: users.php");
   }
?>

<form action="" method="post" enctype="multipart/form-data">    
  <div class="form-group">
    <label for="title">Firstname</label>
    <input type="text" class="form-control" name="user_firstname">
  </div>

  <!-- <div class="form-group">
    <label for="Category">Post category id</label>
    <input type="text" class="form-control" name="post_category">
  </div> -->

  <div class="form-group">
    <label for="user_lastname">Lastname</label>
    <input type="text" class="form-control" name="user_lastname">
  </div>
  
  <!-- <div class="form-group">
    <label for="Category">Role</label>
    <br>
    <select name="post_category">
      <?php 
        // $query = "SELECT * FROM categories";
        // $select_categories_id = mysqli_query($connection, $query);

        // confirm($select_categories_id);

        // while ($row = mysqli_fetch_assoc($select_categories_id)) {
        //     $cat_id = $row['cat_id'];
        //     $cat_title = $row['cat_title'];

        //     echo "<option value='{$cat_id}'>$cat_title</option>";
        // }
      ?>
    </select>
  </div> -->

  <div class="form-group">
    <label for="user_role">Role</label>
    <br>
    <select name="user_role" id="" required>
        <option value="">Select option</option>
        <option value="admin">Admin</option>
        <option value="subscriber">Subscriber</option>
    </select>
  </div>

  <div class="form-group">
    <label for="user_username">Username</label>
    <input type="text" class="form-control" name="user_username">
  </div>

  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="text" class="form-control" name="user_email">
  </div>

  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password">
  </div>

  <div class="form-group">
    <label for="user_image">User Image</label>
    <input type="file"  name="image">
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_user" value="Create user">
  </div>
</form>
    