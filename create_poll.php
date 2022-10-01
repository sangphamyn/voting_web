<?php 
    $title = "Create Poll";
    include('includes/header.php');
    require_once('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>
<div class="container-fluid p-0 register-container">
    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_SESSION['uid']) ) {
                $title = mysqli_real_escape_string($dbc, $_POST['title']);
                $description = mysqli_real_escape_string($dbc, $_POST['description']);
                $q = "INSERT INTO posts (user_id, title, description, date) VALUES ({$_SESSION['uid']}, '{$title}', '{$description}', NOW())";
                $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                redirect_to("poll.php");
            } else
                $message = "<p class='warning-form-label'>You must <a href='".BASE_URL."login.php'>log in </a> to create poll</p>";
        }
    ?>
    <div class="register register-lg">
        <h2 class="register-title">Create a poll</h2>
        <p class="text-center mb-5 mt-4">Complete the below fields to create your poll.</p>
        <form class="register-form" method="POST" action="">
            <div class="mb-4">
                <label for="title" class="label-form">Title</label>
                <input type="text" name="title" id="title" class="input-form" required>
            </div>
            <div class="mb-4">
                <label for="description" class="label-form">Description</label>
                <textarea name="description" id="description" class="input-form" cols="30" rows="6"></textarea>
            </div>
            <input type="submit" name="submit" value="Create poll" class="btn-register">
            <?php if(!empty($message)) echo $message; ?>
        </form>
    </div>
</div>