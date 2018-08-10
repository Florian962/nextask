$(function(){
    $(document).on('click', '.list__delete', function(){
        var list_id = $(this).data('list');
        $.post('http://localhost/nextask/core/ajax/listdelete.php', {showPopup:list_id}, function(data) {
            $('popupList').html(data);
            
        });
    });

});