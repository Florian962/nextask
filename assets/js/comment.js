$(function(){
    $(document).on('click', '#postComment', function(){
        var comment = $('.commentText').val();
        //console.log(comment);
        var task_id = $('.commentText').data('task');
        //console.log(task_id);
        if(comment != "") {
            //console.log('niet leeg');
            $.post('http://localhost/nextask/core/ajax/comment.php', {comment:comment,task_id:task_id}, function(data) {
                $('.task__block--comments').html(data);
                $('.commentText').val("");
            });
        }
    }); 
});
