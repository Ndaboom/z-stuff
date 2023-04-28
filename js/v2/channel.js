$(document).ready(function() {

    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', '../../sounds/blop.mp3');

    $(document).on('click', '.like-btn', function(e){
        e.preventDefault();
        var action = $(this).data('action');
        var channel_id = $(this).data('channel_id');
        
        $.ajax({
            url:"/ajax/v2/like_tv_channel.php",
            method:"POST",
            data:{action:action,channel_id:channel_id},
            cache:false,
            success:function(data)
            {
                console.log('data returned',data);
                fetch_channel_likes(channel_id);
            }
          })
    });

    function fetch_channel_likes(channel_id)
    {
    $.ajax({
        url:"/ajax/v2/fetch_channel_likes.php",
        method:"POST",
        data:{channel_id:channel_id},
        cache:false,
        success:function(data)
        {
            $('#likes_box').html(data);
        }
    })
    }

});
    