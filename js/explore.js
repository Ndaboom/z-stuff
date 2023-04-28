$(document).ready(function() {
        var limit = 7;
        var start = 0;
        var limit2=7;
        var from = 0;
        var action= 'inactive';

        const urlParams = new URLSearchParams(window.location.search);
        const tags = urlParams.get('tag');
        //alert(tags);

        function load_data(limit,start){
        //  alert("le tag est"+ tags);
          $.ajax({
            url:"fetch_hashtag_based.php",
            method:"POST",
            data:{limit:limit, start:start,tags:tags},
            cache:false,
            beforeSend: function(){
                    $('#post_list_message').html("<button class='btn btn-zung btn-block btn-sm more_post'>loading...</button>");
                    $("#spinner1").show();
                },
            success:function(data)
            {

              $('#post_list').html(data);
              $("#spinner1").hide();
              if(data == '')
              {
               $('#post_list_message').html("<h5>No available post...</h5>");
               action = 'active';
              }
              else
              {
               action = 'inactive';
               $('#post_list_message').html("");
              }
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
            limit2 = start+7;
            setTimeout(function(){
              load_data(limit,start);
            },1000);
           }
        });


        $(document).on('click', '.like', function(){

        var id= $(this).attr("id");
        var url='ajax/micropost_like.php';
        var action = $(this).data('action');
        var poster = $(this).data('poster');
        var postid = $(this).data('postid');
        var micropostId = id.split("like")[1];
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       micropost_id: micropostId,
                       action: action,
                       poster:poster,
                       postid:postid
                      },
                 beforeSend: function(){
                  if(action == "like"){
                    $("#like"+micropostId).hide();
                    $("#unlike"+micropostId).fadeIn('fast');

                  }else{
                    $("#like"+micropostId).fadeIn('fast');
                    $("#unlike"+micropostId).hide();
                  }
                },
                success: function(likers){
                   load_data(limit2,from);
                }

            });
        });

        function update_last_activity()
        {
          $.ajax({
            url:"ajax/update_last_activity.php",
            success:function()
            {

            }
          })
        }

         function fetch_incomming_msg()
        {
          $.ajax({
            url:"ajax/fetch_incomming_msg.php",
            method:"POST",
            success:function(data)
            {
              $('#message').html(data);
            }
          })
        }

        $(document).on('click', '.action_button', function(){
           var destinator_id = $(this).data('destinator_id');
           var action = $(this).data('action');
           $.ajax({
            url:'action.php',
            method:"POST",
            data:{destinator_id:destinator_id, action:action},
            success:function(data)
            {
             $("#friend"+destinator_id).hide();
            }
           })
        });

        var post_id;
        var user_id;
        $(document).on('click','.post_comment', function(){
              post_id = $(this).attr('id');
              user_id = $(this).data('user_id');
              var action = 'fetch_comment';
              $.ajax({
                url:"action.php",
                method:"POST",
                data:{post_id:post_id,user_id:user_id,action:action},
                success:function(data){
                  $('#old_comment'+post_id).html(data);
                  $('#comment_form'+post_id).slideToggle('slow');
                  $('#display_last_comment'+post_id).hide();
                }
              })


        });

        $(document).on('click','.submit_comment',function(){
         var comment = $('#comment'+post_id).val();
         var action = 'submit_comment';
         var receiver_id = user_id;
         var poster = $(this).data('poster');

         if(comment != '')
         {
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{post_id:post_id,receiver_id:receiver_id,comment:comment,action:action,poster:poster},
           success:function(data)
           {
            $('#comment_form'+post_id).slideUp('slow');
            load_data(limit2,from);
           }
          })
         }
        });

        $(document).on('click','.like_comment',function(){
          var poster_id = $(this).data('poster_id');
          var comment= $(this).data('comment');
          var post= $(this).data('post');
          var commentid= $(this).data('commentid');
          var action= 'like_comment';
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
             load_data(limit2,from);
            }
          })

        });

        $(document).on('click','.unlike_comment',function(){
          var poster_id = $(this).data('poster_id');
          var comment= $(this).data('comment');
          var post= $(this).data('post');
          var commentid= $(this).data('commentid');
          var action= 'unlike_comment';
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
             load_data(limit2,from);
            }
          })

        });

        $('.wish').click(function() {
         var card_id = $(this).data('card_id');
         $('#reply'+card_id).slideToggle('slow');
        });

        $('textarea#content').on('keyup',function(){
          $("#publish").show();
        });

        var url ='ajax/search.php';
        $('input#searchbox').on('keyup', function(){
            var query = $(this).val();
        if (query.length > 2) {
          $.ajax({
                type:'POST',
                url:url,
                data: {
                       query: query
                      },
                beforeSend: function(){
                    $("#spinner").show();
                },
                success: function(data){
                   $("#spinner").hide();
                   $("#display-results ").html(data).show();

                }

            });
        }else{
            $("#display-results ").hide();
        }
    });

    $(document).on('click', '.share_publication', function(e){
            e.preventDefault();
            var poster  = $(this).data('poster');
            var postid =  $(this).data('postid');
            var legend =  $(this).data('legend');
            var media  =  $(this).data('media');
            var sub_type = $(this).data('post_type');
            var quote_author = $(this).data('quote_author');

               $.ajax({
                url: "ajax/share.php",
                method:"POST",
                data:{poster:poster, postid:postid, legend:legend, media:media, sub_type:sub_type, quote_author:quote_author},
               beforeSend: function(){
                        $('#sharing_button'+postid).hide();
                        $('#share_pending'+postid).show();
                    },
                 success:function(){
                   $('#share_pending'+postid).hide();
                   $('#share_confirmation'+postid).show();
                 }
            });
           });



});
