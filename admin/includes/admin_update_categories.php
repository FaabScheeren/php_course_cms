<!-- Edit category -->
<form action="categories.php" method="post">
<div class="form-group">
<label for="cat-title">Edit Category</label>

<?php
      if(isset($_GET['update'])) {
        $cat_id = $_GET['update'];

        $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
        $select_categories_id = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_categories_id)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
          ?>
            <input value="<?php if(isset($cat_title)) {echo $cat_title;} ?>" class="form-control" type='text' name="cat_title" >
          <?php }} ?>

          <?php 
          // Update query
            if (isset($_POST['update_category'])) {
              $the_cat_title = $_POST['cat_title'];
              // echo $the_cat_title;
              // echo $cat_id;
              $query = "UPDATE categories SET cat_title = '$the_cat_title' WHERE cat_id = $cat_id ";
              $update_query = mysqli_query($connection, $query);
              if(!$update_query) {
                die("query failed".mysqli_error($connection));
              }
            }

          ?>
          </div>
       <div class="form-group">
      <!-- <input class="btn btn-primary" type='submit' name="update_category" value="Update" > -->
      <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
  </form>
</div>

<!-- <input class="btn btn-primary" type=submit name="update_category" value="Update Category">
to this:

<input class="btn btn-primary" type="submit" name="update_category" value="Update Category"> -->