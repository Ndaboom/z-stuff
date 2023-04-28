$(document).ready(function() {

fetch_game_comment();

setInterval(function(){
    fetch_game_comment();
 },10000);// 10 seconds

function fetch_game_comment()
  {
    $.ajax({
      url:"ajax/v2/game_comment.php",
      method:"POST",
      success:function(data)
      {
        $('#comments_box').html(data);
      }
    })
  }

function _(el)
{
    return document.getElementById(el);
}

$(document).on('click', '.delete_comment', function(e){
    e.preventDefault();
    var message = confirm("Delete your comment?");
    var comment_id = $(this).data('comment_id');
    var poster_id = $(this).data('poster_id');
    if (message == true) {
    deleteComment(comment_id,poster_id);
    }
});

function deleteComment(comment_id,poster_id){
    var url='/ajax/v2/remove_game_comment.php';

//Ajax request
    $.ajax({
        type:'POST',
        url:url,
        data: {
                comment_id: comment_id,
                poster_id: poster_id
                },
            beforeSend: function(){
            $("div#comment_box"+comment_id).slideToggle('slow');
        },
        success: function(){
            // alert('Boom');
        }
    });
//End Request
}

$('.upload_comment').click(function(event){
    var message = confirm("Upload your comment?");
    if (message == true) {
    event.preventDefault();    
    uploadImage();
    $("#progressBar").show();
    $("#status").show();
    } else {
    alert("Upload cancelled!");
    }
});

function uploadImage() {
  var file = _("image").files[0];

  var formdata = new FormData();
  if(file){
  formdata.append("image", file);
  }
  formdata.append("comment_content",$("#comment_content").val());
  formdata.append("comment_owner",$("#comment_owner").val());
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler,false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST","/ajax/comment_upload.php");
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
  //window.location.href = "https://zungvi.com/timeline.php";
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