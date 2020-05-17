<?php
// Include our configurations.
require_once 'libs/config.php';

// Include our user class.
require_once 'libs/User.php';

$atmt = 0;

/**
 * Process form data. 
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate an sanitize email.
    if (empty($_POST['email'])) {
        // Store an error message.
        $email_err = 'Please enter your email address.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // Store an error message.
        $email_err = 'Invalid email address.';

    } else {
        // Store the email address.
        $email = clean_data($_POST['email']);

        // Validate an sanitize password.
        if (empty($_POST['password'])) {
            // Store an error message.
            $password_err = 'Please enter your password.';

        } else {
            // Store the password.
            $password = clean_data($_POST['password']);

            // Instantiate a user object.
            $user = new User(
                null,
                $email,
                null,
                $password
            );

            // Verify user credentials.
            if (!$user->verify_user()) {
                // Store an error message.
                $error = 'Incorrect user name or password';
                $error .= '</br>';
                $error .= 'Or you accout has been blocked.';

                // Increament $atmt.
                $atmt++;

                // Get the user's ID.
                $user_id = (int) (!empty($user->get_user_id())) ? $user->get_user_id() : null;

                if (empty($user_id)) {
                    // Store an error message.
                    $error = 'Invalid user account.';
                } else {
                    if (User::get_user_login_atmt($user_id) >= 3) {
                        $error = 'You account has been blocked.';
                        $error .= '<br/> Contact an <a class="alert-link" href="#">admin</a>.';

                        // Deactivate user's account.
                        User::change_status(0, $user_id);
                    }
                    // Check if the user has made a prev attempt.
                    else if (User::check_attempt($user_id)) {
                        $atmt = User::get_user_login_atmt($user_id) + 1;

                        // Update login attempt.
                        User::update_attempt($user_id, $atmt);
                    } else {
                        // Store login attempt.
                        User::store_login_atmt($user_id, $atmt);
                    }
                }
            } else {
                // Delete login attempt record if any.
                User::delete_attempt($user->get_user_id());

                // Log user in.
                header('Location: index.php');
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Bizmarrow Technologies</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Custome CSS -->
    <link rel="stylesheet" href="dist\css\style.css" />

</head>
<body>
    <main>
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-4" style="margin: 120px auto;">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete='off'>
                        <div class="text-center">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>

                        <?php if (!empty($email_err)) : ?>
                            <p class='alert alert-danger mt-3' id="error_block" style='display: block'><?= $email_err ?></p>

                        <?php elseif (!empty($password_err)) : ?>
                            <p class='alert alert-danger mt-3' id="error_block" style='display: block'><?= $password_err ?></p>

                        <?php elseif (!empty($error)) : ?>
                            <p class='alert alert-danger mt-3' id="error_block" style='display: block'><?= $error ?></p>

                        <?php elseif (!empty($_SESSION['message'])) : ?>
                            <p class='alert alert-success mt-3' id="success_block" style='display: block'><?= $_SESSION['message'] ?></p>

                            <?php
                            // Unset session message.
                            unset($_SESSION['message']);

                            ?>
                        <?php endif ?>

                        <p class='alert alert-danger mt-3' id='error_block' style="display: none;"></p>

                        <div class="form-group mt-3">
                            <div class="input-group">
                                <label class="sr-only" for="email">Email address</label>
                                <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Email Address" name="email" onkeyup="validate_email(email, error_block)" <?php if (!empty($email)) : ?> value="<?= $email ?>" <?php elseif (!empty($email_err)) : ?> autofocus <?php endif ?> />

                                <div class="input-group-append">
                                    <span class="input-group-text" for="inputGroupSelect02">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>

                        <div class="input-group mb-3">
                            <label class="sr-only" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" id="exampleInputEmail1" aria-describedby="emailHelp" <?php if (!empty($password_err) || !empty($error)) : ?> autofocus <?php endif ?> />

                            <div class="input-group-append" onclick="show_pass(password, eye_open, eye_slash)">
                                <span class="input-group-text" for="inputGroupSelect02">
                                    <i class="fa fa-eye" id="eye_open" aria-hidden="true"></i>
                                    <i class="fa fa-eye-slash" id="eye_slash" style="display: none;" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>

                        <div class="btn-container">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- row /-->
        </div>
        <!-- container /-->
    </main>
    <footer>
        <!-- jQuery -->
        <script src="plugins\jquery\jquery.min.js"></script>
        <!-- Custome JS -->
        <script src="dist\js\app.js"></script>
    </footer>
</body>
</html>