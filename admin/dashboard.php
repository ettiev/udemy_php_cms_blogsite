<?php include "includes/admin_header.php" ?>

    <div id="wrapper">
         <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the Admin Dashboard! (all users) <br />
                            <small>Logged in as: <?php echo strtoupper(getUsername()) ?></small>
                        </h1>
                    </div>
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
                                        <div class='huge'><?php echo $post_count = recordCount('posts'); ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./posts.php">
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
                                    
                                    <div class='huge'><?php echo $comment_count = recordCount('comments'); ?></div>
                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./comments.php">
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
                                    
                                    <div class='huge'><?php echo $user_count = recordCount('users'); ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./users.php">
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

                                    <div class='huge'><?php echo $cat_count = recordCount('categories'); ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./categories.php">
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
                
                <?php

                    $post_published_count = checkStatus('posts', 'post_status', 'published');    
                   
                    $post_draft_count = checkStatus('posts', 'post_status', 'draft');

                    $comment_draft_count = checkStatus('comments', 'comment_status', 'unapproved');
           
                    $subscriber_count = checkUserRole('users', 'user_role', 'subscriber');

                    //$post_published_count = 0;    
                   
                    //$post_draft_count = 0;

                    //$comment_draft_count = 0;
           
                    //$subscriber_count = 0;


                ?>
                <!-- <?php

                // echo $post_count . "<br />"; 
                // echo $post_published_count . "<br />" ;
                // echo $post_draft_count . "<br />";
                // echo $comment_count . "<br />";
                // echo $comment_draft_count . "<br />"; 
                // echo $user_count . "<br />";
                // echo $subscriber_count . "<br />"; 
                // echo $cat_count . "<br />";

                ?> -->

                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            
                            <?php
                               
                               $element_text = ["All Posts", "Active Posts", "Draft Posts", "Comments", "Unapproved Comments", "Users", "Subscribers", "Categories"];
                               $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $comment_draft_count, $user_count, $subscriber_count, $cat_count];

                                for ($i = 0; $i < 8; $i++) {
                                    echo "['{$element_text[$i]}', {$element_count[$i]}],";
                                }

                            ?>
                                                                                   
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

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php" ?>