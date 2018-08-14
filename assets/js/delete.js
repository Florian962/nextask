$(function(){
    $(document).on('click', '.list__delete', function(){
        console.log('clicked');
        var list_id = $(this).data('list');
        //list__delete is delTarget
        delTarget = this;
        $.post('http://localhost/nextask/core/ajax/listdelete.php', {deleteList:list_id}, function(data) {
            $(delTarget).parent().slideUp();
            
        });
    });

});