$(document).ready(function(){
    $(document).on('submit','form',function(){
        $('#empty').remove();
        if($.trim($('input[type=text]').val()) === ''){
            $('main').after('<p id="empty">Cant send with empty message</p>');
            $('#empty').css('color','red');
            $('#empty').css('text-align','center');
            return false;
        }else{
            var html_string = 
            '<section class="sender">'+
            '<p>' + $('input[type=text]').val() + '</p>'+
            '<figure>'+
            '<img src="/assets/img/user.png">'+
            '</figure>'+
            '</section>';
            $('#container').append(html_string);

            html_string = '<section class="receiver">'+
            '<img src="/assets/img/loading.gif" id="loading"/>'+
            '<figure>'+
            '<img src="/assets/img/simsimi.webp"/>'+
            '</figure>'+
            '</section>';
            $('#container').append(html_string);

            $.post('mains/talk', $(this).serialize(),function(res){
                $('#container').children().last().remove();
                html_string = '<section class="receiver">'+
                '<p>' + res.response + '</p>'+
                '<figure>'+
                '<img src="/assets/img/simsimi.webp"/>'+
                '</figure>'+
                '</section>';
                $('#container').append(html_string);
                $('#container').scrollTop($('#container')[0].scrollHeight);
                $('#send_message form input[type=text]').val('');
            });
            return false;
        }
    });
    $.post('mains/talk',{message: "Introduce Yourself"},function(res){
        console.log(res);
        html_string = '<section class="receiver">'+
            '<p>' + res.response + '</p>'+
            '<figure>'+
            '<img src="/assets/img/simsimi.webp"/>'+
            '</figure>'+
            '</section>';
            $('#container').append(html_string);
    });
    return false;
});