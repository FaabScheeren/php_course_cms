<?php ob_start();?>
<?php include 'includes/header.php' ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>

    <!-- Page Content -->
    <div class="container">

        <!-- <div class="row"> -->

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php 
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = "";
                    }

                    if($page == "" || $page == 1) {
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * 5) - 5;
                    }
                ?>

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            <!-- </div> -->
            <!-- First Blog Post -->
                <?php
                $select_post_query_count = "SELECT * FROM posts WHERE post_status = 'published' ";
                $post_query_count = mysqli_query($connection, $select_post_query_count);
                $count_posts = mysqli_num_rows($post_query_count);
                if($count_posts < 1) {
                    echo "<h1 class='text-center'>No posts!</h1>";
                } else {

                $count = ceil($count_posts / 5);

                    // $query = "SELECT * FROM posts WHERE post_status = 'published' ";
                    $query = "SELECT * FROM posts LIMIT $page_1, 5";
                    $select_all_posts = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'], 0,250);
                        $post_status = $row['post_status'];
                ?>
                <div class="row">
                    <h2>
                        <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_post.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src=images/<?php echo imagePlaceholder($post_image); ?> alt="" width="700"></a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    </div>
                    <hr>

                <?php }} ?>


                    <ul class="pager">
                        <?php 
                        for($i = 1; $i <= $count_posts; $i++) {
                            if ($i == $page) {
                                echo "<li><a class='active-link' href='index.php?page={$i}'>{$i}</a></li>";
                            } else {
                                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                            }
                        }
                        ?>
                    </ul>

                </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>

        <!-- </div> -->
        <!-- /.row -->



<?php include 'includes/footer.php' ?>