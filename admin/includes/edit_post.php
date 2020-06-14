<?php 
  if(isset($_GET['p_id'])) {
    $post_id = $_GET['p_id'];
  }
  
  $query = "SELECT * FROM posts WHERE post_id = $post_id";
  $select_posts_by_id = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_status = $row['post_status'];
  }
?>

<?php 
  if(isset($_POST['update_post'])) {
    $post_author = $_POST['post_author'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    // $post_date = $_POST['post_date'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    $post_comment_count = 3;
    $post_status = $_POST['post_status'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image)) {
      $query = "SELECT * FROM posts WHERE post_id = $post_id ";
      $select_image = mysqli_query($connection, $query);

      while($row = mysqli_fetch_array($select_image)) {
        $post_image = $row['post_image'];
      }
    }

    // $comments1=mysql_real_escape_string($comments1);
    $query = "UPDATE posts SET ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_title = '{$post_title}', ";
    // $query .= "post_date = , ";
    $query .= "post_image = '{$post_image}', ";
    $query .="post_content = '{$post_content}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_comment_count = '{$post_comment_count}'";
    $query .= "WHERE post_id = {$post_id}";

    // echo $query;
    $update_post_query = mysqli_query($connection, $query);
    confirm($update_post_query);

    header("Location: posts.php"); 
    exit;
    echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id={$post_id}'>View posts</a> or <a href='posts.php'>view all posts.</a></p>";
  }
?>

<form action="" method="post" enctype="multipart/form-data">    
  <div class="form-group">
    <label for="title">Post Title</label>
    <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
  </div>

  <div class="form-group">
      <select name="post_category_id">
        <?php 
          $query = "SELECT * FROM categories";
          $select_categories_id = mysqli_query($connection, $query);

          confirm($select_categories_id);
  
          while ($row = mysqli_fetch_assoc($select_categories_id)) {
              $cat_id = $row['cat_id'];
              $cat_title = $row['cat_title'];

              if($cat_id == $post_category_id) {
                echo "<option selected value='{$cat_id}'>$cat_title</option>";
              } else {
                echo "<option value='{$cat_id}'>$cat_title</option>";
              }

          }
        ?>
      </select>
  </div>

  <div class="form-group">
    <label for="post_author">Post Author</label>
    <br>
    <select name="post_author" required>
      <?php 
        $query = "SELECT * FROM users WHERE user_role = 'admin' ";
        $select_users = mysqli_query($connection, $query);

        confirm($select_users);

        echo "<option value=''>Choose author</option>";

        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            
            if ($user_id == $post_author) {
              echo "<option selected='selected' value='{$user_id}'>$username</option>";
            } else {
              echo "<option value='{$user_id}'>$username</option>";
            }
        }
      ?>
    </select>
  </div>

  <!-- <div class="form-group">
    <label for="title">Post Author</label>
    <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
  </div> -->

  <!-- Post status -->
  <div class="form-group">
    <select name="post_status" id="" required>
        <?php 
          if($post_status == "published") {
            echo "<option selected='selected' value='published'>Published</option>";
            echo "<option value='draft'>Draft</option>";
          } else {
            echo "<option value='published'>Published</option>";
            echo "<option selected='selected' value='draft'>Draft</option>";
          }
        ?>
        
    </select>
  </div>
  
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <br>
    <img src="../images/<?php echo $post_image; ?>" height="100"  />
    <input value="<?php echo $post_image; ?>" type="file"  name="image">
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
  </div>
  
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control "name="post_content" id="body" cols="30" rows="10">
      <?php echo $post_content; ?>
    </textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
  </div>
</form>