<?php include 'includes/header.php' ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>


<?php 
    // Liking
    if(isset($_POST['liked'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        // select post 
        $searchPost = "SELECT * FROM posts WHERE post_id = $post_id ";
        $post_result = mysqli_query($connection, $searchPost);
        $post = mysqli_fetch_array($post_result);
        $likes = $post["likes"];

        // update post with likes
        mysqli_query($connection, "UPDATE posts SET likes = $likes+1 WHERE post_id = $post_id");

        // Create likes for posts 
        mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
        exit();
    }

    // Unliking
    if(isset($_POST['unliked'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        // select post 
        $searchPost = "SELECT * FROM posts WHERE post_id = $post_id ";
        $post_result = mysqli_query($connection, $searchPost);
        $post = mysqli_fetch_array($post_result);
        $likes = $post["likes"];

        // Delete likes 
        mysqli_query($connection, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id ");

        // Decrement likes
        mysqli_query($connection, "UPDATE posts SET likes = $likes-1 WHERE post_id = $post_id");
        exit();
    }
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- </div> -->
            <!-- First Blog Post -->
                <?php
                if(isset($_GET['p_id'])) {
                    $the_post_id = $_GET['p_id'];
                    $view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $the_post_id ";
                    $send_query = mysqli_query($connection, $view_query);
                    
                    if (!$send_query) {
                        die("Query failed" . mysqli_error($connection));
                    }

                    
                    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                    } else {
                        $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
                    }

                    $select_all_posts = mysqli_query($connection,$query);

                    if (mysqli_num_rows($select_all_posts) < 1) {
                        echo "<h1 class='text-center'>No post!</h1>";      
                    }
                    while ($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                    ?>

                    <div class="row">
                            <h2>
                            <a href="#"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src=images/<?php echo imagePlaceholder($post_image); ?> alt="" width="700">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <hr>
<!-- Working here -->
                        <?php if (isLoggedIn()): ?>
                        <div class="row">
                            <p class="pull-right">
                            <a href="" class='<?php echo userLikedPost($the_post_id) ? 'unlike' : 'like' ?>' data-toggle='tooltip' data-placement='top' title=' <?php echo userLikedPost($the_post_id) ? ' I liked this before' : ' Want to like it?' ?>'>
                                <span class='<?php echo userLikedPost($the_post_id) ? 'glyphicon glyphicon-thumbs-down' : 'glyphicon glyphicon-thumbs-up' ?>'></span>
                                <?php echo userLikedPost($the_post_id) ? ' Unlike' : ' Like' ?>
                                
                            </a>
                            </p>
                        </div>
                        <?php else: ?>
                            <div class="row">
                            <p class="pull-right">You need to <a href="/cms/login.php" class=''> login</a> to like posts</p>
                        </div>
                        <?php endif; ?>
                        <div class="row">
                            <p class="pull-right">Like: <?php getPostLikes($the_post_id); ?></p>
                        </div>
                        </div>
                    

                    <?php } ?>
                    
                    <!-- Blog Comments -->

                    <?php 
                        if(isset($_POST['create_comment'])) {
                            $the_post_id = $_GET['p_id'];
                            $comment_author = $_POST['comment_author'];
                            $comment_email = $_POST['comment_email'];
                            $comment_content = $_POST['comment_content'];

                            if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                                $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
    
                                $placing_comment_query = mysqli_query($connection, $query);
                                if (!$placing_comment_query) {
                                    die("Query failed " . mysqli_error($connection));
                                }
    
                                // $update_comment_count = mysqli_query($connection, $query_count);
                                // if (!$update_comment_count) {
                                //     die("Query failed " . mysqli_error($connection));
                                // }
                            } else {
                                echo "<script>alert('Fields can not be empty')</script>";
                            }
                        }
                    ?>

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form action="" method="post" role="form">
                            <div class="form-group">
                                <label for="Author">Author</label>
                                <input type="text" class="form-control" name="comment_author" >
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" name="comment_email" >
                            </div>
                            <div class="form-group">
                                <label for="Comment">Comment</label>
                                <textarea name="comment_content" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->
                    <?php 
                        $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                        $query .= "AND comment_status = 'approved' ";
                        $query .= "ORDER BY comment_id DESC ";
                        $select_comment_query = mysqli_query($connection, $query);
                        
                        if (!$select_comment_query) {
                            die("Query failed" . mysqli_error($connection));
                        }

                        while($row = mysqli_fetch_array($select_comment_query)) {
                            $comment_date = $row['comment_date'];
                            $comment_content = $row['comment_content'];
                            $comment_author = $row['comment_author'];
                        
                    ?>

                    <!-- Comment -->
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment_author; ?>
                                <small><?php echo $comment_date; ?></small>
                            </h4>
                            <?php echo $comment_content; ?>
                        </div>
                    </div>
                <?php }}    else {


                header("Location: index.php");


}
    ?>
                </div>


            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>

        </div>
        <!-- /.row -->
        <hr>

<?php include 'includes/footer.php' ?>


<script>
    // Liking
    $(document).ready(function() {
        $("[data-toggle='tooltip']").tooltip()

        var post_id = <?php echo $the_post_id; ?>;
        var user_id = <?php echo loggedInUserId() ?>;

        $('.like').click(function() {
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        })

        // Unliking
        var post_id = <?php echo $the_post_id; ?>;
        var user_id = <?php echo loggedInUserId() ?>;

        $('.unlike').click(function() {
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        })
    })
</script>