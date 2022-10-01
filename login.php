<?php 
    $title = 'Login';
    include('includes/header.php');
    include('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>

<h1 class="text-bold">Huy</h1>

<div class="container-fluid p-0 register-container">
    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();
            if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $e = mysqli_real_escape_string($dbc, $_POST['email']);
            else
                $errors[] = 'email';

            if(isset($_POST['password']) && preg_match('/^[\w\'\.-]{4,20}$/', $_POST['password']))
                $p = mysqli_real_escape_string($dbc, $_POST['password']);
            else
                $errors[] = 'password';
            if(empty($errors)) {
                $q = "SELECT user_id, first_name, user_level FROM users WHERE email = '{$e}' AND password = SHA1('{$p}') AND active IS NULL LIMIT 1";
                $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                if(mysqli_num_rows($r) == 1) {
                    session_regenerate_id();
                    list($uid, $first_name, $user_level) = mysqli_fetch_array($r, MYSQLI_NUM);
                    $_SESSION['uid'] = $uid;
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['user_level'] = $user_level;
                    redirect_to();
                } else
                    $message = "<p class='warning-form-label'>The email or password is incorrect. Or you have not activate your email.</p>";
            } else
                $message = "<p class='warning-form-label'>The email is invalid.</p>";
        }
    ?>
    <div class="register">
        <h2 class="register-title">Login to your account</h2>
        <p class="text-center mb-5">Or <a href="<?php echo BASE_URL; ?>register.php">create a new account</a></p>
        <form class="register-form" method="POST" action="">
            <div class="mb-4">
                <label for="email" class="label-form">Email</label>
                <input type="email" name="email" id="email" class="input-form" autocomplete="on" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="password" class="label-form">Password</label>
                <input type="text" name="password" id="password" class="input-form <?php if(isset($errors) && in_array('password', $errors)) echo "input-form-warning"; ?>" value="<?php if(isset($_POST['password'])) echo htmlentities($_POST['password']); ?>" required>
                <?php if(isset($errors) && in_array('password', $errors)) echo "<span class='warning-form-label'>The password must be at least 4 characters long.<span>"; ?>
            </div>
            <input type="submit" name="signup" value="Login" class="btn-register">
            <?php if(!empty($message)) echo $message; ?>
        </form>
    </div>
</div>
</div>