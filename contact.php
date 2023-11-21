<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php

if (isset($_POST['submit'])) {

    
    $email = escape($_POST['email']);
    $subject = escape($_POST['subject']);
    $body = escape($_POST['body']);
    $to = "myfakewebdevco@gmail.com";
    $header = "From: " . $email;

    if (!empty($email) && !empty($subject) && !empty($body)) {
        
        // use wordwrap() if lines are longer than 70 characters
        $body = wordwrap($body,70);

        // send email
        mail($to, $subject, $body, $header);
       

        $message = "Your message was sent successful!!";
    
    } else {
        $message = "Fields cannot be empty! Please fill all fields!";
    }
    
} else {
    $message = "";
}

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Us</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message ?></h6>
                        
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter message subject">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Message</label>
                            <textarea class="form-control" name="body" id="message" cols="50" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send Message">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
