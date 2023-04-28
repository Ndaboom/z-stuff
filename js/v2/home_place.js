$(document).ready(function() {

    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', '../../sounds/blop.mp3');
    
    $(document).on('click', '.follow', function(e){
    e.preventDefault();
    var place_id = $(this).data('place_id');
    var place_name = $(this).data('place_name');
    var action = $(this).data('action');

    var url='/ajax/v2/place_interest.php';

      $.ajax({
            type:'POST',
            url:url,
            data: {
                   place_id: place_id,
                   place_name: place_name,
                   action: action
                  },
            beforeSend: function(){
              if(action == "follow"){
                $('#interested_btn').slideToggle();
                $('#uninterested_btn').slideToggle();
              }else{
                $('#uninterested_btn').slideToggle();
                $('#interested_btn').slideToggle();
              }
             
             reload_followers(place_id);
            },
            success: function(data){
              reload_followers(place_id)
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
        var post_id = $(this).data('post_id');
        var current_link =  window.location.href+"&p_i="+post_id;
        
        navigator.clipboard.writeText(current_link).then(function() {
            alert("Link Copied to clipboard");
        }, function(err) {
            alert("Async: Could not copy text: "+err);
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
          var url='/ajax/v2/placepost_comment.php';
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
                reload_data(limit2,from);
              }
          });
         }
      });

      $(document).on('click', '.like_comment', function(e){
        e.preventDefault();
         
        var poster_id = $(this).data('poster_id');
        var comment = $(this).data('comment');
        var placepost_id = $(this).data('post');
        var commentid = $(this).data('commentid');
        var action= 'like_comment';
        $.ajax({
          url:"/ajax/v2/placecomment_like.php",
          method:"POST",
          data:{poster_id:poster_id,comment:comment,placepost_id:placepost_id,commentid:commentid,action:action},
          success:function(data)
          {
           reload_data(limit2,from);
           audioElement.play();
          }
        })
        
      });

      $(document).on('click', '.delete_comment', function(e){
        e.preventDefault();
        
        var url='/ajax/v2/delete_placepost_comment.php'; 
        var poster_id = $(this).data('poster_id');
        var commentid = $(this).data('commentid');
        var message = confirm("Do you really want to delete this comment?");
        if (message == true) {
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
          reload_data(limit2,from);
          }
       })
      }

     });
    
    var limit = 7;
    var start = 0;
    var limit2=7;
    var action = 'inactive';
    function load_data(limit,start){
      $.ajax({
        url:"/ajax/v2/fetch_place_timeline.php",
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

    var url='/ajax/v2/place_like.php';
    var placepost_id = $(this).data('placepost_id');
    var action = $(this).data('action');
        $.ajax({
            type:'POST',
            url:url,
            data: {
                   placepost_id: placepost_id,
                   action: action
                  },
             beforeSend: function(){
              if(action == "like"){
                $("#like"+placepost_id).hide();
                $("#unlike"+placepost_id).fadeIn('fast');
                audioElement.play();
              }else{
                $("#like"+placepost_id).fadeIn('fast');
                $("#unlike"+placepost_id).hide();
                audioElement.play();
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
        url:"/ajax/v2/refetch_place_timeline.php",
        method:"POST",
        data:{limit2:limit2, from:from},
        success:function(data)
        {
          $('#post_list').html(data);
        }
      })
    }

    function reload_followers(place_id){
      $.ajax({
         url:"/ajax/v2/fetch_followers.php",
         method:"POST",
         data:{place_id:place_id},
         success:function(data)
         {
           $('#followers').html(data);
         }
       })
     }

     function _(el)
{
    return document.getElementById(el);
}

$(document).on('click', '.remove_post', function(e){
  e.preventDefault();
  var message = confirm("Delete your post?");
  var post_id = $(this).data('post_id');
  var user_id = $(this).data('user_id');
  var place_id = $(this).data('place_id');
  if (message == true) {
    deletePost(post_id,user_id,place_id);
    $("#post_box"+post_id).slideToggle();
  } else {
  alert("cancelled!");
  }
});

function deletePost(post_id,user_id,place_id){
  $.ajax({
    url:"/ajax/v2/delete_placepost.php",
    method:"POST",
    data:{post_id:post_id,user_id:user_id,place_id:place_id},
    success:function(data)
    {
    }
  })
}

$('.upload_video').click(function(event){
    event.preventDefault();
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
  ajax.open("POST","/ajax/place_video_upload_parser.php");
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
  window.location.reload();
}

function errorHandler(event)
{
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event)
{
  _("status").innerHTML = "Upload aborted";
}
    
});
