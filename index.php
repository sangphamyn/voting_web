<?php
    include('includes/header.php');
?>

<div class="container py-5">
    <div class="banner bg-[#343434]">
        <div class="banner-content">
            <h2>Create your poll </br> in a seconds</h2>
            <p>Want to ask your friends where to go friday night or arrange a meeting with co-workers? Create a poll - and get answers in no time.</p>
            <div class="btn-group">
                <a href="<?php echo BASE_URL; ?>create_poll.php" class="btn-type-1">Create a idea</a>
                <a href="<?php echo BASE_URL; ?>poll.php" class="btn-type-1">View all idea</a>
            </div>
        </div>
    </div>
</div>
<?php 
    include('includes/footer.php');
?>