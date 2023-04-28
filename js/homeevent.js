fetch_relatives_list();

$('textarea#eventTextPostBox').on('keyup', function() {
    $('#publish').show();
});

 $('#image').on('change',function(event){
          $("#publish").show();
});

var limit = 7;
var start = 0;
var limit2=7;
var action= 'inactive';
function fetch_relatives_list(limit,start) {
    $.ajax({
        url: "ajax/fetch_relatives_list.php",
        method: "POST",
        data:{limit:limit, start:start},
        cache:false,
        success: function(data) {
            $('#relativesList').html(data);
        }
    })
}

if(action == 'inactive')
{
  action = 'active';
  fetch_relatives_list(limit,start);

}

$(document).on('click', '.vote', function(){
                //var id= $(this).attr("id");
                var url='ajax/vote_action.php';
                var action = $(this).data('action');
                var session_id = $(this).data('session_id');
                var event_id = $(this).data('event_id');
                var candidate_id = $(this).data('candidate_id');
        
                    $.ajax({
                        type:'POST',
                        url:url,
                        data: {
                               session_id: session_id,
                               event_id: event_id,
                               candidate_id: candidate_id,
                               action:action
                              },
                        beforeSend: function(){
                            $("#current"+candidate_id).hide();
                            $("#button"+candidate_id).show();
                        },
                        success: function(){
                           fetch_candidates();
                        }
        
                    });
                });
        
                $(document).on('click', '.unvote', function(){
                //var id= $(this).attr("id");
                var url='ajax/vote_action.php';
                var action = $(this).data('action');
                var session_id = $(this).data('session_id');
                var event_id = $(this).data('event_id');
                var candidate_id = $(this).data('candidate_id');
        
                    $.ajax({
                        type:'POST',
                        url:url,
                        data: {
                               session_id: session_id,
                               event_id: event_id,
                               candidate_id: candidate_id,
                               action:action
                              },
                        beforeSend: function(){
                            $("#current"+candidate_id).show();
                            $("#button"+candidate_id).hide();
                        },
                        success: function(){
                           fetch_candidates();
                        }
        
                    });
                });
        

$(document).on('click', '.invite_friends', function() {
    var user_id = $(this).data('user_id');

    $.ajax({
        url: "ajax/invite_friend_to_follow_an_event.php",
        method: "POST",
        data: {user_id:user_id},
        success: function(data) {
            $('a#iButt' + user_id).hide();
            $('small#conf' + user_id).slideToggle('slow');
        }
    })
});

$(document).on('click', '.request_all', function(e) {
    e.preventDefault();
    $.ajax({
        url: "ajax/invite_all_friends_to_follow.php",
        method: "POST",
        beforeSend: function(){
            $('#loading_message').show();
            $('.request_all').hide();
        },
        success: function(data) {
            $('#loading_message').text('Sent!');
            $('#relativesList').slideToggle();
        }
    })

});

$(document).on('click', '.updateEventInfo', function() {
    var event_name = $('input#event_name').val();
    var event_description = $('textarea#description').val();
    
    if (event_name != '' && event_description != '') {
        $.ajax({
            url: "ajax/updateEventInfo.php",
            method: "POST",
            data: { event_name: event_name, event_description: event_description },
            success: function(data) {
                $('#eventDescriptionBox').val(event_description);
                $('#AboutConfMessage').slideToggle('slow');
            }
        })
    }
});
        var post_limit = 7;
        var post_start = 0;
        var post_limit2=7;
        var post_action= 'inactive';
        function load_data(post_limit,post_start){

          $.ajax({
            url:"event_posts.php",
            method:"POST",
            data:{post_limit:post_limit, post_start:post_start},
            cache:false,
            beforeSend: function(){
                    $("#spinner1").show();
                },
            success:function(data)
            {
              //alert("Success"+data);
              $('#posts_list').append(data);
              $("#spinner1").hide();
              if(data == '')
              {
               post_action = 'active';
              }
              else
              {
               post_action = 'inactive';
              }
            }
          })
        }
        if(post_action == 'inactive')
        {
          post_action = 'active';
          load_data(post_limit,post_start);

        }
        $(window).scroll(function(){
           if($(window).scrollTop() + $(window).height() > $("#posts_list").height() && post_action == 'inactive')
           {
            post_action = 'active';
            post_start = start + limit;
            post_limit2 = post_start+7;
            setTimeout(function(){
              load_data(post_limit,post_start);
            },1000);
           }
        });
