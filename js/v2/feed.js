$(document).ready(function() {

        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../../sounds/blop.mp3');
        var limit = 7;
        var start = 0;
        var limit2=7;
        var action = 'inactive';
        var from=0;

        setTimeout(() => {
          fetch_incomming_msg();
          fetch_messages();
          fetch_notifications(15,0);
          fetch_cart(15, 0);
          fetch_relatives_list();
        }, 5000)
        
        setInterval(function(){
           fetch_online_user();
           fetch_incomming_msg();
           fetch_messages();
        },20000);// 15 seconds
        
        function load_data(limit,start){
          $.ajax({
            url:"/ajax/v2/fetch_feeds.php",
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
        var url='/ajax/micropost_like.php';
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
                   refresh_data(limit2,from);
                }
            });
        });
        
        function refresh_data(limit2,from){
         $.ajax({
            url:"/ajax/v2/refetch_feeds.php",
            method:"POST",
            data:{limit2:limit2, from:from},
            success:function(data)
            {
              $('#post_list').html(data);
            }
          })
        }
        
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

       $(document).on('click', '.send_message', function(e){
        e.preventDefault();
        var user_id = $(this).data('user_id');
        var username = $(this).data('username');
        window.location.href = "messages.php?i="+user_id+"&n="+username;
       });

       $(document).on('click', '.user_profile', function(e){
        e.preventDefault();
        var user_id = $(this).data('user_id');
        var username = $(this).data('username');
        window.location.href = "timeline.php?id="+user_id+"&n="+username;
       });

       $(document).on('click', '.user_post', function(e){
        e.preventDefault();
        var user_id = $(this).data('user_id');
        var username = $(this).data('username');
        window.location.href = "posts.php?id="+user_id+"&n="+username;
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
       
    $(document).on('click', '.remove_friend', function(e){
    e.preventDefault();
    var url='/ajax/remove_friend.php';
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
                success: function(likers){
                 // alert('Boom');
                }

            });
    //End Request
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
 
         function fetch_incomming_msg()
        {
          $.ajax({
            url:"ajax/v2/fetch_incomming_msg.php",
            method:"POST",
            success:function(data)
            {
              $('#message_icon').html(data);
            }
          })
        }
        
        function fetch_messages()
        {
          $.ajax({
            url:"/ajax/v2/fetch_messages.php",
            method:"POST",
            success:function(data)
            {
              $('#messages_list').html(data);
            }
          })
        }
        
        $("#notifications_list").scroll(function()
        {
        
        var div = $(this);
        if (div[0].scrollHeight - div.scrollTop() == div.height())
        {
            alert("Reached the bottom!");
        }
        
        });
        
        function fetch_notifications(limit, start)
        {
          $.ajax({
            url:"/ajax/v2/fetch_notifications.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            success:function(data)
            {
              $('#notifications_list').html(data);
            }
          })
        }

        function fetch_cart(limit, start)
        {
          $.ajax({
            url:"/ajax/v2/fetch_cart.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            success:function(data)
            {
              $('#users_cart').html(data);
            }
          })
        }
        
        $(document).on('click', '.accept_friends', function(e){
        e.preventDefault();
        var user_id = $(this).data('user_id');
        var notification_id = $(this).data('notification_id');
        
        $.ajax({
            url:"/ajax/v2/accept_friendship_request.php",
            method:"POST",
            data:{notification_id:notification_id, user_id:user_id},
            cache:false,
            beforeSend: function(){
                 $("#request_button"+user_id).slideToggle('slow');
                },
            success:function(data)
            {
                 $('#request_accepted'+notification_id).slideToggle();
            }
          })

        });
        
function _(el)
{
    return document.getElementById(el);
}

$('.upload_video').click(function(event){
    var message = confirm("Upload your post?");
    if (message == true) {
    uploadVideo();
    $("#progressBar").show();
    $("#status").show();
    } else {
    alert("Upload cancelled!");
    }
});

function uploadVideo() {
  var file = _("file1").files[0];

  var formdata = new FormData();
  formdata.append("file1", file);
  formdata.append("videoDescription",$("#content").val());
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler,false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST","/ajax/file_upload_parser.php");
  ajax.send(formdata);
}

function progressHandler(event)
{
  _("loaded_n_total").innerHTML = "Upladed "+event.loaded+" bytes of "+event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent)+"% uploaded...please wait";
}

function completeHandler(event)
{
  _("status").innerHTML = event.target.responseText;
  _("progressBar").value = 0;
  window.location.href = "https://zungvi.com/timeline.php";
}

function errorHandler(event)
{
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event)
{
  _("status").innerHTML = "Upload aborted";
}

//checkout
$(document).on('click', '.checkout', function(e){
  e.preventDefault();
  let url = "/ajax/v2/checkout.php";
  var message = confirm("validate?");
  if (message == true) {
  $.ajax({
    type:'POST',
    url:url,
    beforeSend: function(){
      $('.add_product').removeClass("bg-blue-600");
      $('.add_product').addClass("bg-green-600");
    },
    success: function(data){
      fetch_cart(15,0);
    }
    });
  }

});
//remove a product from cart
$(document).on('click', '.remove_product', function(e){
  e.preventDefault();

  let product_name = $(this).data('product_name');
  let product_id = $(this).data('product_id');
  let url = "/ajax/v2/cancel_order.php";

  var message = confirm("remove "+product_name+" ?");
    if (message == true) {
      e.preventDefault();
      $.ajax({
      type:'POST',
      url:url,
      data:{product_id:product_id},
      beforeSend: function(){
        $('#box_product'+product_id).slideToggle();
      },
      success: function(data){
        fetch_cart(15,0);
      }
      });
    }

});


//Fetch relatives list
function fetch_relatives_list(){
  $.ajax({
     url:"/ajax/v2/fetch_home_relatives.php",
     method:"POST",
     success:function(data)
     {
       $('#relatives_list').html(data);
     }
   })
 }
       
});
