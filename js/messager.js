$(document).ready(function(){

$('#action_menu_btn').click(function(){

  $('.action_menu').toggle();

});



var audioElement = document.createElement('audio');

    audioElement.setAttribute('src', '../sounds/accomplished.mp3');

    

    audioElement.addEventListener("timeupdate",function(){

        $("#currentTime").text("Current second:" + audioElement.currentTime);

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

    

    var limit = 14;

    var start = 0;

    var limit2=7;

    var action= 'inactive';

    

    setInterval(function(){

      update_last_activity();

      update_chat_history_data();

      fetch_incomming_msg();

      refresh(limit, start)

    },5000);



    

    function fetch_user(limit,start)

    {

      $.ajax({

        url:"ajax/fetch_users.php",

        method:"POST",

        data:{limit:limit, start:start},

        cache:false,

        beforeSend: function(){

                    $("#spinner1").show();

                },

        success:function(data){

           $("#spinner1").hide();

           $('#user_details').append(data);

        }

      })

    }

    

    function refresh(limit, start)

    {

     $.ajax({

        url:"ajax/fetch_users.php",

        method:"POST",

        data:{limit:limit, start:start},

        cache:false,

        success:function(data){

           $("#spinner1").hide();

           $('#user_details').html(data);

        }

      })   

    }

    

    if(action == 'inactive')
        {

          action = 'active';

          fetch_user(limit,start);

        }

        

        $(window).scroll(function(){

           if($(window).scrollTop() + $(window).height() > $("#user_details").height() && action == 'inactive')

           {

            action = 'active';

            start = start + limit;

            limit2 = start+7;

            setTimeout(function(){

              fetch_user(limit,start);

            },1000);

           }

        });

    

     function fetch_incomming_msg()

        {

          $.ajax({

            url:"ajax/fetch_incomming_msg.php",

            method:"POST",

            success:function(data)

            {

              $('#message').html(data);

              //make_sound();

            }

          })

        }

        

        function make_sound()

        {

          $.ajax({

            url:"ajax/make_sound.php",

            method:"POST",

            success:function(data)

            {

              if(data != '')

              {

                 audioElement.play();

              }

            }

          })

        }

    

    function update_last_activity()

    { 

      $.ajax({

        url:"ajax/update_last_activity.php",

      success:function()

      {



      }

    })

      

    }

    function make_chat_dialog_box(to_user_id, to_user_name,to_user_pic)

    {

      var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="Your chat with '+to_user_name+'">';



      modal_content += '<div style="height:350px; border:1px solid #ccc; overflow-y:scroll;margin-bottom:24px; margin-top:60px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';

      modal_content +=fetch_user_chat_history(to_user_id);

      modal_content+= '</div>';

      modal_content+= '<div class="form-group">';

      modal_content+='<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message" placeholder="Your message.."></textarea>';

      modal_content +='</div> <div class="form-group" align="right">';

      modal_content +='<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send <i class="fas fa-location-arrow"></i> </button></div></div>';

      $('#user_model_details').html(modal_content);

     }

     

      

    $(document).on('click', '.start_chat', function(){

         var to_user_id= $(this).data('touserid');

         var to_user_name= $(this).data('tousername');

         var to_user_pic= $(this).data('touserpic');

          var chat_message= $('#chat_message_'+to_user_id).val();

         make_chat_dialog_box(to_user_id,to_user_name,to_user_pic);

        $('#user_dialog_'+to_user_id).dialog('open');

        $("#user_dialog_"+to_user_id).dialog({
          autoOpen:false,
          width:400
        });
       
        $('#chat_message_'+to_user_id).emojioneArea({
          pickerPosition:"top",
          toneStyle: "bullet"
        });

    });

    

    $(document).on('click', '.send_chat', function(){

        

        var to_user_id= $(this).attr('id');

        var chat_message= $('#chat_message_'+to_user_id).val();

        if($('#chat_message_'+to_user_id) != ""){

        $.ajax({
            url: "ajax/insert_chat.php",
            method:"POST",
            data:{to_user_id:to_user_id,chat_message:chat_message},
            beforeSend: function(){
            $('#chat_message_'+to_user_id).val('');
            audioElement.play();
            },
            success:function(data){
              //$('#chat_message_'+to_user_id).val('');
              $('#chat_history_'+to_user_id).html(data);
            }
        })
        }
    });

    function fetch_user_chat_history(to_user_id)
    {
      $.ajax({
        url:"ajax/fetch_user_chat_history.php",
        method:"POST",
        data:{to_user_id:to_user_id},
        success:function(data){
          $('#chat_history_'+to_user_id).html(data);
        }
      })
    }



    function update_chat_history_data()
    {
      $('.chat_history').each(function(){
          var to_user_id =$(this).data('touserid');
          fetch_user_chat_history(to_user_id);
      });
    }



    $(document).on('click', '.ui-button-icon',function(){

        $('.user_dialog'),dialog('destroy').remove();

    });



    $(document).on('focus', '.chat_message', function(){
        var is_type = 'yes';
        $.ajax({
          url:"ajax/update_is_type_status.php",
          method: "POST",
          data:{is_type:is_type},
          success:function()
          {
          }
        })
    });



    $(document).on('blur','.chat_message', function(){
      var is_type ='no';
      $.ajax({
        url: "ajax/update_is_type_status.php",
        method: "POST",
        data:{is_type:is_type},
        success:function()
        {

        }
      })
    });

  });