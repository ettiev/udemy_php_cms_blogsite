<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php

                    if (isset($_GET['author'])) {
                        $the_post_author = escape($_GET['author']); 
                    }

                    $author = '';

                    if (!empty($the_post_user)) {
                        $query = "SELECT * FROM posts WHERE post_user = '{$the_post_user}' ";
                        $author = '$the_post_user';     
                    } elseif (!empty($the_post_author)) {
                        $query = "SELECT * FROM posts WHERE post_user = '{$the_post_user}' ";
                        $author = '$the_post_author';     
                    } elseif (empty($the_post_user) && empty($the_post_author)){
                        $query = "SELECT * FROM posts WHERE post_user = '' AND post_author = '' ";
                        $author = 'Anonymous';    
                    }
                    $select_all_posts_query = mysqli_query($connection, $query);
                    ?>

                        <h1 class="page-header">
                            Blogposts by Author
                            <small>All posts by <?php echo $author ?></small>
                        </h1>

                    <?php
                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_title = escape($row['post_title']);
                        $post_author = escape($row['post_user']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = escape($row['post_content']);
                    ?>   
                        

                        <h2>
                            <a href="#"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <?php echo $post_author ?>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <hr>
                    <?php } ?>    
                               
            </div> 
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        <!-- /.row -->

        <hr>

       <?php include "includes/footer.php" ?>

