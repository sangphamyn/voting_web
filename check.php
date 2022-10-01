<?php 
    include('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>
<?php 
    if(isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        $e = mysqli_real_escape_string($dbc, $_GET['email']);
        $q = "SELECT user_id FROM users WHERE email = '{$e}'";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        if(mysqli_num_rows($r) == 1) 
            echo "NO";
        else 
            echo "YES";
    }
?>