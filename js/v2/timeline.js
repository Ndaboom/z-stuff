$(document).ready(function() {

        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../../sounds/blop.mp3');
        
        setInterval(function(){
          fetch_right_pane_online_user();
        },20000);// 20 seconds

        
        setTimeout(() => {
          fetch_right_pane_online_user();
        }, 5000)
        
         function fetch_online_user()
        {
          $.ajax({
            url:"/ajax/v2/fetch_online_user.php",
            method:"POST",
            success:function(data){
              $('#user_details').html(data);
            }
          })
        }

        function fetch_right_pane_online_user()
        {
          $.ajax({
            url:"/ajax/v2/fetch_right_pane_online_user.php",
            method:"POST",
            success:function(data){
              $('#right_pane_users').html(data);
            }
          })
        }
        
       $(document).on('click', '.share_publication', function(e){
        e.preventDefault();
        var poster  = $(this).data('poster');
        var postid =  $(this).data('postid');
        var legend =  $(this).data('legend');
        var media  =  $(this).data('media');
        var sub_type = $(this).data('post_type');
        var quote_author = $(this).data('quote_author');

           $.ajax({
            url: "/ajax/share.php",
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
       
        $(document).on('keyup', '.comment_box', function(e){
        var postId = $(this).data('post_id');
        $('#cbtn'+postId).show();  
        });
        
        $(document).on('click', '.post_comment', function(e){
            e.preventDefault();

            var id= $(this).attr("id");
            var postId = id.split("cbtn")[1];
            var content = $("#comment_box"+postId).val();
            var url='/ajax/v2/post_comment.php';
            var user_profile = "images/default.png";
            var poster = $(this).data('poster');
            
            if (content.length > 0) {
             $.ajax({
                type:'POST',
                url:url,
                data: {
                       postId: postId,
                       content: content,
                       poster: poster
                      },
                beforeSend: function(){
                   $("#comment_box"+postId).val('');
                },
                success: function(response){
                  refresh_data(limit2,from);
                }
            });
           }
        });
        
        $(document).on('click', '.like_comment', function(e){
          e.preventDefault();
           
          var poster_id = $(this).data('poster_id');
          var comment = $(this).data('comment');
          var post = $(this).data('post');
          var commentid = $(this).data('commentid');
          var action= 'like_comment';
          $.ajax({
            url:"/action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
             refresh_data(limit2,from);
             audioElement.play();
            }
          })
          
        });
        
        $(document).on('click', '.delete_comment', function(e){
          e.preventDefault();
          
          var url='/ajax/v2/delete_comment.php'; 
          var poster_id = $(this).data('poster_id');
          var commentid = $(this).data('commentid');

          $.ajax({
            type:'POST',
            url:url,
            data: {
                   commentid: commentid,
                   poster_id: poster_id
                  },
            beforeSend: function(){
              $("#dcomment_id"+commentid).slideToggle();  
            },
            success: function(){
            refresh_data(limit2,from);
            }
         })
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
            url: "/ajax/share.php",
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
       
    $(document).on('click', '.remove_friend', function(e){
    e.preventDefault();
    var url='/ajax/remove_friend.php';
    var post_id = $(this).data('post_id');
    var user_id = $(this).data('user_id');
    var name = $(this).data('name');

    var message = confirm("Remove "+name+" from your friends?");
    if (message == true) {
    //Ajax request
    $.ajax({
                type:'POST',
                url:url,
                data: {
                       post_id: post_id,
                       user_id: user_id
                      },
                 beforeSend: function(){
                 $("div#post_box"+post_id).slideToggle('slow');
                },
                success: function(){
                 // alert('Boom');
                }

            });
    //End Request
    }

    });

    $(document).on('click', '.cancel_friend', function(e){
    e.preventDefault();
    var url='/ajax/remove_friend.php';
    var user_id = $(this).data('user_id');

    //Ajax request
    $.ajax({
                type:'POST',
                url:url,
                data: {
                       user_id: user_id
                      },
                 beforeSend: function(){
                  $('#decline_request'+user_id).slideToggle();
                  $("#request_button"+user_id).slideToggle();
                },
                success: function(){
                 // alert('Boom');
                }

            });
    //End Request

    });

    $(document).on('click', '.accept_friends', function(e){
        e.preventDefault();
        var user_id = $(this).data('user_id');
        
        $.ajax({
            url:"/ajax/v2/accept_friendship_request.php",
            method:"POST",
            data:{user_id:user_id},
            cache:false,
            beforeSend: function(){
                 $("#request_button"+user_id).slideToggle('slow');
                },
            success:function(data)
            {
                 $('#decline_request'+user_id).slideToggle();
                 $('#accepted_msg'+user_id).slideToggle();
            }
          })

    });

    $(document).on('click', '.add_friend', function(e){
         e.preventDefault();
         var user_id = $(this).data('user_id');
         
         $.ajax({
            url:"/ajax/v2/friend_request.php",
            method:"POST",
            data: {user_id:user_id},
            beforeSend: function(){
                $('#requested_friends'+user_id).slideToggle();
            },
            success:function(data)
            {
                $('#success_msg'+user_id).slideToggle();      
            }
          })
      
    });
 
 $(document).on('click', '.add_favorites', function(e){
    e.preventDefault();
    var url='/ajax/v2/add_favorites.php';
    var post_id = $(this).data('post_id');
    var user_id = $(this).data('user_id');

    //Ajax request
    $.ajax({
                type:'POST',
                url:url,
                data: {
                       post_id: post_id,
                       user_id: user_id
                      },
                success: function(){
                 refresh_data(limit2,from);
                }

            });
    //End Request
 });
 
 $(document).on('click', '.delete_post', function(e){
    e.preventDefault();
    var url='/ajax/v2/delete_post.php';
    var post_id = $(this).data('post_id');
    var user_id = $(this).data('user_id');
    //Ajax request
    $.ajax({
                type:'POST',
                url:url,
                data: {
                       post_id: post_id,
                       user_id: user_id
                      },
                 beforeSend: function(){
                 $("div#post_box"+post_id).slideToggle('slow');
                },
                success: function(data){
                 refresh_data(limit2,from);
                }

            });
    //End Request
 });

  $(document).on('click', '.add_product', function(e){
  e.preventDefault();
  let pr_i= $(this).data("pr_i");
  let action= $(this).data("action");
  let object_price= $(this).data("object_price");
  let designation= $(this).data("designation");
  let image= $(this).data("image");
  let url='/ajax/input_order.php';

  $.ajax({
    type:'POST',
    url:url,
    data: {
           pr_i: pr_i,
           action: action,
           object_price:object_price,
           designation:designation,
           image:image
          },
    beforeSend: function(){
      $('.add_product').removeClass("bg-blue-600");
      $('.add_product').addClass("bg-green-600");
    },
    success: function(data){
      $('.add_product').html('Added');
    }
    });
  });  
     
});
