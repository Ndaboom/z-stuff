$(document).ready(function() {

    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', '../../sounds/blop.mp3');
    
    fetch_incomming_msg();
    fetch_messages();
    fetch_notifications(15,0);
    fetch_cart(15, 0);
    
    setInterval(function(){
       fetch_online_user();
       fetch_incomming_msg();
       fetch_messages();
    },5000);// 5 seconds
    
    
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
                audioElement.play();
              }else{
                $("#like"+micropostId).fadeIn('fast');
                $("#unlike"+micropostId).hide();
              }
            },
            success: function(likers){
              //  refresh_data(limit2,from);
            }

        });
    });
    
    
    
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
   
    $(document).on('keyup', '.comment_box', function(e){
    var postId = $(this).data('post_id');
    $('#cbtn'+postId).show();  
    });
    
    $(document).on('keyup', '.search_in_message', function(e){
        var data = $('#messenger_box').val();
        alert(data);
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
   
});
