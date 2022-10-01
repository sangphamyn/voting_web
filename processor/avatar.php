<?php 
    include('../includes/mysqli_connect.php');
    include('../includes/header.php');
    require_once('../includes/function.php');
?>
<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_FILES['image'])) {
            $errors = array();
            $allowed = array('image/jpg', 'image/jpeg', 'image/png');
            if(in_array(strtolower($_FILES['image']['type']), $allowed)) {
                $a = explode('.', $_FILES['image']['name']);
                $ext = end($a);
                $renamed = uniqid(rand(), true).'.'.$ext;
                if(!move_uploaded_file($_FILES['image']['tmp_name'],dirname(dirname(__FILE__)). "/imgs/uploads/" . $renamed)) {
                    $errors[] = "<p class='warning'>Server problem<p>";
                }
            } else {
                $errors[] = "<p class='warning'>Your file type is not valid</p>";
            }
        }
        if($_FILES['image']['error'] > 0) {
            $errors[] = "<p class='warning'>Could not be uploaded because: </p>";
            switch($_FILES['upload']['error']) {
                case 1:
                    $errors[] = "The file exceeds the upload_max_filesize in php.ini";
                    break;
                case 2:
                    $errors[] = "The file exceeds the MAX_FILE_SIZE in HTML form";
                    break;
                case 3:
                    $errors[] = "The file was partially uploaded";
                    break;
                case 4:
                    $errors[] = "No file was uploaded";
                    break;
                case 6:
                    $errors[] = "No temporary folder was available";
                    break;
                case 7:
                    $errors[] = "Unable to write to the disk";
                    break;
                case 8:
                    $error[] = "File upload stopped";
                    break;
                default:
                    $errors[] = "A system error occured";
            }
        }
        if(isset($_FILE['image']['tmp_name']) && is_file($_FILE['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
            unlink($_FILE['image']['tmp_name']);
        }
    }

    if(empty($errors)) {
        $q = "UPDATE users SET avatar = '{$renamed}' WHERE user_id = {$_SESSION['uid']} LIMIT 1";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        if(mysqli_affected_rows($dbc) > 0) {
            redirect_to('edit_profile.php');
        }
    }
    report_error($errors);

    if(!empty($message)) echo $message;
?>