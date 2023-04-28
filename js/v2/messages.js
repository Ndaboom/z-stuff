$(document).ready(function() {

        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../../sounds/accomplished.mp3');
        
        setInterval(function(){
           fetch_incomming_msg();
           fetch_messages();
        },5000);// 5 seconds
        
        

        var limit = 5;
        var start = 0;
        var limit2=10;
        var action = 'inactive';
        var content = '';
        
        function load_data(limit,start){
          $.ajax({
            url:"/ajax/v2/messenger/fetch_users.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            beforeSend: function(){
                    $("#spinner1").show();
                },
            success:function(data)
            {
              $('#users_list').append(data);
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
        
        $("#chat_history").scroll(function()
        {
        var div = $(this);
        if (div[0].scrollHeight - div.scrollTop() == div.height())
        {
            alert("Reached the bottom!");
        }
        else if(div.scrollTop() == 0)
        {
            alert("Reached the top!");
        }
        });
        
        $(document).on('click', '.open-chat', function(e){
        
        e.preventDefault();
        var url='/ajax/v2/messenger/fetch_chat.php';
        var to_user_id = $(this).data('to_user_id');
        var username = $(this).data('username');
        var from_user_id = $(this).data('from_user_id');
        var limit = 5, start = 0;
        
        $.ajax({
            url:"/ajax/v2/messenger/fetch_chat.php",
            method:"POST",
            data:{to_user_id:to_user_id, from_user_id:from_user_id, start:start, limit:limit},
            cache:false,
            beforeSend: function(){
                    $("#username").html(username);
                    $('#msg_content').attr('placeholder','Your message to '+username);
                    $('.ripple-effect').attr('data-uid', to_user_id);
                    $('.ripple-effect').attr('data-username', username);
                },
            success:function(data)
            {
                $("#chat_history").html(data);
                gotoBottom("chat_history");
            }
        });
        
        });
        
        function gotoBottom(id){
            var element = document.getElementById(id);
            element.scrollTop = element.scrollHeight - element.clientHeight;
        }
        
        $(document).on('keyup', '.message_box', function(){
        content = $(this).val();
        });
        
        $(document).on('click', '.ripple-effect', function(e){
           var uid = $(this).data('uid');
           var username = $(this).data('username');
           if(content.length > 0){
             
            $.ajax({
            url: "/ajax/insert_chat.php",
            method:"POST",
            data:{to_user_id:uid,chat_message:content},
             beforeSend: function(){
              $('#msg_content').val('');
              audioElement.play();
             },
             success:function(data){
                reload_chat(uid,username, 0,5);
             }
            })
             
           } 
        });

        function reload_chat(to_user_id,username,start,limit){  
          $.ajax({
            url:"/ajax/v2/messenger/reload_chat.php",
            method:"POST",
            data:{to_user_id:to_user_id, start:start, limit:limit},
            cache:false,
            beforeSend: function(){
                    $("#username").html(username);
                    $('#msg_content').attr('placeholder','Your message to '+username);
                    $('.ripple-effect').attr('data-uid', to_user_id);
                },
            success:function(data)
            {
                $("#chat_history").html(data);
                gotoBottom("chat_history");
            }
        });
        }
        
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
        
        
        
});
