<?php include("delete_modal.php")  ?>

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
        case 'clone':
          $query = "SELECT * FROM posts WHERE post_id = $postValueId";
          $select_post_query = mysqli_query($connection, $query);
          
          while($row = mysqli_fetch_assoc($select_post_query)) {
            $post_title         = $row['post_title'];
            $post_category_id   = $row['post_category_id'];
            $post_date          = $row['post_date']; 
            $post_author        = $row['post_author'];
            $post_status        = $row['post_status'];
            $post_image         = $row['post_image'] ; 
            $post_tags          = $row['post_tags']; 
            $post_content       = $row['post_content'];
            $post_comment_count = 0;
            $post_view_count = 0;

            $query = "INSERT INTO posts(post_category_id,post_author, post_title, post_date, post_image, post_content,post_tags,post_status, post_comment_count, post_view_count) ";
            $query .= "VALUES({$post_category_id}, '{$post_author}','{$post_title}',now(), '{$post_image}','{$post_content}','{$post_tags}', '{$post_status}', '{$post_comment_count}', '{$post_view_count}') ";

            $copy_query = mysqli_query($connection, $query);

            confirm($copy_query);
          }

          
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
    <option value="clone">Clone</option>
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
      // JOINING TABLES
      // $query = "SELECT * FROM posts";
      $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
      $query .= "post_content, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_view_count, ";
      $query .= " categories.cat_id, categories.cat_title ";
      $query .= " FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id";

      $select_posts = mysqli_query($connection, $query);
      confirm($select_posts);

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
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
    
        
        echo "<tr>";
        ?>
        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
        <?php
        echo "
        <td>$post_id</td>
        <td>$post_author</td>
        <td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";

        // QUERY ISN'T NEEDED ANYMORE BECAUSE JOIN QUERY ABOVE.
          // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
          // $select_categories_id = mysqli_query($connection, $query);

          // confirm($select_categories_id);
  
          // while ($row = mysqli_fetch_assoc($select_categories_id)) {
              // $cat_title = $row['cat_title'];
              echo "<td>$cat_title</td>";
          

        echo "
        <td>$post_status</td>
        <td>$post_image</td>
        <td>$post_tags</td>";

        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
        $send_comment_query = mysqli_query($connection, $query);
        $comment_count = mysqli_num_rows($send_comment_query);
        
        echo "
        <td>$comment_count</td>
        <td>$post_date</td>";
        ?>

        <form action="" method='POST'>
            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
            <?php
            echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
            ?>
        </form>
        <?php 
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Update</a></td>
        </tr>";
        // <td><a href='javascript:void(0)' rel='$post_id' class='delete_link'>Delete</a></td>";
        // <td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>
      }
    ?>
  </tbody>
</table>
</form>

<?php                           
  if(isset($_POST['delete'])) {
    if(isset($_SESSION['role'])) {
      if($_SESSION['role'] == 'admin') {
        $the_post_id = $_POST['post_id'];

        $query = "DELETE FROM posts WHERE post_id = $the_post_id ";
        $delete_query = mysqli_query($connection, $query);

        confirm($delete_query);
        header("Location: posts.php");
      }  
    } 
  }
?>

<script>
  $(document).ready(function() {

    $(".delete_link").on('click', function(){
      var id = $(this).attr("rel");
      var delete_Url = "posts.php?delete=" + id" ";
      $(".modal_delete_link").attr("href", delete_Url);

      $("#myModal").modal('show');
    });
  });
</script>