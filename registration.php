<?php include "admin/functions.php" ?>
<?php  include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    
    <?php 
        if(isset($_POST['submit'])) {
            $username   = trim($_POST['username']);
            $email      = trim($_POST['email']);
            $password   = trim($_POST['password']);

            $error = [
                'username' => '',
                'email' => '',
                'password' => ''
            ];

            // Username validation
            if(strlen($username) < 4) {
                $error['username'] = 'Username needs to be at least 4 character.';
            }
            if($username == "") {
                $error['username'] = 'Username can not be empty.';
            }
            if(username_exist($username)) {
                $error['username'] = "Username exists";
            }

            // Email validation
            if(email_exist($email)) {
                $error['email'] = "Email is already in use.";
            }
            if($email == "") {
                $error['email'] = 'Email can not be empty.';
            }

            if($email == "") {
                $error['email'] = 'Email can not be empty.';
            }

            // Password validation
            if($password == "") {
                $error['password'] = 'Password can not be empty.';
            }

            foreach($error as $key => $value) {
                if (empty($value)) {
                    unset($error[$key]);
                }
            }

            if (empty($error)) {
                register_user($username, $email, $password);
                login_user($username, $password);
            }

        }
    ?>

    <!-- Page Content -->
    <div class="container">    
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Register</h1>
                            <!-- <p><?php echo $message; ?></p> -->
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete='on' value="<?php echo isset($username) ? $username : "" ?>">
                                    <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete='on' value="<?php echo isset($email) ? $email : "" ?>">
                                    <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                </div>
                        
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>

<hr>

<?php include "includes/footer.php";?>
