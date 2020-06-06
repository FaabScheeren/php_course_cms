<?php include 'includes/header.php' ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>

    <!-- Page Content -->
    <div class="container">

      <!-- <div class="row"> -->

      <!-- Blog Entries Column -->
      <div class="col-md-8">
            <!-- </div> -->
            <!-- First Blog Post -->
          <?php
            if(isset($_GET['category'])) {
              $category_id = $_GET['category'];
            }

            $query = "SELECT * FROM categories WHERE cat_id = $category_id";
            $select_all_categories = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_all_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
          ?>
            <div class="row">
              <h1 class="page-header">
                <?php echo $cat_title ?>
                <small>id:<?php echo $cat_id; ?></small>
              </h1>
            </div>
          <?php } ?>
      <!-- </div> -->
      
      <?php
        $query = "SELECT * FROM posts WHERE post_category_id = $category_id";
        $select_all_posts = mysqli_query($connection,$query);
        while ($row = mysqli_fetch_assoc($select_all_posts)) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = substr($row['post_content'], 0,250);
      ?>

      <div class="row">
        <h2>
          <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
        </h2>
        <p class="lead">
            by <a href="index.php"><?php echo $post_author ?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
        <hr>
        <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src=images/<?php echo $post_image ?> alt="" width="700"></a>
        <hr>
        <p><?php echo $post_content ?></p>
        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
        <hr>
      </div>
      <?php } ?>
    </div>

      <!-- Blog Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php'?>

    <!-- </div> -->
    <!-- /.row -->

    <hr>

<?php include 'includes/footer.php' ?>