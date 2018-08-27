$(function(){
    $(document).on('click', '#postComment', function(e){
        e.preventDefault();
        var comment = $('.commentText').val();
        console.log(comment);
        var task_id = $('.commentText').data('task');
        //console.log(task_id);
        if(comment != "") {
            console.log(document.location.hostname);
            //$.post('http://localhost/nextask/core/ajax/comment.php', {comment:comment,task_id:task_id,/*list_id:list_id*/}, function(data) {
            $.post('http://' + document.location.hostname + '/nextask/core/ajax/comment.php', {comment:comment,task_id:task_id,/*list_id:list_id*/}, function(data) {
                $('.task__block--comments').html(data);
                $('.commentText').val("");
            });
        }
    }); 
});
