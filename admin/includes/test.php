<form action="" method="post" enctype="multipart/form-data">    
  <div class="form-group">
      <select name="" id="">
        <?php 
          $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
          $select_categories_id = mysqli_query($connection, $query);

          confirm();
  
        ?>
          <option value="<?php echo $cat_id; ?>"><?php echo $cat_id; ?></option>
      </select>
  </div>

  <div class="form-group">
    <label for="title">Post Author</label>
    <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="author">
  </div>

  <div class="form-group">
    <select name="post_status" id="">
        <option value="draft">Post Status</option>
        <option value="published">Published</option>
        <option value="draft">Draft</option>
    </select>
  </div>
  
  <div class="form-group">
    <img src="../images/<?php echo $post_image; ?>" height="100"  />
    <label for="post_image">Post Image</label>
    <input value="<?php echo $post_image; ?>" type="file"  name="image">
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
  </div>
  
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control "name="post_content" id="" cols="30" rows="10">
      <?php echo $post_content; ?>
    </textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
  </div>
</form>