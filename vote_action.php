<?php 
    include('includes/header.php');
    include('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>
<?php 
    if(isset($_SESSION['uid'], $_GET['pid'])) {
        $uid = $_SESSION['uid'];
        $pid = mysqli_real_escape_string($dbc, $_GET['pid']);

        $q = "SELECT user_id FROM votings WHERE user_id = {$uid} AND post_id = {$pid}";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        if(mysqli_num_rows($r) == 1) {
            $q = "DELETE FROM votings WHERE user_id = {$uid} AND post_id = {$pid}";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        } else {
            $q = "INSERT INTO votings (post_id,user_id) VALUES ({$pid}, {$uid})";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        }
    }
    redirect_to('poll.php');
?>