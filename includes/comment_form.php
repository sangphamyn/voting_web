<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comment = mysqli_real_escape_string($dbc, strip_tags($_POST['comment']));
        $q = "INSERT INTO comments (post_id, user_id, content, date) VALUES ({$pid}, {$_SESSION['uid']}, '{$comment}', NOW())";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
    }
    $q = "SELECT c.cmt_id, c.content, c.date, CONCAT_WS(' ', first_name, last_name), u.avatar, u.user_id";
    $q .= " FROM comments AS c";
    $q .= " JOIN users AS u USING (user_id)";
    $q .= " WHERE c.post_id = {$pid} ORDER BY date ASC";
    $r = mysqli_query($dbc, $q); confirm_query($r, $q);
    if(mysqli_num_rows($r) > 0) {
        echo "<h3 style='font-weight: 600; margin-bottom: 40px; font-size: 18px'>Comment</h3>";
        echo "<ol id='disscuss'>";
        while(list($comment_id, $content, $date, $name, $avatar, $user_id) = mysqli_fetch_array($r, MYSQLI_NUM)) {
            echo "<div class='comment mb-5'>

                    <img src='imgs/uploads/";
            echo (is_null($avatar)) ? 'no_avatar.png' : $avatar; 
            echo "' alt='avatar' class='avatar'>
                    
                    <div class='ms-4 comment-main'>";
            if(isset($_SESSION['uid']) && $user_id == $_SESSION['uid']) echo "<div class='delete-comment' title='Delete comment' id='{$comment_id}'><svg xmlns='http://www.w3.org/2000/svg' style='width: 10px' viewBox='0 0 320 512'><path d='M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z'/></svg></div>";
            echo        "<p class='comment-author fw-bold mb-3'>{$name}</p>
                        <p class='comment-content mb-3'>{$content}</p>
                        <p class='date'>{$date}</p>
                    </div>
                </div>";
        }
        echo "</ol>";
    }
?>
<form method="post" action="" id="comment-form">
    <fieldset>
        <div class="mb-3">
            <label for="comment" class="label-form">Your comment</label>
            <textarea name="comment" cols="30" rows="3" id="comment" class="input-form" tabindex="3" required></textarea>
        </div>
    </fieldset>
    <div>
    <input type="submit" value="Post Comment" class="btn-register mt-0 ms-0"></div>
</form>