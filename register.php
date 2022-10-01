<?php 
    $title = 'Register';
    include('includes/header.php');
    require_once('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>
<div class="container-fluid p-0 register-container">
    <?php 
        require 'vendor/autoload.php';
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();
            $fn = $ln = $e = $p = FALSE;
            
            if(preg_match('/^[\w\'.-]{2,20}$/i', trim($_POST['first_name']))) 
                $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
            else
                $errors[] = "first name";
            
            if(preg_match('/^[\w\'.-]{2,20}$/i', trim($_POST['last_name'])))
                $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
            else
                $errors[] = 'last name';
            
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $e = mysqli_real_escape_string($dbc, $_POST['email']);
            else
                $errors[] = 'email';
            
            if(preg_match('/^[\w\'.-]{4,20}$/', trim($_POST['password']))) {
                if($_POST['password'] == $_POST['password1'])
                    $p = mysqli_real_escape_string($dbc, $_POST['password']);
                else
                    $errors[] = "password not match";
            } else
                $errors[] = "password";

            if($fn && $ln && $e && $p) {
                $q = "SELECT user_id FROM users WHERE email = '{$e}'";
                $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                if(mysqli_num_rows($r) == 0) {
                    $a = md5(uniqid(rand(), true));
                    $q = "INSERT INTO users (first_name, last_name, email, password, active, register_date) 
                          VALUE ('{$fn}', '{$ln}', '{$e}', SHA1('{$p}'), '{$a}', NOW())";
                    $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                    if(mysqli_affected_rows($dbc) == 1) {
                        $body = "Thank for your registration. Please click on link to active your account\n";
                        $body .= BASE_URL . "admin/activate.php?x=" . urlencode($e) . "&y={$a}";
                        $mail = new PHPMailer(true);

                        try {
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'sangphamyn313@gmail.com';
                            $mail->Password   = 'tuqwgdalopfmgcsc';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;  
                        } catch(Exception $e) {
                            $message = "<p>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>";
                        }

                        $mail->setFrom('sangphamyn313@gmail.com', 'Voting web');
                        $mail->addAddress($e, $fn . $ln);

                        $mail->isHTML(true);
                        $mail->Subject = 'Active voting web account';
                        $mail->Body = $body;

                        $mail->send();
                        redirect_to();
                    } else 
                        $message = "<p class='warning-form-label'>System error</p>";
                } else 
                    $message = "<p class='warning-form-label'>The email already used previously</p>";
            }
        }
    ?>
    <div class="register">
        <h2 class="register-title">Create a new account</h2>
        <p class="text-center mb-5">Or <a href="<?php echo BASE_URL; ?>login.php">log in to your account</a></p>
        <form class="register-form" method="POST" action="">
            <div class="mb-4">
                <label for="first_name" class="label-form">First name</label>
                <input type="text" name="first_name" id="first_name" class="input-form" value="<?php if(isset($_POST['first_name'])) echo htmlentities($_POST['first_name']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="last_name" class="label-form">Last name</label>
                <input type="text" name="last_name" id="last_name" class="input-form" value="<?php if(isset($_POST['last_name'])) echo htmlentities($_POST['last_name']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="email" class="label-form">Email</label>
                <input type="email" name="email" id="email" class="input-form" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" required>
                <span id="available"></span>
            </div>
            <div class="mb-4">
                <label for="password" class="label-form">Password</label>
                <input type="text" name="password" id="password" class="input-form <?php if(isset($errors) && in_array('password', $errors)) echo "input-form-warning"; ?>" value="<?php if(isset($_POST['password'])) echo htmlentities($_POST['password']); ?>" required>
                <?php if(isset($errors) && in_array('password', $errors)) echo "<span class='warning-form-label'>The password must be at least 4 characters long.<span>"; ?>
            </div>
            <div class="mb-4">
                <label for="password1" class="label-form">Confirm password</label>
                <input type="text" name="password1" id="password1" class="input-form <?php if(isset($errors) && in_array('password', $errors)) echo "input-form-warning"; ?>" required>
                <?php if(isset($errors) && in_array('password not match', $errors)) echo "<span class='warning-form-label'>Your confirm password is not match.<span>"; ?>
            </div>
            <input type="submit" name="signup" value="Sign up" class="btn-register">
            <?php if(!empty($message)) echo $message; ?>
        </form>
    </div>
</div>