$(document).ready(function() {
    $('#email').change(function() {
        var email = $(this).val();
        if(isEmail(email)) {
            $('#available').html("");
            $.ajax({
                type: "get",
                url: "check.php",
                data: "email=" + email,
                success: function(response) {
                    if(response == "YES")
                        $('#available').html("<span class='success-form-label'>Available<span>");
                    else
                        $('#available').html("<span class='warning-form-label'>NOT Available<span>");
                }
            })
        } else if(email.trim() != '')
            $('#available').html("<span class='warning-form-label'>NOT valid<span>");
        else 
            $('#available').html("");
    })
    $('#email').keydown(function() {
        $('#available').html("");
    })
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    
    $('.delete-comment').click(function() {
        var container = $(this).parent().parent();
        var cid = $(this).attr('id');
        var string = 'cmt_id=' + cid;

        $.ajax({
            type: "POST",
            url: "includes/delete_comment.php",
            data: string,
            success: function() {
                container.slideUp('normal', function() {container.remove();});
            }
        })
    })

    $('.delete-post').click(function() {
        var container = $(this).parent();
        var pid = $(this).attr('id');
        var string = 'pid=' + pid;

        $.ajax({
            type: "POST",
            url: "includes/delete_post.php",
            data: string,
            success: function() {
                container.slideUp('normal', function() {container.remove();});
            }
        })
    })
})