<?php

if(ifItIsMethod('post')){
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            userLogin(escape(trim($_POST['username'])), escape(trim($_POST['password'])));
        } else {
            redirect('/cms/index');
        }    
    }
}

?>

<div class="col-md-4">

<!-- Blog Search Well -->


<div class="well">
    <h4>Blog Search</h4>
    <form action="search.php" method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
    </form>
    <!-- /.input-group -->
</div>

<!-- Login -->


<div class="well">
    <?php // if (isset($_SESSION['user_role'])): ?>
        <?php if (isLoggedIn()): ?>
    
        <h4>Logged in as <?php echo escape($_SESSION['username']) ?></h4>
        <h5>User role: <?php echo escape($_SESSION['user_role']) ?></h5>

        <a href="/cms/includes/logout.php" class="btn btn-primary">Logout</a>

    <?php else: ?>

        <h4>Login</h4>
        <form action="" method="post">
            <div class="form-group">
                <input name="username" type="text" class="form-control" placeholder="Enter Username">
            </div>
            <div class="input-group">
                <input name="password" type="password" class="form-control" placeholder="Enter Password">
                <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Login</button>
                </span>
            </div>
        <div class="form-group">
            <a href="/cms/forgot.php?forgot=<?php echo uniqid(true)?>">Forgot Password</a>
        </div>
        
        </form>


    <?php endif; ?>


    <!-- /.input-group -->
</div>

<!-- Blog Categories Well -->
<div class="well">

    <?php
        $query = "SELECT * FROM categories";
        $select_catagories_sidebar = mysqli_query($connection, $query);
    
    ?>

    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">

                <?php
                    while ($row = mysqli_fetch_assoc($select_catagories_sidebar)) {
                       $cat_title = $row['cat_title'];
                       $cat_id = $row['id'];
            
                       echo "<li><a href='/cms/category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }
                ?>

            </ul>
        </div>
        
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<?php include "widget.php" ?>

</div>

</div>