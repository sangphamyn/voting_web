<?php 
    $title = 'Single';
    include('includes/header.php');
    require_once('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>
<div class="container py-5" style="width: 800px;">
    <?php
        if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $pid = $_GET['pid'];
            $q = "SELECT p.title, p.description, CONCAT_WS(' ', u.first_name, u.last_name) AS name, p.date, u.user_id, u.avatar 
                  FROM posts AS p 
                  INNER JOIN users AS u 
                  USING (user_id) 
                  WHERE p.post_id = {$pid} LIMIT 1";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
            if(mysqli_num_rows($r) > 0) {
                $results = mysqli_fetch_array($r, MYSQLI_ASSOC);
                $posts[] = array('title' => $results['title'], 'description' => $results['description'], 'name' => $results['name'], 'date' => $results['date'], 'aid' => $results['user_id'], 'avatar' => $results['avatar']);
                foreach($posts as $post) {
                    echo "
                        <a href='poll.php' class='d-flex align-items-center mb-5' style='color: #222;font-weight: 600'><svg xmlns='http://www.w3.org/2000/svg' style='width: 10px; margin-right: 5px' viewBox='0 0 384 512'><path d='M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z'/></svg>All Idea</a>
                        <div class='single-post'>
                            <h2 class='single-post-title'>{$post['title']}</h2>
                            <p class='single-post-des'>". the_content($post['description']) ."</p>
                            <div class='meta my-5'><img src='imgs/uploads/"; 
                    echo (is_null($post['avatar'])) ? 'no_avatar.png' : $post['avatar'];
                    echo "' alt='avatar' class='avatar'><div class='d-flex flex-column ms-3'><span class='mb-2 fw-bold'>{$post['name']}</span> <span>On {$post['date']}</span></div></div>
                        </div>
                    ";
                }
                include('includes/comment_form.php');
            } else {
                echo "<p>There are currently no Poll</p>";
            }
        }
    ?>
</div>