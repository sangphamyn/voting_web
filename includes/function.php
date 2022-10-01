<?php 
    function confirm_query($result, $query) {
        global $dbc;
        if (!$result && !LIVE) {
            die("Query {$query} \n<br/> MySQL Error: " .mysqli_error($dbc));
        }
    }
    function redirect_to($page = 'index.php') {
        $url = BASE_URL . $page;
        header('Location: ' . $url);
        exit();
    }
    function the_excerpt($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'utf-8');
        if(strlen($sanitized) > 300) {
            $cutString = substr($sanitized, 0, 250);
            $word = substr($cutString, 0, strrpos($sanitized, ' '));
            return $word . "...";
        }
        return $sanitized;
    }
    function the_content($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'utf-8');
        return str_replace(array("\r\n", "\n"), array("<p>", "</p>"), $text);
    }
    function fetch_user($user_id) {
        global $dbc;
        $q = "SELECT * FROM users WHERE user_id = {$user_id}";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        if(mysqli_num_rows($r) > 0) {
            return $result_set = mysqli_fetch_array($r, MYSQLI_ASSOC);
        } else {
            return FALSE;
        }
    }
    function is_logged() {
        if(!isset($_SESSION['uid']) ) {
            redirect_to('login.php');
        }
    }
    function is_admin() {
        return (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == 2));
    }
    function admin_access() {
        if(!is_admin()) {
            redirect_to();
        }
    }
?>