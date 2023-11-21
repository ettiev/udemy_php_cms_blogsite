<?php include "includes/admin_header.php" ?>

<?php
    if (isset($_SESSION['username'])) {
        $username = escape($_SESSION['username']);

        $query = "SELECT * FROM users WHERE username = '{$username}' ";
        $select_user_profile_query = mysqli_query($connection, $query);

        confirm($select_user_profile_query);

        while ($row = mysqli_fetch_assoc($select_user_profile_query)) {
            $user_id = escape($row["user_id"]);
            $user_firstname = escape($row["user_firstname"]);
            $user_lastname = escape($row["user_lastname"]);
            $user_role = escape($row["user_role"]);
            $username = escape($row["username"]);
            $user_email = escape($row["user_email"]);
            $user_password = escape($row["user_password"]);

        }
    }
?>

<?php
    if (isset($_POST['update_user'])) {
        
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);


        // $post_image = $_FILES['image']['name'];
        // $post_image_temp = $_FILES['image']['tmp_name'];
        
        //$post_date = date('d-m-y');
        //$post_comment_count = 0;

        //move_uploaded_file($post_image_temp, "../images/$post_image");

        if(!empty($user_password)) {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            $query_password = "UPDATE users SET ";
            $query_password .= "user_password = '{$hashed_password}' ";
            $query_password .= "WHERE username = {$username} ";
            $update_password_query = mysqli_query($connection, $query_password);
            confirm($update_password_query); 
        }
        
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}' ";
        $query .= "WHERE username = '{$username}' ";
        
        $update_user_query = mysqli_query($connection, $query);

        confirm($update_user_query);    
    }
?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to your Profile Page!
                            <small><?php echo $username; ?></small>
                        </h1>

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
                                <label> <?php echo ucfirst($user_role); ?></label>
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
                                <input type="password" name="user_password" class="form-control" placeholder="Leave empty to keep previous password." value="" autocomplete="off">
                            </div>

                            <!-- <div class="form-group">
                                <label for="image">Post Image:</label>
                                <input type="file" name="image" >
                            </div> -->

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_user" value="Update Profile">
                            </div>
                        </form>
                     
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php" ?>   