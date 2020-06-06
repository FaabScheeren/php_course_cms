<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Role</th>
      <th>Change to admin</th>
      <th>Change to subscriber</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $query = "SELECT * FROM users";
      $select_users = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $user_username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
   
        $user_password = $row['user_password'];
        $user_randSalt = $row['user_randSalt'];
    
        echo "<tr>
        <td>$user_id</td>
        <td>$user_username</td>
        <td>$user_firstname</td>
        <td>$user_lastname</td>
        <td>$user_email</td>
        <td>$user_role</td>";

        // $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
        // $select_post_id = mysqli_query($connection, $query);

        // confirm($select_post_id);

        // while ($row = mysqli_fetch_assoc($select_post_id)) {
        //     $post_title = $row['post_title'];
        //     echo "<td><a href='../post.php?p_id=$comment_post_id'>$post_title</a></td>";
        // }

        echo "
        <td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>
        <td><a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>
        <td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>
        <td><a href='users.php?delete={$user_id}'>Delete</a></td>
      </tr>";
      }
    ?>
  </tbody>
</table>

<?php                           
  if(isset($_GET['delete'])) {
    $the_user_id = $_GET['delete'];

    $query = "DELETE FROM users WHERE user_id = $the_user_id ";
    $delete_query = mysqli_query($connection, $query);

    confirm($delete_query);
    header("Location: users.php");
  }
?>

<?php 
    if(isset($_GET['change_to_admin'])) {
      $the_user_id = $_GET['change_to_admin'];
  
      $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id ";
      $change_to_admin_query = mysqli_query($connection, $query);
  
      confirm($change_to_admin_query);
      header("Location: users.php");
    }
?>

<?php 
    if(isset($_GET['change_to_subscriber'])) {
      $the_user_id = $_GET['change_to_subscriber'];
  
      $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id ";
      $change_to_subscriber_query = mysqli_query($connection, $query);
  
      confirm($change_to_subscriber_query);
      header("Location: users.php");
    }
?>