<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms/index">CMS Front</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <?php
                        $category_class = '';
                        $registration_class = '';
                        $contact_class = '';

                        $pageName = basename($_SERVER['PHP_SELF']);
                        $registration = 'registration';
                        $contact = 'contact';
                        $login = 'login';
                        if ($pageName = $registration) {
                            $registration_class = 'active';
                        } elseif ($pageName = $contact) {
                            $contact_class = 'active';
                        } elseif ($pageName = $login) {
                            $login_class = 'active';
                        }
                        // echo "pageName: " . $pageName;
                        // echo "reg Class: " . $registration_class;
                        // echo "cont Class: " . $contact_class;
                         
                        $query = "SELECT * FROM categories";
                        $select_all_catagories_query = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($select_all_catagories_query)) {
                            $cat_id = escape($row['id']);
                            $cat_title = escape($row['cat_title']);

                            if (isset($_GET['category']) && $_GET['category'] == $cat_id) {
                                $category_class = 'active';
                            }
                            echo "<li class='$category_class'><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                            $category_class = '';
                        }
                    ?>
                   
                    <?php if (isLoggedIn()): ?> 

                        <li>
                            <a href="/cms/admin">Admin</a>
                        </li>

                        <li>
                            <a href="/cms/includes/logout.php">Logout</a>
                        </li>

                    <?php else: ?>
                    
                        <li class="<?php echo $login_class; ?>">
                            <a href="/cms/login">Login</a>
                        </li>

                        <li class="<?php //echo $registration_class; ?>">
                            <a href="/cms/registration">Register</a>
                        </li>
                    
                    <?php endif; ?>
                 
                    <li class="<?php echo $contact_class; ?>">
                        <a href="/cms/contact">Contact Us</a>
                    </li>

                        <?php
                            
                            if (session_status() === PHP_SESSION_NONE) session_start();

                            if (isset($_SESSION['user_role'])) {
                                if (isset($_GET['p_id'])) {
                                    $the_post_id = $_GET['p_id'];
                                    echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                                }
                            }

                        ?>
                    
                    
                   
                    <!-- <li>
                        <a href="#">Services</a>
                    </li> -->
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>