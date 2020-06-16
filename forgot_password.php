<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
?>

<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

<?php 
    // Load Composer's autoloader
    require 'vendor/autoload.php';
    // require './classes/Config.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    // echo get_class($mail);
    // !ifItIsMethod('get') || 
    if(!isset($_GET['forgot'])) {
        redirect('index');
    }

    if(ifItIsMethod('post')) {
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        if(isset($_POST['email'])) {
            if(email_exist($email)) {
                if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ? ")) {
                    mysqli_stmt_bind_param($stmt, 's', $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    try {
                        //Server settings
                        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        // $mail->Host       = Config::SMTP_HOST;
                        $mail->Host       = 'smtp.mailtrap.io';
                        $mail->SMTPAuth   = true;
                        // $mail->Username   = Config::SMTP_USER;
                        $mail->Username   = '6096c78791de6d';
                        // $mail->Password   = Config::SMTP_PASSWORD;
                        $mail->Password   = "2eca3852f1ba35";
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        // $mail->Port       = Config::SMTP_HOST;
                        $mail->Port       = 2525;    
                        $mail->CharSet = 'UTF-8';

                        //Recipients
                        $mail->setFrom('f.scheeren@outlook.com', 'Mailer');
                        $mail->addAddress('fabio@freshco.nl', 'Joe User');     // Add a recipient
                        $mail->addAddress('ellen@example.com');               // Name is optional
                        $mail->addReplyTo('info@example.com', 'Information');
                        $mail->addCC('cc@example.com');
                        $mail->addBCC('bcc@example.com');

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Here is the subject';
                        $mail->Body    = '<p>
                        Please click here to reset your password.</p>
                        <a href="http://localhos/cms/reset.php?email='.$email.'&token='.$token.'">http://localhost:888/cms/reset.php?email=" '.$email.'&token='.$token.'"</a>';
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        // echo 'Message has been sent';
                        $emailSent = true;
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                } else {
                    echo "Something wrong";
                }
            }
        }
    }
?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if(!isset($emailSent)): ?>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            <?php else: ?>
                                <h1>Please check your mail!</h1>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

