$(document).ready(function() {
        
        fetch_relatives_list();
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../../sounds/blop.mp3');

        var limit = 7;
        var start = 0;
        var limit2=7;
        var action = 'inactive';
        
        function load_data(limit,start){
          $.ajax({
            url:"/ajax/v2/fetch_forum_feeds.php",
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
              if(data == '')
              {
               $('#post_list_message').html("<h5>No available post...</h5>");
               action = 'active';
              }
              else
              {
               $('#post_list_message').html("<button class='btn btn-zung btn-block btn-sm more_post'>loading...</button>");
               action = 'inactive';
              }
            }
          })
        }
        
        if(action == 'inactive')
        {
          action = 'active';
          load_data(limit,start);
        }
        
        $(document).on('click', '.like', function(){
        
        var id = $(this).attr("id");
        var postid = $(this).data('postid');
        var url='/ajax/v2/forumpost_like.php';
        var action = $(this).data('action');

          $.ajax({
                type:'POST',
                url:url,
                data: {
                       id: id,
                       action: action,
                       postid: postid
                      },
                beforeSend: function(){
                  if(action == "like"){
                    $("#like"+postid).hide();
                    $("#unlike"+postid).fadeIn('fast');
                    audioElement.play();
                  }else{
                    $("#like"+postid).fadeIn('fast');
                    $("#unlike"+postid).hide();
                    audioElement.play();
                  }
                },
                success: function(data){
                   refresh_data(limit, start);
                }

            });
         });
         
         $("a.show").on("click", function(e){
            e.preventDefault();
            var url='/ajax/forum_members_selector.php';
            $.ajax({
                type:'POST',
                url:url,
                success: function(response){
                    $("#display_members").html(response);
                }
            });
        });

         $(document).on('click', '.validated', function(e){
             e.preventDefault();
             var url='/ajax/cancel_reaction.php';
             var id= $(this).attr("id");
             var reactionId = id.split("validated")[1];
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       reaction_id: reactionId,
                       action: action
                      },
                beforeSend: function(){
                   $("#validated"+reactionId).slideToggle();
                   $("#validate"+reactionId).slideToggle();
                },
                success: function(response){
                    $("#likers_"+ reactionId).html(response);
                    refresh_data(limit, start);
                }
            });
            
         });
         
         $(document).on('click', '.validate', function(e){
            e.preventDefault();
            var url='/ajax/validate_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("validate")[1];
            var action = $(this).data('action');
            
              $.ajax({
                type:'POST',
                url:url,
                data: {
                       reaction_id: reactionId,
                       action: action
                      },
                beforeSend: function(){
                   $("#validated"+reactionId).slideToggle();
                   $("#validate"+reactionId).slideToggle();
                   $("#denieded"+reactionId).hide();
                   $("#denied"+reactionId).show();
                },
                success: function(response){
                    $("#likers_"+ reactionId).html(response);
                    refresh_data(limit, start);
                }
            });
        });

        $(document).on('click', '.denied', function(e){
            
            e.preventDefault();
            var url='/ajax/denied_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("denied")[1];
              $.ajax({
                type:'POST',
                url:url,
                data: {
                       reaction_id: reactionId
                      },
                beforeSend: function(){
                   $("#denied"+reactionId).slideToggle();
                   $("#denieded"+reactionId).slideToggle(); 
                   $("#validated"+reactionId).hide();
                   $("#validate"+reactionId).show();
                },
                success: function(response){
                 $("#likers_"+ reactionId).html(response);
                 refresh_data(limit, start);
                }
            });
        });
        
        $(document).on('click', '.satisfied', function(e){
            e.preventDefault();

            var url='/ajax/satisfiedwith_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("satisfied")[1];

              $.ajax({
                type:'POST',
                url:url,
                data: {
                       reaction_id: reactionId
                      },
                beforeSend: function(){
                   $("#satisfied"+reactionId).slideToggle();
                   $("#satisfieded"+reactionId).slideToggle();  
                },
                success: function(response){
                    $("#likers_"+ reactionId).html(response);
                    refresh_data(limit, start);
                }
            });
        });
        
        $(document).on('keyup', '.comment_box', function(e){
            var postId = $(this).data('post_id');
            $('#cbtn'+postId).show();
        });
        
        $(document).on('click', '.post_comment', function(e){
            e.preventDefault();
            var id= $(this).attr("id");
            var reactionId = id.split("cbtn")[1];
            var content = $("#comment_box"+reactionId).val();
            var type = $(this).data('post_type');
            var url='/ajax/v2/comment_forum.php';
            var user_profile = "images/default.png";
            
            if (content.length > 0) {
             $.ajax({
                type:'POST',
                url:url,
                data: {
                       reactionId: reactionId,
                       content: content
                      },
                beforeSend: function(){
                   $("#display_reactions"+reactionId).append('<div class="flex"><div class="w-10 h-10 rounded-full relative flex-shrink-0"><img src="/'+user_profile+'" alt="" class="absolute h-full rounded-full w-full"></div><div><div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100"><p class="leading-6">'+content+'');  
                   $("#display_reactions"+reactionId).append('</p><div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div></div><div class="text-sm flex items-center space-x-3 mt-2 ml-5"></div></div></div>');
                   $("#comment_box"+reactionId).val('');
                },
                success: function(response){
                  $("#display_reactions"+reactionId).html(response);
                }

            });
           }
            
        });
         
        function refresh_data(limit, start)
        {
            setTimeout(function(){
            load_data(limit,start);
            }, 1500);
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
        
        function fetch_relatives_list() {
        $.ajax({
            url: "/ajax/v2/fetch_relatives_list.php",
            method: "POST",
            beforeSend: function(){
              $('#relatives_spinner').show();
            },
            success: function(data) {
                $('#relativesList').html(data);
            }
        })
        }
        
        $(document).on('keyup', '.search_friends', function(e){
            var query = $(this).val();
            
            if (query.length > 3) {
             $.ajax({
                type:'POST',
                url:'/ajax/v2/search_friends.php',
                data: {
                       query: query
                      },
                success: function(response){
                  $("#relativesList").html(response);
                }

            });
           } 
        });
        
    $(document).on('click', '.invite_friends', function(e) {
    e.preventDefault();    
    var user_id = $(this).data('user_id');
    $.ajax({
        url: "/ajax/invite_friend_in_a_forum.php",
        method: "POST",
        data: { user_id: user_id },
        beforeSend: function(data){
            $('a#iButt' + user_id).hide();
        },
        success: function(data) {
            $('small#conf' + user_id).slideToggle('slow');
        }
    })
    });
        
});
