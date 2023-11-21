<?php 

    if(isset($_GET['edit_user'])){
        $the_user_id = escape($_GET['edit_user']);

            $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
            $select_user_query = mysqli_query($connection, $query);
                                                                            
            while ($row = mysqli_fetch_assoc($select_user_query)) {
                $user_firstname = escape($row['user_firstname']);
                $user_lastname = escape($row['user_lastname']);
                $user_role = escape($row['user_role']);
                $username = escape($row['username']);
                $user_email = escape($row['user_email']);
            }

    

            if(isset($_POST['update_user'])) {
                $user_firstname = escape($_POST['user_firstname']);
                $user_lastname = escape($_POST['user_lastname']);
                $user_role = escape($_POST['user_role']);
                $username = escape($_POST['username']);
                $user_email = escape($_POST['user_email']);
                $user_password = escape($_POST['user_password']);

                //PICTURE
                // $post_image = $_FILES['image']['name'];
                // $post_image_temp = $_FILES['image']['tmp_name'];
                
                //$post_date = date('d-m-y');
                //$post_comment_count = 0;

                //move_uploaded_file($post_image_temp, "../images/$post_image");

                //OLD WAY OF PASSWORD ENCRYPTION
                // $query = "SELECT randSalt FROM users";
                // $select_randsalt_query = mysqli_query($connection, $query);
                // if (!$select_randsalt_query) {
                //     die("Query Failed" . mysqli_error($connection));
                // }
                // $row = mysqli_fetch_array($select_randsalt_query); 
                // $salt = $row['randSalt'];
                // $hashed_password = crypt($user_password, $salt);

                if(!empty($user_password)) {
                    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
                    $query_password = "UPDATE users SET ";
                    $query_password .= "user_password = '{$hashed_password}' ";
                    $query_password .= "WHERE user_id = {$the_user_id} ";
                    $update_password_query = mysqli_query($connection, $query_password);
                    confirm($update_password_query); 
                }
                        
                $query = "UPDATE users SET ";        
                $query .= "user_firstname = '{$user_firstname}', ";
                $query .= "user_lastname = '{$user_lastname}', ";
                $query .= "user_role = '{$user_role}', ";
                $query .= "username = '{$username}', ";
                $query .= "user_email = '{$user_email}' ";
                $query .= "WHERE user_id = {$the_user_id} ";
                
                $update_user_query = mysqli_query($connection, $query);

                confirm($update_user_query);

                header("Location: users.php");

            }

    } else {
        header("Location: index.php");
    }   


?>

<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="user_firstname">Firstname:</label>
        <input type="text" name="user_firstname" class="form-control" value="<?php echo $user_firstname; ?>">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname:</label>
        <input type="text" name="user_lastname" class="form-control" value="<?php echo $user_lastname; ?>">
    </div>

    <div class="form-group">
        <label for="user_role">User Role:</label>
        <select name="user_role" id="user_role">
            <option value="<?php echo $user_role?>"><?php echo ucfirst($user_role); ?></option>
            <?php
                if ($user_role == "admin") {
                    echo "<option value='subscriber'>Subscriber</option>"; 
                } else {
                    echo "<option value='admin'>Admin</option>";
                }
            ?>
                       
        </select>
    </div>

    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
    </div>

    <div class="form-group">
        <label for="user_email">User Email:</label>
        <input type="email" name="user_email" class="form-control" value="<?php echo $user_email; ?>">
    </div>

    <div class="form-group">
        <label for="user_password">Password:</label>
        <input type="password" name="user_password" class="form-control" value="" autocomplete="off" placeholder="Leave empty to keep current password.">
    </div>

    <!-- <div class="form-group">
        <label for="image">Post Image:</label>
        <input type="file" name="image" >
    </div> -->

   
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
    </div>
</form>