<?php 

    if(isset($_POST['submit'])) {
        $post_title = escape($_POST['title']);
        $post_category_id = escape($_POST['post_category']);
        $post_user = escape($_POST['post_user']);
        $post_status = escape($_POST['status']);
        
        $post_image = escape($_FILES['image']['name']);
        
        $post_image_temp = escape($_FILES['image']['tmp_name']);

        $post_tags = escape($_POST['tags']);
        $post_content = escape($_POST['content']);
        $post_date = escape(date('d-m-y'));
        //$post_comment_count = 0;

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) ";
        $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}' )";
        
        $create_post_query = mysqli_query($connection, $query);

        confirm($create_post_query);

        $the_post_id = mysqli_insert_id($connection);

        echo "<p class='bg-success'>Post Added! <a href='../post.php?p_id={$the_post_id}'>View This Post</a> or <a href='posts.php'>View All Posts</a> </p>";

    }

?>

<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="post_title">Post Title:</label>
        <input type="text" name="title" class="form-control">
    </div>

    <div class="form-group">
        <label for="category_id">Post Category Id:</label>
        <select name="post_category" id="post_category">
            <?php
                $query = "SELECT * FROM categories";
                $select_catagories = mysqli_query($connection, $query);
                confirm($select_catagories);
                                                
                while ($row = mysqli_fetch_assoc($select_catagories)) {
                    $cat_id = escape($row['id']);
                    $cat_title = escape($row['cat_title']);
                    echo "<option value='$cat_id'>{$cat_title}</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_user">Post Author:</label>
        <select name="post_user" id="post_user">
            <?php
                $query = "SELECT * FROM users ";
                $select_users = mysqli_query($connection, $query);
                confirm($select_users);
                                                
                while ($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = escape($row['user_id']);
                    $username = escape($row['username']);
                    echo "<option value='$username'>{$username}</option>";
                }
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="status">Post Status:</label>
        <select name="status" id="status">
            <option value='draft'>Select Options:</option>
            <option value='draft'>Draft</option>
            <option value='published'>Publish</option>
        </select>
    </div>
    
     <div class="form-group">
        <label for="image">Post Image:</label>
        <input type="file" name="image" >
    </div>

    <div class="form-group">
        <label for="tags">Post Tags:</label>
        <input type="text" name="tags" class="form-control">
    </div>

    <div class="form-group">
        <label for="summernote">Post Content:</label>
        <textarea name="content" class="form-control" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="submit" value="Add Post">
    </div>
</form>