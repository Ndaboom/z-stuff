

$(document).on('click', '.invite_friends', function() {
    var user_id = $(this).data('user_id');

    $.ajax({
        url: "ajax/invite_friend_in_a_forum.php",
        method: "POST",
        data: { user_id: user_id },
        success: function(data) {
            $('a#iButt' + user_id).hide();
            $('small#conf' + user_id).slideToggle('slow');
        }
    })
});
