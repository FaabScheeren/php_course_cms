<?php
   if (isset($_POST['create_post'])) {
      $post_title        = $_POST['title'];
      //   $post_user         = $_POST['post_user'];
      $post_category_id  = $_POST['post_category'];
      $post_author       = $_POST['author'];
      $post_status       = $_POST['post_status'];

      $post_image        = $_FILES['image']['name'];
      $post_image_temp   = $_FILES['image']['tmp_name'];

      $post_tags         = $_POST['post_tags'];
      $post_content      = $_POST['post_content'];
      $post_date         = date('d-m-y');

      $post_comment_count = 0;
      $post_view_count = 0;

      move_uploaded_file($post_image_temp, "../images/$post_image" );

      $query = "INSERT INTO posts(post_category_id,post_author, post_title, post_date, post_image, post_content,post_tags,post_status, post_comment_count, post_view_count) ";
      $query .= "VALUES({$post_category_id}, '{$post_author}','{$post_title}',now(), '{$post_image}','{$post_content}','{$post_tags}', '{$post_status}', {$post_comment_count}, {$post_view_count}) ";  

      $create_post_query = mysqli_query($connection, $query);

      confirm($create_post_query);
      $the_post_id = mysqli_insert_id($connection);

      // header("Location: posts.php");
      echo "<p class='bg-success'>Post created. <a href='../post.php?p_id={$the_post_id}'>View posts</a> or <a href='posts.php'>view all posts.</a></p>";
   }
?>

<form action="" method="post" enctype="multipart/form-data">    
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title">
  </div>

  <!-- <div class="form-group">
    <label for="Category">Post category id</label>
    <input type="text" class="form-control" name="post_category">
  </div> -->

  <div class="form-group">
    <label for="Category">Post category</label>
    <br>
    <select name="post_category">
      <?php 
        $query = "SELECT * FROM categories";
        $select_categories_id = mysqli_query($connection, $query);

        confirm($select_categories_id);

        while ($row = mysqli_fetch_assoc($select_categories_id)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<option value='{$cat_id}'>$cat_title</option>";
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="author">Post Author</label>
    <br>
    <select name="author" required>
      <?php 
        $query = "SELECT * FROM users WHERE user_role = 'admin' ";
        $select_users = mysqli_query($connection, $query);

        confirm($select_users);

        echo "<option value=''>Choose author</option>";

        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];

            
            echo "<option value='{$user_id}'>$username</option>";
        }
      ?>
    </select>
  </div>


  <!-- <div class="form-group">
    <label for="title">Post Author</label>
    <input type="text" class="form-control" name="author">
  </div> -->
  

  <div class="form-group">
    <label for="post_status">Post Status</label>
    <br>
    <select name="post_status" id="" required>
        <option value="">Post Status</option>
        <option value="published">Published</option>
        <option value="draft">Draft</option>
    </select>
  </div>
  
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file"  name="image">
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags">
  </div>
  
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control "name="post_content" id="body" cols="30" rows="10">
    </textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
  </div>
</form>
    