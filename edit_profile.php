<?php 
    $title = "Profile";
    include('includes/header.php');
    require_once('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>
<div class="container py-5 edit_profile w-25">
    <?php 
        is_logged();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fn = $_POST['first_name'];
            $ln = $_POST['last_name'];
            $q = "UPDATE users SET first_name = '{$fn}', last_name = '{$ln}' WHERE user_id = {$_SESSION['uid']} LIMIT 1";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
            if(mysqli_affected_rows($dbc) == 1) {
                $_SESSION['first_name'] = $fn;
                $_SESSION['last_name'] = $ln;
                redirect_to('edit_profile.php');
            }
        }
        $user = fetch_user($_SESSION['uid']);
    ?>
    <form enctype="multipart/form-data" action="processor/avatar.php" method="POST">
        <fieldset>
            <div class="d-flex flex-column align-items-center">
                <img src="imgs/uploads/<?php echo (is_null($user['avatar'])) ? "no_avatar.png" : $user['avatar']; ?>" alt="avatar" class="avatar mb-3">
                <p class="my-2">Please select JPEG or PNG image to use as avatar</p>
                <input type="hidden" name="MAX_FILE_SIZE" value="524288">
                <input type="file" class="form-control my-3" name="image" id="avatar">
                <p><input type="submit" value="Save changes" name="upload" class="btn-register ms-0"></p>
            </div>
        </fieldset>
    </form>
    <form class="register-form mt-5" method="POST" action="">
        <div class="mb-4">
            <label for="first_name" class="label-form">First name</label>
            <input type="text" name="first_name" id="first_name" class="input-form" value="<?php if(isset($user['first_name'])) echo strip_tags($user['first_name']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="last_name" class="label-form">Last name</label>
            <input type="text" name="last_name" id="last_name" class="input-form" value="<?php if(isset($user['last_name'])) echo strip_tags($user['last_name']); ?>" required>
        </div>
        <input type="submit" name="submit" value="Save change" class="btn-register">
    </form>
</div>