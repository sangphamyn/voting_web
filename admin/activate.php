<?php 
    $title = 'Activate Account';
    include('../includes/header.php');
    include('../includes/mysqli_connect.php');
    require_once('../includes/function.php');
?>
<div class="container py-5">
    <?php 
        if(isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && strlen($_GET['y']) == 32) {
            $e = mysqli_real_escape_string($dbc, $_GET['x']);
            $a = mysqli_real_escape_string($dbc, $_GET['y']);
            $q = "UPDATE users SET active = NULL WHERE email = '{$e}' AND active = '{$a}' LIMIT 1";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
            if(mysqli_affected_rows($dbc) == 1)
                echo "<p>Your account has been actived successfully. You may <a href='".BASE_URL."/login.php'>Login</a> now</p>";
            else
                echo "<p>Your account could not be active</p>";
        }
    ?>
</div>