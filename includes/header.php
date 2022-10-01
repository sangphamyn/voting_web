<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title??'Voting web'; ?></title>
    <link rel="stylesheet" href="css/reset.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">    
    <!-- Style -->    
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="./output.css">


    <!-- GG font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Jost:wght@400;500;600;700;800&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/checkmail_ajax.js"></script>
</head>
<body>
    <?php define('BASE_URL', 'http://127.0.0.1:8080/voting_web/'); ?>
    <header class="header container-fluid">
        <div class="header-inner container">
            <a href="" class="logo">VOTE</a>
            <nav class="navigation">
                <ul class="nav-main">
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>create_poll.php">Create Poll</a>
                    </li><li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>poll.php">Poll</a>
                    </li>
                </ul>
            </nav>
            <div class="ms-auto user">
                <?php if(isset($_SESSION['first_name'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-lg dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['first_name']; ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item py-2" href="<?php echo BASE_URL; ?>edit_profile.php">User Profile</a></li>
                            <li><a class="dropdown-item py-2" href="<?php echo BASE_URL; ?>poll.php?aid=<?php echo $_SESSION['uid']; ?>">My Posts</a></li>
                            <li><a class="dropdown-item py-2" href="<?php echo BASE_URL;?>logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <a href="<?php echo BASE_URL; ?>login.php" class="btn-login">Login</a>
                    <a href="<?php echo BASE_URL; ?>register.php" class="btn-signup">Sign up</a>
                <?php } ?>
            </div>
        </div>
    </header>
