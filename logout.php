<?php 
    include('includes/header.php');
    include('includes/mysqli_connect.php');
    include('includes/function.php');
?>
<div class="container py-5">
    <?php 
        if(!isset($_SESSION['uid'])) {
            redirect_to();
        } else {
            $_SESSION = array();
            session_destroy();
            setcookie(session_name(), '', time() - 36000);
            echo "<h2>You are now logged out</h2>";
            redirect_to();
        }
    ?>
</div>
<?php 
    include('includes/sidebar-b.php');
    include('includes/footer.php');
?>