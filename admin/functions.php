<?php

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if (isLoggedIn()){
        redirect($redirectLocation);
    }
}

function checkStatus($table, $column, $status) {
    global $connection;

    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $select_specific_posts = mysqli_query($connection, $query);
    confirm($select_specific_posts);
    if (empty($select_specific_posts)){
        return 0;
    } else {
        $result = mysqli_num_rows($select_specific_posts);
        
    }
    return $result; 
}

function checkStatusForPostsForUser($status) {
    $recordQuery = query("SELECT * FROM posts WHERE post_status = '$status' AND user_id = " . loggedInUserId() . " ");
    if (empty($recordQuery)){
        return 0;
    } else {
        $result = mysqli_num_rows($recordQuery);
    }
    return $result; 
}

function checkStatusForCommentsForUser($status) {
    $recordQuery = query("SELECT * FROM posts 
        INNER JOIN comments ON posts.post_id = comments.comment_post_id 
        WHERE posts.user_id = " . loggedInUserId() . " AND comments.comment_status = '$status'");
    if (empty($recordQuery)){
        return 0;
    } else {
        $result = mysqli_num_rows($recordQuery);
    }
    return $result;   
    
}

function checkUserRole($table, $column, $role) {
    $recordQuery = query("SELECT * FROM $table WHERE  $column = '$role' ");
    $result = mysqli_num_rows($recordQuery);
    return $result;
}


function confirm($result) {
    global $connection;

    if (!$result) {
        die("QUERY FAILED! " . mysqli_error($connection));
    }
}

function emailExists($email) {
    $emailQuery = query("SELECT user_email FROM users WHERE user_email = '$email' ");
    if(mysqli_num_rows($emailQuery) > 0){
        return true;
    } else {
        return false;
    }   
};

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function deleteCategory() {
    global $connection;

    if (isset($_GET['delete'])) {
        $the_cat_id = escape($_GET['delete']);
        $query = "DELETE FROM categories WHERE id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        
        if (!$delete_query) {
            die("QUERY FAILED! " . mysqli_error($connection));
        }
        
        header("Location: categories.php");  //refresh the page [need 'ob_start()' at start of admin_header.php]
    }
}

function findAllCategories() {
    global $connection;

    $query = "SELECT * FROM categories";
    $select_catagories = mysqli_query($connection, $query);
                                    
    while ($row = mysqli_fetch_assoc($select_catagories)) {
        $cat_id = escape($row['id']);
        $cat_title = escape($row['cat_title']);
    
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a 
                onClick= \"javascript: return confirm('Are you sure you want to delete?')\"
                href='categories.php?delete={$cat_id}'>Delete
            </a> / <a 
                href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function getPostLikes($post_id) {
    $result = query("SELECT * FROM likes WHERE post_id = {$post_id} ");
    confirm($result);
    echo mysqli_num_rows($result);
}

function getUsername() {
     return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

function ifItIsMethod($method=null){
    if ($_SERVER["REQUEST_METHOD"] == strtoupper($method)){
        return true;
    }
    return false;
}

function imagePlaceholder($image=''){
    if (!$image) {
        return("placeholder_1.jpg");
    } else {
        return $image;
    }
}


function insertCategories() {
    global $connection;
    
    if (isset($_POST['submit'])) {
        escape($cat_title = $_POST['cat_title']);
    
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty!";
        } else {
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUE('{$cat_title}') ";

            $create_category_query = mysqli_query($connection, $query);

            if (!$create_category_query) {
                die("QUERY FAILED! " . mysqli_error($connection));
            }
        }
    }
}


function isAdmin() {
    
    if (isLoggedIn()) {
        $result = query("SELECT user_role FROM users WHERE user_id = " . $_SESSION['user_id'] . " ");
        $row = mysqli_fetch_assoc($result);
        if($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }    
    }
    return false;
}

function isLoggedIn(){
    if(isset($_SESSION['username'])){
        return true;
    }
    return false;
}

function loggedInUserId() {
    if (isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "' ");
        confirm($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;    
}


function query($query) {
    global $connection;
    
    $result = mysqli_query($connection, $query);
    confirm($result);
    return $result;
}

function recordCount($table){
    $recordQuery = query("SELECT * FROM " . $table);
    $result = mysqli_num_rows($recordQuery);
    return $result;
}

function recordCountForUser($table){
    $recordQuery = query("SELECT * FROM " . $table . " WHERE user_id = " . loggedInUserId() . " ");
    $result = mysqli_num_rows($recordQuery);
    return $result;
}

function recordCountForUserLikes() {
    $recordQuery = query("SELECT SUM(post_likes) AS totalsum FROM posts WHERE user_id = " . loggedInUserId() . " ");
    $row = mysqli_fetch_assoc($recordQuery);
    $result = $row['totalsum'];
    return $result;
}

function recordCountForUserPostComments(){
    $recordQuery = query("SELECT * FROM posts 
        INNER JOIN comments ON posts.post_id = comments.comment_post_id 
        WHERE posts.user_id = " . loggedInUserId() . " ");
    $result = mysqli_num_rows($recordQuery);
    return $result;        
} 

function redirect($location) {
    header("Location: " . $location);
    exit;
};

function userLikedThisPost($post_id){
    $result = query("SELECT * FROM likes WHERE user_id = " . loggedInUserId() . " AND post_id = {$post_id} ");
    confirm($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
};

function userLogin($username, $password) {
    global $connection;

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    confirm($select_user_query);

    while($row = mysqli_fetch_assoc($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        //$salt = $row['randSalt'];
    }
    // $password = crypt($password, $salt);
    // if ($username === $db_username && $password === $db_user_password) {
    if (password_verify($password, $db_user_password)) {
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        redirect("/cms/admin");
    } else {
        redirect("/cms/index.php");
    }
}


function usernameExists($username) {
    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }   
};

function userRegister($username, $email, $password) {
    global $connection;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        // ALTERNATIVE WAY
        // $query = "SELECT randSalt FROM users";
        // $select_randsalt_query = mysqli_query($connection, $query);
        // if (!$select_randsalt_query) {
        //     die("Query Failed" . mysqli_error($connection));
        // }
        // $row = mysqli_fetch_array($select_randsalt_query); 
        // $salt = $row['randSalt'];
        // $password = crypt($password, $salt);
    $query = "INSERT INTO users(username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber' )";
    $register_user_query = mysqli_query($connection, $query);
    
    confirm($register_user_query);
};

function users_online() {
    
    if (isset($_GET["onlineusers"])) {
        global $connection;

        if (!$connection) {
            session_start();
            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 30;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session' ";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', '$time') ");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session' ");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
}
users_online();


















//========= DATBASE HELPERS =========//





?>