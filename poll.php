<?php 
    $title = "Poll";
    include('includes/header.php');
    require_once('includes/mysqli_connect.php');
    require_once('includes/function.php');
?>
<div class="container-fluid px-0 poll py-5">
    <?php 
        if(isset($_SESSION['uid']))
            $user_id = $_SESSION['uid'];
        else 
            $user_id = 0;
        if(isset($_GET['o']) && $_GET['o'] == 'n')
            $order_by = 'date';
        else 
            $order_by = 'num_vote';
        if(isset($_GET['aid']) && filter_var($_GET['aid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $user = fetch_user($_GET['aid']);
        }
        $q = "SELECT p.post_id, p.title, p.description, p.date, p.user_id, CONCAT_WS(' ', first_name, last_name) AS name";
        $q .= ", (SELECT COUNT(*) FROM comments WHERE comments.post_id = p.post_id) AS num_comment";
        $q .= ", (SELECT COUNT(*) FROM votings WHERE votings.post_id = p.post_id) AS num_vote";
        $q .= ", (SELECT COUNT(*) FROM votings WHERE votings.post_id = p.post_id AND votings.user_id = {$user_id}) AS this_user_vote";
        $q .= ", (SELECT COUNT(*) FROM posts WHERE posts.user_id = ";
        $q .= $_GET['aid']??'0';
        $q .= ") AS num_post ";
        $q .= ", (SELECT COUNT(*) FROM posts) AS num_all_post ";
        $q .= " FROM posts AS p";
        $q .= " JOIN users AS u";
        $q .= " USING (user_id)";
        if(!empty($user['user_id']))
            $q .= " WHERE user_id = {$_GET['aid']}";
        $q .= " ORDER BY ".$order_by." DESC";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        $r1 = mysqli_query($dbc, $q); confirm_query($r1, $q);
        $results = mysqli_fetch_array($r1, MYSQLI_ASSOC);
    ?>
    <?php if(isset($user['first_name'])) echo "<a href='poll.php' class='d-flex align-items-center mb-5' style='color: #222;font-weight: 600; width: 800px; margin:auto;'><svg xmlns='http://www.w3.org/2000/svg' style='width: 10px; margin-right: 5px' viewBox='0 0 384 512'><path d='M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z'/></svg>All Idea</a>"; ?>
    <h2 class='poll-title'><?php if($results) {$num_post = $results['num_post']; $num_all_post = $results['num_all_post'];} else {$num_post = 0; $num_all_post = 0;} if(isset($user['first_name'])) echo $user['first_name'] . " Ideas (" .$num_post. ")"; else echo "All Ideas (" . $num_all_post .")";  ?></h2>
    <div class="dropdown">
        <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if(isset($_GET['o']) && $_GET['o'] == 'h') echo "Hot"; else if(isset($_GET['o']) && $_GET['o'] == 'n') echo "New"; else echo "Filter"; ?>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item py-2" href="?o=h<?php if(!empty($user['user_id'])) echo "&aid={$user['user_id']}"; ?>">Hot</a></li>
            <li><a class="dropdown-item py-2" href="?o=n<?php if(!empty($user['user_id'])) echo "&aid={$user['user_id']}"; ?>">New</a></li>
        </ul>
    </div>
    <div class="post-list">
        <?php 
            while($posts = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                if($posts['this_user_vote'] == 1)
                    $voted = "voted";
                else 
                    $voted = "";
                echo "
                    <div class='post'>";
                    if(isset($_SESSION['uid']) && $posts['user_id'] == $_SESSION['uid']) echo "<div class='delete-post' title='Delete post' id='{$posts['post_id']}'><svg xmlns='http://www.w3.org/2000/svg' style='width: 10px' viewBox='0 0 320 512'><path d='M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z'/></svg></div>";
                echo    "<div class='post-vote'>
                            <span class='vote-num'>{$posts['num_vote']}</span>
                            <span class='vote-label'>Votes</span>
                            <a href='". BASE_URL ."vote_action.php?pid={$posts['post_id']}' class='vote-action ". $voted ."'>VOTE</a>
                        </div>
                        <div class='post-main'>
                            <div class='post-title'><a href='".BASE_URL."single.php?pid={$posts['post_id']}'>{$posts['title']}</a></div>
                            <div class='post-description'>". the_excerpt($posts['description']) ."</div>
                            <div class='post-info'>
                                <a href='?aid={$posts['user_id']}' class='post-author'>{$posts['name']}</a>
                                <div class='post-date'>{$posts['date']}</div>
                                <a href='". BASE_URL ."single.php?pid={$posts['post_id']}#disscuss' class='post-num-comment'>💬 {$posts['num_comment']} Comments</a>
                            </div>
                        </div>
                    </div>
                ";
            }
        ?>
    </div>
</div>