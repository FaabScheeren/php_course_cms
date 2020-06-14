<?php include 'includes/admin_header.php' ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'includes/admin_navigation.php' ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                                Welcome
                            <small><?php echo $_SESSION['username']?></small>
                        </h1>
                    </div>
                    <!-- /.row -->                
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-text fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">

                                        <?php 
                                            
                                            $post_counts = recordCount('posts');
                                            echo "<div class='huge'>$post_counts</div>"
                                        ?>

                                            <div>Posts</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="posts.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">

                                        <?php 
                                            $comment_counts = recordCount('comments');
                                            echo "<div class='huge'>$comment_counts</div>"
                                        ?>

                                        <div>Comments</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="comments.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">

                                        <?php 
                                            $user_counts = recordCount('users');
                                            echo "<div class='huge'>$user_counts</div>"
                                        ?>

                                            <div> Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="users.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">

                                        <?php 
                                            $category_counts = recordCount('categories');
                                            echo "<div class='huge'>$category_counts</div>"
                                        ?>

                                            <div>Categories</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="categories.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <!-- /.row -->
                </div>
                <!-- /.row -->

                <?php 
                    // SELECT query with function that containts three dynamic arguments
                    $post_published_counts = checkStatus('posts', 'post_status', 'published');
                    $post_draft_counts = checkStatus('posts', 'post_status', 'draft');
                    $unapproved_comments_count = checkStatus('comments', 'comment_status', 'unapproved');
                    $subscriber_count = checkStatus('users', 'user_role', 'subscriber');
                ?>

                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            <?php 
                                $elements_text = ["All posts", "Active posts", "Draft posts", "Comments", "Pending comments", 'Users', "Subscribers", "Categories"];
                                $elements_count = [$post_counts, $post_published_counts, $post_draft_counts, $comment_counts, $unapproved_comments_count, $user_counts, $subscriber_count, $category_counts];

                                for($i = 0; $i < 7; $i++) {
                                    echo "['{$elements_text[$i]}'" . ", " . "{$elements_count[$i]}],";
                                }
                            ?>

                            // ['Posts', 1000],
                            ]);

                            var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>

                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>


                </div>
            <!-- /.container-fluid -->
            </div>
        </div>
        <!-- /#page-wrapper -->
        
<?php include 'includes/admin_footer.php' ?>