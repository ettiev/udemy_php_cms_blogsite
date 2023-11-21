<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php echo loggedInUserId(); 

if (userLikedThisPost(31)) {
    echo "USER LIKED THE POST!!";
} else {
    echo "USER DID NOT LIKE THE POST!!";
}

?>