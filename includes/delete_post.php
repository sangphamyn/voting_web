<?php include('mysqli_connect.php');
    include('function.php');
?>
<?php 
    if(isset($_POST['pid']) && filter_var($_POST['pid'], FILTER_VALIDATE_INT)) {
        $pid = $_POST['pid'];

        $q = "DELETE FROM comments WHERE post_id = {$pid} LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        
        $q = "DELETE FROM posts WHERE post_id = {$pid} LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
    }
?>