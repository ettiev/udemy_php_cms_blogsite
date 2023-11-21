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
                    if (isset($_GET['category'])) {
                        
                        $post_category_id = escape($_GET['category']);
                        
                ?>

                <h1 class="page-header">
                    By Category
                    <small>All Authors</small>
                </h1>
                
                <?php    
                        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                            $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id ";    
                        } else {
                            $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published' ";
                        }
                       
                        $select_all_posts_query = mysqli_query($connection, $query);

                        if (mysqli_num_rows($select_all_posts_query) < 1) {
                            echo "<h2 class='text-center'>No posts available, select a different catagory!</h2>";
                        } else {
                            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                                $post_id = escape($row['post_id']);
                                $post_title = escape($row['post_title']);
                                $post_author = escape($row['post_author']);
                                $post_user = escape($row['post_user']);
                                $post_date = escape($row['post_date']);
                                $post_image = escape($row['post_image']);
                                $post_content = substr(escape($row['post_content']), 0, 200) . "...";

                                if (empty(trim($post_user))) {
                                    if (!empty(trim($post_author))) {
                                    $post_user = $post_author;
                                    } else {
                                        $post_user = "Anonymous";
                                    }
                                } 
                            ?>   
                                    
                                <!-- First Blog Post -->
                                <h2>
                                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="/cms/index.php"><?php echo $post_user ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                                <hr>
                                <img class="img-responsive" src="/cms/images/<?php echo $post_image ?>" alt="">
                                <hr>
                                <p><?php echo $post_content ?></p>
                                <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    
                                <hr>
                            <?php }
                            }
                     
                        } else {
                            header("Location: /cms/index.php");
                            
                        } ?>    

            </div> 
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        <!-- /.row -->

        <hr>

       <?php include "includes/footer.php" ?>