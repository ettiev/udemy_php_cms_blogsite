<?php 

    if(isset($_POST['submit'])) {
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);


        // $post_image = $_FILES['image']['name'];
        // $post_image_temp = $_FILES['image']['tmp_name'];
        
        //$post_date = date('d-m-y');
        //$post_comment_count = 0;

        //move_uploaded_file($post_image_temp, "../images/$post_image");

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";
        $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}' )";
        
        $create_user_query = mysqli_query($connection, $query);

        confirm($create_user_query);

        echo "User Created: " . "<a href='users.php'>View Users</a>";

    }

?>

<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="user_firstname">Firstname:</label>
        <input type="text" name="user_firstname" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname:</label>
        <input type="text" name="user_lastname" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_role">User Role:</label>
        <select name="user_role" id="user_role">
            <option value="subscriber">Select Option:</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_email">User Email:</label>
        <input type="email" name="user_email" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_password">Password:</label>
        <input type="password" name="user_password" class="form-control">
    </div>

    <!-- <div class="form-group">
        <label for="image">Post Image:</label>
        <input type="file" name="image" >
    </div> -->

   
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="submit" value="Add User">
    </div>
</form>