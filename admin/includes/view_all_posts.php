<?php
include ("delete_modal.php");

    if (isset($_POST['checkBoxArray'])) {
        
        foreach($_POST['checkBoxArray'] as $postValueId){
            $bulk_options = escape($_POST['bulk_options']);

            switch ($bulk_options) {
            
            case 'published' :
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_published_query = mysqli_query($connection, $query);
                confirm($update_published_query);
                break;
            
            case 'draft' :
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_draft_query = mysqli_query($connection, $query);
                confirm($update_draft_query);
                break;
            
            case 'clone' :
                $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                $select_post_query = mysqli_query($connection, $query);
                
                while ($row = mysqli_fetch_assoc($select_post_query)) {
                    $post_title = escape($row['post_title']);
                    $post_category_id = escape($row['post_category_id']);
                    $post_date = escape($row['post_date']);
                    $post_author = escape($row['post_author']);
                    $post_user = escape($row['post_user']);
                    $post_status = escape($row['post_status']);
                    $post_image = escape($row['post_image']);
                    $post_tags = escape($row['post_tags']);
                    $post_content = escape($row['post_content']);
                }
                
                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_status, post_image, post_tags, post_content) ";
                $query .= " VALUES({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}', now(), '{$post_status}', '{$post_image}', '{$post_tags}','{$post_content}') ";
                $copy_query = mysqli_query($connection, $query);

                if (!$copy_query) {
                    die("Query Failed!" . mysqli_error($connection));
                }
                break;
                    
            case 'delete' :
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $delete_query = mysqli_query($connection, $query);
                confirm($delete_query);
                header("Location: posts.php");
                break; 
            }
         }
    }
?>

<form action="" method="post">
    <table class="table table-bordered table-hover">
        
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div class="col-xs-4">
            <button type="submit" name="submit" class="btn btn-success">Apply</button>
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
    
    
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllBoxes" name=""></th>
                <th>Id</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>Options</th>

            </tr>
        </thead>
        <tbody>
                                    
        <?php
                                        
            //$query = "SELECT * FROM posts ORDER BY post_id DESC";
            $session_user = $_SESSION['user_id'];

            if ($_SESSION['user_role'] === 'admin'){
                $query = "SELECT posts.post_id, posts.user_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
                $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.id, categories.cat_title ";
                $query .= "FROM posts ";
                $query .= "LEFT JOIN categories ON posts.post_category_id = categories.id ORDER BY posts.post_id DESC";    
            } else {
                $query = "SELECT posts.post_id, posts.user_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
                $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.id, categories.cat_title ";
                $query .= "FROM posts ";
                $query .= "LEFT JOIN categories ON posts.post_category_id = categories.id ";
                $query .= "WHERE posts.user_id = '{$session_user}' ";
                $query .= "ORDER BY posts.post_id DESC ";
            }

            $select_posts = mysqli_query($connection, $query);
                                                                            
            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = escape($row['post_id']);
                $post_title = escape($row['post_title']);
                $post_author = escape($row['post_author']);
                $post_user = escape($row['post_user']);
                $post_category_id = escape($row['post_category_id']);
                $post_status = escape($row['post_status']);
                $post_image = escape($row['post_image']);
                $post_tags = escape($row['post_tags']);
                $post_comment_count = escape($row['post_comment_count']);
                $post_date = escape($row['post_date']);
                $post_view_count = escape($row['post_views_count']);
                $cat_id = escape($row['id']);
                $cat_title = escape($row['cat_title']);
                                                
                echo "<tr>";
                ?>
                
                <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
                
                <?php
                echo "<td>{$post_id}</td>";
                
                if (!empty(trim($post_author))) {
                    echo "<td>{$post_author}</td>";
                } elseif (!empty(trim($post_user))) {
                    echo "<td>{$post_user}</td>";
                } else {
                    echo "<td>Anonymous</td>";
                }
                
                echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

                // $query = "SELECT * FROM categories WHERE id = {$post_category_id} ";
                // $select_catagories_id = mysqli_query($connection, $query);
                                                
                // while ($row = mysqli_fetch_assoc($select_catagories_id)) {
                //     $cat_id = escape($row['id']);
                //     $cat_title = escape($row['cat_title']);
                // }

                if (empty(trim($cat_title))) {
                    echo "<td>No Category</td>";
                } else {
                    echo "<td>{$cat_title}</td>";
                }
  
                echo "<td>{$post_status}</td>";
                echo "<td><img src='../images/". imagePlaceholder($post_image). "' alt='post image' height='80px'/></td>";
                
                if (empty(trim($post_tags))) {
                    echo "<td>No Tags</td>";
                } else {
                    echo "<td>{$post_tags}</td>";
                }
                
                
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                $count_comments_query = mysqli_query($connection, $query);
                confirm($count_comments_query);

                $row = mysqli_fetch_array($count_comments_query);
                //$comment_id = $row['comment_id'];

                $post_comment_count = mysqli_num_rows($count_comments_query);
                                
                echo "<td><a href='post_comments.php?id={$post_id}'>{$post_comment_count}</a></td>";

                echo "<td>{$post_date}</td>";
                echo "<td><a href='posts.php?reset={$post_id}'> {$post_view_count} </a></td>";
                // echo 
                //     "<td><a 
                //         href='posts.php?source=edit_post&p_id={$post_id}'
                //     >Edit</a> / <a 
                //         onClick= \"javascript: return confirm('Are you sure you want to delete?')\" 
                //         href='posts.php?delete={$post_id}'
                //     >Delete</a></td>";

                echo 
                    "<td>
                    <a 
                        href='posts.php?source=edit_post&p_id={$post_id}'
                        class='btn btn-primary options'
                    >Edit</a> ";
                ?>

                <form method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                    <input 
                        class="btn btn-danger options" 
                        type="submit" 
                        name="delete" 
                        value="Delete">
                </form>

                <?php
                echo    
                    "</td>";

                echo "</tr>";
            }

        ?>
         
        </tbody>
    </table>
</form>

<?php

        if (isset($_POST['delete'])) {
            $the_post_id = escape($_POST['post_id']);

            $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
            $delete_query = mysqli_query($connection, $query);
            confirm($delete_query);

            header("Location: posts.php");

        }

        if (isset($_GET['reset'])) {
            $the_post_id = escape($_GET['reset']);

            $post_views_count = 0;
            $query = "UPDATE posts SET ";
            $query .= "post_views_count = {$post_views_count} ";
            $query .= "WHERE post_id = " . escape($the_post_id) . " ";
        
            $reset_views_post_query = mysqli_query($connection, $query);

            confirm($reset_views_post_query);

            echo "<p class='bg-success'> Total views have been reset! <a href='../post.php?p_id={$the_post_id}'>View Post.</p>";
            
            header("Location: posts.php");
        }
?>

<script>
    $(document).ready(function() {
        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";
           
            $(".modal-delete-link").attr("href", delete_url);
            $("#myModal").modal('show')
           
        }); 
      
    });
</script>