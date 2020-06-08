<?php include 'includes/header.php' ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>

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
                    
                }

                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                $select_all_posts = mysqli_query($connection,$query);
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
                    <img class="img-responsive" src=images/<?php echo $post_image ?> alt="" width="700">
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <hr>
                    </div>
                   

                <?php } ?>


                <!-- Post Content -->
                <!-- <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!</p>

                <hr> -->

                
                <!-- Blog Comments -->

                <?php 
                    if(isset($_POST['create_comment'])) {
                        $the_post_id = $_GET['p_id'];

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                        $placing_comment_query = mysqli_query($connection, $query);
                        if (!$placing_comment_query) {
                            die("Query failed " . mysqli_error($connection));
                          }

                        $query_count = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                        $query_count .= "WHERE post_id = $the_post_id ";

                        $update_comment_count = mysqli_query($connection, $query_count);
                        if (!$update_comment_count) {
                            die("Query failed " . mysqli_error($connection));
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

                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                    }
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

                </div>


            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>

        </div>
        <!-- /.row -->
        <hr>

<?php include 'includes/footer.php' ?>
