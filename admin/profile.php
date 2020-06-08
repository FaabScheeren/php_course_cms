<?php include 'includes/admin_header.php' ?>
<?php 
  if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user = mysqli_query($connection, $query);

    confirm($select_user);

    while($row = mysqli_fetch_array($select_user)) {
      $user_id = $row['user_id'];
      $user_username = $row['username'];
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $user_email = $row['user_email'];
      $user_image = $row['user_image'];
      $user_role = $row['user_role'];
      $user_password = $row['user_password'];
    }
  }
?>

<?php 
  // Send changes to the database
  if (isset($_POST['edit_user'])) {
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

    if(empty($user_image)) {
      $query = "SELECT * FROM users WHERE user_id = $user_id ";
      $select_image = mysqli_query($connection, $query);

      while($row = mysqli_fetch_array($select_image)) {
        $user_image = $row['user_image'];
      }
    }

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$user_username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE user_id = {$user_id}";

    // echo $query;
    $update_user_query = mysqli_query($connection, $query);

    confirm($update_user_query);
    header("Location: index.php");
 }
?>

<div id="wrapper">
  <!-- Navigation -->
  <?php include 'includes/admin_navigation.php' ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome
            <small>Author</small>
          </h1>
        </div>
      </div>

      <form action="" method="post" enctype="multipart/form-data">    
        <div class="form-group">
          <label for="title">Firstname</label>
          <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname ?>">
        </div>

        <!-- <div class="form-group">
          <label for="Category">Post category id</label>
          <input type="text" class="form-control" name="post_category">
        </div> -->

        <div class="form-group">
          <label for="user_lastname">Lastname</label>
          <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname ?>">
        </div>

        <div class="form-group">
          <label for="user_role">Role</label>
          <br>
          <select name="user_role" id="">
                <option value="<?php echo $user_role?>"><?php echo $user_role?></option>
                <?php 
                  if($user_role == 'admin') {
                    echo "<option value='subscriber'>subscriber</option>";
                  } else if ($user_role == 'subscriber') {
                    echo "<option value='admin'>admin</option>";  
                  } 
                ?>
          </select>
        </div>

        <div class="form-group">
          <label for="user_username">Username</label>
          <input type="text" class="form-control" name="user_username" value="<?php echo $user_username ?>">
        </div>

        <div class="form-group">
          <label for="user_email">Email</label>
          <input type="text" class="form-control" name="user_email" value="<?php echo $user_email ?>">
        </div>

        <div class="form-group">
          <label for="user_password">Password</label>
          <input type="password" class="form-control" name="user_password" value="<?php echo $user_password ?>">
        </div>

        <div class="form-group">
          <label for="user_image">User Image</label>
          <br>
          <img style="margin-bottom: 20px;" src="../images/<?php echo $user_image ?>" height="100"  />
          <br>
          <input type="file"  name="image">
        </div>

        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_user" value="Update profile">
        </div>
      </form>
    <!-- /.container-fluid -->
    </div>
  <!-- /#page-wrapper -->
  </div>
</div>

<?php include 'includes/admin_footer.php' ?>  