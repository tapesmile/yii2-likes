$(document).ready(function () {
    $('a.button-like').click(function () {
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };        
        $.post(likeUri, params, function(data) {
            if(data.success) {
                button.hide();
                button.siblings('.button-unlike').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
            });
        });
        return false;
    });
    
$(document).ready(function () {
    $('a.button-unlike').click(function () { 
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };        
        $.post(unlikeUri, params, function(data) {
            if(data.success) {
                button.hide();
                button.siblings('.button-like').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
            });
        });
        return false;
    });