$(function(){
    $(document).on('click', '.task__block--status', function(e){
        e.preventDefault();
        console.log('clicked');
        var task_id = $(this).data('task');
        //task__delete is delTarget
        statusTarget = this;
        $.post('http://localhost/nextask/core/ajax/taskstatus.php', {statusTask:task_id}, function(data) {
            $(statusTarget).html("DONE");
            
        });
    });


    
});