<?php 
  if(isset($_POST['checkBoxArray'])) {
    forEach($_POST['checkBoxArray'] as $postValueId) {
      $bulk_options = $_POST['bulk_options'];

      switch ($bulk_options) {
        case 'publish':
          $query = "UPDATE posts SET post_status = 'published' WHERE post_id = $postValueId";
          $update_to_published_status = mysqli_query($connection, $query);
          confirm($update_to_published_status);
        break;
        case 'draft':
          $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = $postValueId";
          $update_to_draft_status = mysqli_query($connection, $query);
          confirm($update_to_draft_status);
        break;
        case 'delete':
          $query = "DELETE FROM posts WHERE post_id = $postValueId";
          $delete_posts_bulk = mysqli_query($connection, $query);
          confirm($delete_posts_bulk);
        break;
      }
    }
  }
?>

<form method="post" action="">

<table class="table table-bordered table-hover">

<div id="bulkOptionsContainer" class="col-xs-4">
  <select name="bulk_options" class="form-control" >
    <option value="">Select options</option>
    <option value="publish">Publish</option>
    <option value="draft">Draft</option>
    <option value="delete">Delete</option>
  </select>
</div>

<div class="col-xs-4">
  <input type="submit" name="submit" class="btn btn-success" value="Apply">
  <a class="btn btn-primary" href="posts.php?source=add_posts">Add new</a>
</div>

  <thead>
    <tr>
      <th><input type="checkbox" id="selectAllBoxes"></th>
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $query = "SELECT * FROM posts";
      $select_posts = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($select_posts)) {
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
    
        
        echo "<tr>";
        ?>
        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
        <?php
        echo "
        <td>$post_id</td>
        <td>$post_author</td>
        <td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
          $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
          $select_categories_id = mysqli_query($connection, $query);

          confirm($select_categories_id);
  
          while ($row = mysqli_fetch_assoc($select_categories_id)) {
              $cat_title = $row['cat_title'];
              echo "<td>$cat_title</td>";
          }

        echo "
        <td>$post_status</td>
        <td>$post_image</td>
        <td>$post_tags</td>
        <td>$post_comment_count</td>
        <td>$post_date</td>
        <td><a href='posts.php?delete={$post_id}'>Delete</a></td>
        <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Update</a></td>
      </tr>";
      }
    ?>
  </tbody>
</table>
</form>
<?php                           
  if(isset($_GET['delete'])) {
    $the_post_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = $the_post_id ";
    $delete_query = mysqli_query($connection, $query);

    confirm($delete_query);
    // header("Location: posts.php");
  }
?>