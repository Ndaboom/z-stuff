$(document).ready(function() {

    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', '../../sounds/blop.mp3');
    
    update_last_activity();
    setTimeout(() => {
      fetch_incomming_msg();
      fetch_messages();
      fetch_notifications(15,0);
      fetch_cart(15, 0);
    }, 5000)
    
    setInterval(function(){
       fetch_incomming_msg();
       fetch_messages();
       update_last_activity();
    },20000);// 20 seconds
    
$(document).on('keyup', '.search_in_message', function(e){
    var query = $('#messenger_box').val();

    $.ajax({
      url:"/ajax/v2/messenger/fetch_chats.php",
      method:"POST",
      data:{query:query},
      success:function(data)
      {
        $('#messages_list').html(data);
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

var url ='ajax/search.php';
$('input#search_box').on('keyup', function(){
    var query = $(this).val();
    if (query.length > 2) {
      $.ajax({
            type:'POST',
            url:url,
            data: {
                  query: query
                  },
            success: function(data){
              $("#display-results").html(data).show();
            }
        });
    }else{
        $("#display-results ").hide();
    }
});

function update_last_activity()
{
    $.ajax({
      url:"/ajax/update_last_activity.php",
      success:function()
      {

      }
    })
}

function check_for_incomming_calls()
{
    let action = "check_for_incomming_calls"
    $.ajax({
      url:"/ajax/calls.php",
      data:{action:action},
      success:function(data)
      {
        console.log(data);
      }
    })
}

  $(document).on('click', '.check_notifications', function(e){
    e.preventDefault();
    var url='/ajax/check_notifications.php';
    $.ajax({
      url:url,
      success:function()
      {
        fetch_notifications(15,0);
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
          //$('#followers_box'+place_id).html(data);      
       }
     })
 
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
   
});
