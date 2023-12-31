<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the Admin Page!
                            <small>Author</small>
                        </h1>

                        <div class="col-xs-6">

                        <?php // INSERT CATEGORY QUERY
                          insertCategories();  
                        ?>

                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Category Title:</label>
                                    <input type="text" name="cat_title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>
                            </form>

                            <?php // UPDATE AND INCLUDE QUERY
                                if (isset($_GET['edit'])){
                                    
                                    $cat_id = escape($_GET["edit"]);
                                    include "includes/update_catagories.php";    
                                }
                            ?>       

                        </div>
                        
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php  //FIND ALL CATEGORIES QUERY
                                    findAllCategories() 
                                ?>

                                <?php // DELETE QUERY
                                    deleteCategory()   
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php" ?>   