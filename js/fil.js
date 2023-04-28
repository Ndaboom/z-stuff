//Old ones

$(document).ready(function() {

        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../sounds/blop.mp3');

        best_of_user();
        fetch_current_user_last_post();
        fetch_online_user();
        fetch_incomming_msg();

        setInterval(function(){
           update_last_activity();
           fetch_online_user();
           fetch_incomming_msg();
        },24000);// 24 seconds
        
        $('#image').on('change',function(event){
          $("#publish").show();
        });

        $('.maker').click(function(event){
            $('#searchbox2').show();
        });

        var url1 ='ajax/wish_maker.php';
        $('input#searchbox2').on('keyup', function(){
        var query = $(this).val();
        if (query.length > 2) {
          $.ajax({
                type:'POST',
                url:url1,
                data: {
                       query: query
                      },
                beforeSend: function(){
                    $("#spinner").show();
                },
                success: function(data){
                   $("#spinner").hide();
                   $("#display-box ").html(data).show();

                }

            });
        }else{
            $("#display-box").hide();
        }

       });
       
        var limit = 7;
        var start = 0;
        var limit2=7;
        var action= 'inactive';
        function load_data(limit,start){
          $.ajax({
            url:"fetch.php",
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

        $(document).on('click', '.send_msg', function(){
        var wish_id  = $(this).data('wish_id');
        var from_user_id = $(this).data('user_id');
        var color = $(this).data('color');
        var wish  = $(this).data('wish');
        var chat_message= $('#replycontent'+wish_id).val();
        if($('#replycontent'+wish_id).val() != ""){
           $.ajax({
            url: "ajax/wish_responder.php",
            method:"POST",
            data:{from_user_id:from_user_id,chat_message:chat_message,color:color,wish:wish,wish_id:wish_id},
            beforeSend: function(){
                    $('#wish'+wish_id).hide();
                },
             success:function(){
               $('#wish'+wish_id).hide();
               $('.success').val('');
             }
            })
        }
       });

        var from=0;
        function refresh_data(limit2,from){
         $.ajax({
            url:"refresh.php",
            method:"POST",
            data:{limit2:limit2, from:from},
            success:function(data)
            {
              $('#post_list').html(data);
            }
          })
        }

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
                    audioElement.play();
                  }else{
                    $("#like"+micropostId).fadeIn('fast');
                    $("#unlike"+micropostId).hide();
                  }
                },
                success: function(likers){
                   best_of_user();
                   fetch_current_user_last_post();
                   refresh_data(limit2,from);
                }

            });
        });

        function best_of_user()
        {
          $.ajax({
            url:"ajax/best_of_user.php",
            method:"POST",
            success:function(data){
              $('#best_of_user').html(data);
            }
          })
        }

        function fetch_online_user()
        {
          $.ajax({
            url:"ajax/fetch_online_user.php",
            method:"POST",
            success:function(data){
              $('#user_details').html(data);
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

        function fetch_current_user_last_post()
        {
          var action= 'fetch_user_last_post';
          $.ajax({
            url: 'action.php',
            method:"POST",
            data:{action:action},
            success:function(data)
            {
              $('#last_post').html(data);
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
            refresh_data(limit2,from);
            fetch_current_user_last_post();
            audioElement.play();
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
             refresh_data(limit2,from);
             fetch_current_user_last_post();
             audioElement.play();
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
             refresh_data(limit2,from);
             fetch_current_user_last_post();
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

    $('#dropdownMenuButton').click(function(){
    $('#dropdown-buttom').toggle();
    });

//Adds
$("a#local_suggestion").on("click", function(e){

  var url='ajax/affirm_localization.php';

   $.ajax({
                type:'POST',
                url:url,
                beforeSend: function(){
                    $("a#local_suggestion").hide();
                    $("a#moreaboutlocalization").hide();
                },
                success: function(){
                   $('a#conf_localization').slideToggle('slow');
                }

            });

});

$("a#moreaboutlocalization").on("click", function(e){
  $("div#location_form1").hide();
  $("div#personalize_location").slideToggle('slow');
});

$("input#submit_localization").on("click",function(e){
  e.preventDefault();
  var url='ajax/personalized_localization.php';

  if ( $("input#city_fields").val() != "" && $("input#country_fields").val() != "")
  {
     var city = $("input#city_fields").val();
     var country = $("input#country_fields").val();

     $.ajax({
                type:'POST',
                url:url,
                data:{city:city,country:country},
                beforeSend: function(){
                    $("div#form_details").hide();
                },
                success: function(){
                   $('h5#confirm_localisation_reception').slideToggle('slow');
                   $('h5#confirm_localisation_reception').text(city+', '+country);
                }

     });

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

function _(el)
{
  return document.getElementById(el);
}

$('.upload_video').click(function(event){
    var message = confirm("Upload your post?");
    if (message == true) {
    uploadVideo();
    } else {
    alert("Upload cancelled!");
    }

});

function uploadVideo() {
  var file = _("file1").files[0];

  var formdata = new FormData();
  formdata.append("file1", file);
  formdata.append("videoDescription",$("#videoDescription").val());
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler,false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST","ajax/file_upload_parser.php");
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
   fetch_current_user_last_post();
   $('#videosModal').modal('hide');
}

function errorHandler(event)
{
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event)
{
  _("status").innerHTML = "Upload aborted";
}

$(document).on('click', '.link_button', function(e){
    
    var post_id = $(this).data('post_id');
    var content = $('#link'+post_id).val();
    /* Get the text field */
    var copyLink = document.getElementById("link"+post_id);
    
     /* Select the text field */
    copyLink.select();
    copyLink.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied link */
  alert("Link copied : " + copyLink.value); 
});


    });
