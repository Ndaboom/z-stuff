$(document).ready(function() {

        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../../sounds/blop.mp3');

        fetch_candidates();
        
        $(document).on('click', '.interested_btn', function(e){
        e.preventDefault();
        var event_id = $(this).data('event_id');
        var url='/ajax/v2/event_interest.php';

          $.ajax({
                type:'POST',
                url:url,
                data: {
                       event_id: event_id
                      },
                beforeSend: function(){
                 $('#interested_btn').hide();
                },
                success: function(data){
                 $('#cancel_btn').show();
                }
            });
         });
         
        $(document).on('click', '.unfollow_btn', function(e){
        e.preventDefault();
        var event_id = $(this).data('event_id');
        var url='/ajax/v2/event_nointerest.php';

          $.ajax({
                type:'POST',
                url:url,
                data: {
                       event_id: event_id
                      },
                beforeSend: function(){
                 $('#interest_btn').show();
                },
                success: function(data){
                 $('#cancel_btn').hide();
                }
            });
         });
         
        $(document).on('click', '.invite_follow', function(e){
        e.preventDefault();
        var user_id = $(this).data('user_id');
        var url='/ajax/invite_friend_to_follow_an_event.php';

          $.ajax({
                type:'POST',
                url:url,
                data: {
                       user_id: user_id
                      },
                beforeSend: function(){
                 $('#invite_btn'+user_id).slideToggle();
                },
                success: function(data){
                 
                }
            });
         });
         
         $(document).on('click', '.copy_link', function(e){
            e.preventDefault();
            var current_link =  window.location.href;
            
            navigator.clipboard.writeText(current_link).then(function() {
                alert("Copied "+current_link);
            }, function(err) {
                alert("Async: Could not copy text: "+err);
            });
       
         });
         
        $(document).on('click', '.go_now', function(e){
        e.preventDefault();
        
        var event_id = $(this).data('event_id');
        var start_date = $(this).data('start_date');
        var action = 'go';
        var url='/ajax/v2/iam_going.php';

          $.ajax({
                type:'POST',
                url:url,
                data: {
                       event_id: event_id,
                       start_date: start_date,
                       action: action
                      },
                beforeSend: function(){
                 $('#going_btn').slideToggle();
                },
                success: function(data){
                 $('#iamgoing_btn').slideToggle();
                }
            });
        
        });
        
        $(document).on('click', '.nomore_going', function(e){
        e.preventDefault();
        
        var event_id = $(this).data('event_id');
        var start_date = $(this).data('start_date');
        var action = 'nomore_going';
        var url='/ajax/v2/iam_going.php';

          $.ajax({
                type:'POST',
                url:url,
                data: {
                       event_id: event_id,
                       start_date: start_date,
                       action: action
                      },
                beforeSend: function(){
                 $('#going_btn').slideToggle();
                },
                success: function(data){
                 $('#iamgoing_btn').slideToggle();
                }
            });
        
        });
        
        var limit = 7;
        var start = 0;
        var limit2=7;
        var action = 'inactive';
        function load_data(limit,start){
          $.ajax({
            url:"/ajax/v2/fetch_event_timeline.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            beforeSend: function(){
                    $("#spinner1").show();
                },
            success:function(data)
            {
              $('#post_list').append(data);
              $("#spinner1").hide();
            }
          })
        }
        
        if(action == 'inactive')
        {
          action = 'active';
          load_data(limit,start);

        }
        
        $(window).scroll(function(){
           if($(window).scrollTop() + $(window).height() > $("#post_list").height() && action == 'inactive')
           {
            action = 'active';
            start = start + limit;
            limit2 = start+7;
            setTimeout(function(){
              load_data(limit,start);
            },1000);
           }
        });
        
        $(document).on('click', '.like', function(){

        var id= $(this).attr("id");
        var url='/ajax/v2/event_like.php';
        var action = $(this).data('action');
        var poster = $(this).data('poster');
        var postid = $(this).data('postid');
        var eventId = $(this).data('event_id');
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       event_id: eventId,
                       action: action,
                       poster:poster,
                       postid:postid
                      },
                 beforeSend: function(){
                  if(action == "like"){
                    $("#like"+postid).hide();
                    $("#unlike"+postid).fadeIn('fast');
                    audioElement.play();
                  }else{
                    $("#like"+postid).fadeIn('fast');
                    $("#unlike"+postid).hide();
                  }
                },
                success: function(likers){
                   reload_data(limit2,from);
                }

            });
        });
        
        var from=0;
        function reload_data(limit2,from){
         $.ajax({
            url:"/ajax/v2/refetch_event_timeline.php",
            method:"POST",
            data:{limit2:limit2, from:from},
            success:function(data)
            {
              $('#post_list').html(data);
            }
          })
        }

        function fetch_candidates()
        {
          $.ajax({
            url:"ajax/fetch_candidates_v2.php",
            method:"POST",
            success:function(data){
              $('#candidates_list').html(data);
            }
          })
        }

        $(document).on('click', '.vote', function(e){
          e.preventDefault();
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
  
          $(document).on('click', '.unvote', function(e){
          e.preventDefault();
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
        
});
