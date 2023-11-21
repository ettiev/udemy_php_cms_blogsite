<?php 
    
    if (isset($_GET['p_id'])) {
        $the_post_id = escape($_GET['p_id']);

        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_post_by_id = mysqli_query($connection, $query);
                                                                        
        while ($row = mysqli_fetch_assoc($select_post_by_id)) {
            $post_id = escape($row['post_id']);
            $post_title = escape($row['post_title']);
            $post_user = escape($row['post_user']);
            $post_category_id = escape($row['post_category_id']);
            $post_status = escape($row['post_status']);
            $post_image = escape($row['post_image']);
            $post_tags = escape($row['post_tags']);
            $post_content = escape($row['post_content']);
            $post_comment_count = escape($row['post_comment_count']);
            $post_date = escape($row['post_date']);
            $post_views_count = escape($row['post_views_count']);
        }
    }

    if(isset($_POST['reset_views'])) {
        $post_views_count = 0;
        $query = "UPDATE posts SET ";
        $query .= "post_views_count = {$post_views_count} ";
        $query .= "WHERE post_id = {$the_post_id} ";
        
        $reset_views_post_query = mysqli_query($connection, $query);

        confirm($reset_views_post_query);

        echo "<p class='bg-success'> Total views have been reset! <a href='../post.php?p_id={$the_post_id}'>View Post.</a> or <a href='posts.php'>Edit More Posts.</a> </p>";
    }


    if(isset($_POST['update_post'])) {
        $post_title = escape($_POST['title']);
        $post_category_id = escape($_POST['post_category']);
        $post_user = escape($_POST['post_user']);
        $post_status = escape($_POST['status']);

        $post_image = escape($_FILES['image']['name']);
        $post_image_temp = escape($_FILES['image']['tmp_name']);

        $post_tags = escape($_POST['tags']);
        $post_content = escape($_POST['content']);
       
        move_uploaded_file($post_image_temp, "../images/$post_image");

        if (empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_image)) {
                $post_image = escape($row["post_image"]);
            }
        };

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_user = '{$post_user}', ";
        $query .= "post_date = now(), ";
        $query .= "post_image = '{$post_image}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_status = '{$post_status}' ";
        $query .= "WHERE post_id = {$the_post_id} ";
        
        $update_post_query = mysqli_query($connection, $query);

        confirm($update_post_query);

        echo "<p class='bg-success'>Post Updated! <a href='../post.php?p_id={$the_post_id}'>View Post.</a> or <a href='posts.php'>Edit More Posts.</a> </p>";

    }

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Blogpost views: <?php echo $post_views_count; ?></label><br />
        <input class="btn btn-primary" type="submit" name="reset_views" value="Reset Views">
    </div>
</form>

<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="post_title">Post Title:</label>
        <input type="text" name="title" class="form-control" value="<?php echo $post_title ?>">
    </div>

    <div class="form-group">
        
        <label for="post_category">Post Category Id:</label>
        <select name="post_category" id="post_category">
            
            <?php

                $query = "SELECT * FROM categories";
                $post_category = mysqli_query($connection, $query);

                confirm($post_category);
                                                
                while ($row = mysqli_fetch_assoc($post_category)) {
                    $cat_id = escape($row['id']);
                    $cat_title = escape($row['cat_title']);
                
                if ($cat_id == $post_category_id){
                    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }}
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="status">Post Author:</label>
        <select name="post_user" id="post_user">
            <?php
                $query = "SELECT * FROM users ";
                $select_users = mysqli_query($connection, $query);
                confirm($select_users);
                    
                echo "<option value='$post_user'>{$post_user}</option>";
                while ($row = mysqli_fetch_assoc($select_users)) {
                    $username = escape($row['username']);
                    echo "<option value='$username'>{$username}</option>";
                }
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="status">Post Status:</label>
        <select name="status" id="status">
            <option value="<?php echo $post_status ?>"><?php echo ucfirst($post_status) ?></option>
            <?php
                if ($post_status == "published") {
                    echo "<option value='draft'>Draft</option>";
                } else {
                    echo "<option value='published'>Publish</option>";
                }
            ?>
        
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="status">Post Status:</label>
        <input type="text" name="status" class="form-control" value=" <?php //echo $post_status ?>">
    </div> -->

    <div class="form-group">
        <label>Post Image:</label>
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="display image">
        <input type="file" name="image" >
    </div>

    <div class="form-group">
        <label for="tags">Post Tags:</label>
        <input type="text" name="tags" class="form-control" value="<?php echo $post_tags ?>">
    </div>

    <div class="form-group">
        <label for="content">Post Content:</label>
        <textarea name="content" class="form-control" id="summernote" cols="30" rows="10"><?php echo $post_content ?></textarea>
        <!-- <textarea name="content" class="form-control" id="summernote" cols="30" rows="10"><?php // echo str_replace('\r\n', '<br />', $post_content ?></textarea> (in case there is a problem with <enter> replaced with <\r\n> tags) -->
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>