<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <?php

    if(isset($_POST['liked'])){
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $query = "SELECT * FROM posts WHERE post_id = $post_id ";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['post_likes'];

        echo "{$post['post_likes']}";

        mysqli_query($connection, "UPDATE posts SET post_likes = $likes +1 WHERE post_id = $post_id");

        mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES ($user_id, $post_id) ");
        exit();
    }

    if(isset($_POST['unliked'])){

        echo "Post was unliked!";

        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $query = "SELECT * FROM posts WHERE post_id = $post_id ";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['post_likes'];
        
        mysqli_query($connection, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id ");
        
        mysqli_query($connection, "UPDATE posts SET post_likes = $likes-1 WHERE post_id = $post_id");
     
        exit();
    }

    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    View Individual Post
                    <!-- <small></small> -->
                </h1>

                <?php

                    if (isset($_GET['p_id'])) {
                        $the_post_id = escape($_GET['p_id']);
                        
                        $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id "; 
                        $send_query = mysqli_query($connection, $view_query);

                        if (!$send_query) {
                            die("Query Failed" . mysqli_error($connection));
                        };

                        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";    
                        } else {
                            $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
                        }

                        
                        $select_all_posts_query = mysqli_query($connection, $query);

                        $count = mysqli_num_rows($select_all_posts_query);
                        if ($count < 1) {
                            echo "<h2 class= text-center>No posts available!</h2>";
                        } else {

                            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                                $post_title = escape($row['post_title']);
                                $post_author = escape($row['post_author']);
                                $post_user = escape($row['post_user']);
                                $post_date = escape($row['post_date']);
                                $post_image = escape($row['post_image']);
                                $post_content = escape($row['post_content']);
                            
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
                                    <a href="#"><?php echo $post_title ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="/cms/author_posts.php?author={<?php echo $post_user ?>}"><?php echo $post_user ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                                <hr>
                                <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image) ?>" alt="">
                                <hr>
                                <p><?php echo $post_content ?></p>

                                <?php // mysqli_stmt_free_result($stmt); ?>

                                <hr>
                                
                                <?php if (isLoggedIn()) { ?>

                                <div class="row">
                                    <p class="pull-right">
                                        <a class="<?php echo userLikedThisPost($the_post_id) ? 'btn btn-danger unlike' : 'btn btn-success like' ?>" href=""> 
                                                <span class="<?php echo userLikedThisPost($the_post_id) ? 'glyphicon glyphicon-thumbs-down' : 'glyphicon glyphicon-thumbs-up' ?>"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="<?php echo userLikedThisPost($the_post_id) ? ' You liked this before.' : ' Want to like this?' ?>">
                                                </span> <?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like' ?></a></p>
                                </div>

                                <?php } else { ?>
                                    <div class="row">
                                        <p class="pull-right likes">Please <a href="/cms/login.php">Login</a> to be able to like the blogpost!</p>
                                    </div>
                                <?php } ?>

                                <div class="row">
                                    <p class="pull-right likes">Likes: <?php getPostLikes($the_post_id) ?></p>
                                </div>

                            <?php }
                        
                        ?>   
                    
                            <!-- Blog Comments -->
                            
                            <?php

                                if (isset($_POST["create_comment"])) {
                                
                                    $the_post_id = escape($_GET['p_id']);

                                    $comment_author = escape($_POST['comment_author']);
                                    $comment_email = escape($_POST['comment_email']);
                                    $comment_content = escape($_POST['comment_content']);


                                    if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                                        $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now() )";
                                        
                                        $create_comment_query = mysqli_query($connection, $query);

                                        if (!$create_comment_query) {
                                            die("QUERY FAILED! " . mysqli_error($connection));
                                        }

                                        // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                                        // $query .= "WHERE post_id = {$the_post_id}";
                                        // $update_comment_count = mysqli_query($connection, $query);

                                        
                                    } else {
                                        echo "<script>alert('Fields cannot be empty!')</script>";
                                    };
                                    //header("Location: /cms/post.php?p_id=$the_post_id");
                                };
                                                
                            ?>

                            <!-- Comments Form -->
                            <div class="well">
                                <h4>Leave a Comment:</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-group">
                                        <label for="author">Author:</label>
                                        <input class="form-control" type="text" name="comment_author">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input class="form-control" type="email" name="comment_email">
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Your comment:</label>
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
                                    die("QUERY FAILED! " . mysqli_error($connection));
                                }

                                while ($row = mysqli_fetch_assoc($select_comment_query)) {
                                    $comment_date = escape($row['comment_date']);
                                    $comment_content = escape($row['comment_content']);
                                    $comment_author = escape($row['comment_author']);
                            ?>    
                                
                                    <div class="media">
                                        <a class="pull-left" href="#">
                                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><?php echo $comment_author; ?>
                                                <small><?php echo $comment_date; ?></small>
                                            </h4>
                                            <?php echo $comment_content; ?>
                                        </div>
                                    </div>
                    
                    <?php        
                        }
                    
                    }

                } else {

                    header("Location: index.php");

                }
                ?>

                <!-- Comment -->


               
            </div> 
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        <!-- /.row -->

        <hr>

        
       <?php include "includes/footer.php" ?>
    
       <script>
            $(document).ready(function(){

                $("[data-toggle = 'tooltip']").tooltip();

                var post_id = <?php echo $the_post_id; ?>;
                var user_id = <?php echo loggedInUserId() ?>;

                $('.like').click(function(){
                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: "post",
                        data: {
                            liked: 1,
                            'post_id': post_id,
                            'user_id': user_id

                        }
                    });
                });

                $('.unlike').click(function(){
                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: "post",
                        data: {
                            unliked: 1,
                            'post_id': post_id,
                            'user_id': user_id

                        }
                    });
                });

            })

        </script>
