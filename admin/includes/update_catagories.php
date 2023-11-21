                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Edit Category:</label>

                                    <?php 
                                        
                                        if (isset($_GET["edit"])) {
                                            $cat_id = escape($_GET['edit']);

                                            $query = "SELECT * FROM categories WHERE id = $cat_id ";
                                            $select_catagories_id = mysqli_query($connection, $query);
                                            
                                            while ($row = mysqli_fetch_assoc($select_catagories_id)) {
                                                $cat_id = escape($row['id']);
                                                $cat_title = escape($row['cat_title']);
                                            ?>
                                            
                                                <input 
                                                    type="text" 
                                                    name="cat_title" 
                                                    class="form-control" 
                                                    value= <?php if(isset($cat_title)) {echo $cat_title;} ?>>
                                                                           
                                            <?php }
                                        
                                        } ?>

                                        <?php   // UPDATE QUERY

                                            if (isset($_POST['update_category'])) {
                                                $the_cat_title = $_POST['cat_title'];
                                                $query = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE id = {$cat_id} ";
                                                $update_query = mysqli_query($connection, $query);

                                                if (!$update_query) {
                                                    die("QUERY FAILED! " . mysqli_error($connection));
                                                }
                                            } 

                                        ?>

                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="update_category" value="Update">
                                </div>
                            </form>