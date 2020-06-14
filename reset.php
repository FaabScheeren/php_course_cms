<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

<?php 
    if(!isset($_GET['email']) && !isset($_GET['token'])) {
        redirect('index');
    }

    // $token = "1a3edd5a32bf59e549f2624afc2ae965c75d6f706643ae6217001de005e6c65fc5c3704b9b604811a24fa5014ed72da9ff4c";
    // $email = 'Bal@Bal.nl';

    if($stmt = mysqli_prepare($connection, "SELECT username, user_email, token FROM users WHERE token=?")) {
        mysqli_stmt_bind_param($stmt, 's', $_GET['token']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        // echo $user_email;

        // if($_GET['token'] !== $token || $_GET['email'] !== $email) {
        //     redirect('index');
        // }

        if(isset($_POST['password']) && isset($_POST['passwordConfirm'])) {
            $password = $_POST['password'];
            $confirmPassword = $_POST['passwordConfirm'];

            if($password === $confirmPassword) {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password='{$hashed_password}' WHERE user_email = ? "))
                mysqli_stmt_bind_param($stmt, 's', $_GET['email']);
                mysqli_stmt_execute($stmt);

                if(mysqli_stmt_affected_rows($stmt) >= 1) {
                    redirect("/cms/login.php");
                } 
                mysqli_stmt_close($stmt);
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

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock fa-4x"></i></span>
                                            <input id="password" name="password" placeholder="Password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock fa-4x"></i></span>
                                            <input id="password" name="passwordConfirm" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

