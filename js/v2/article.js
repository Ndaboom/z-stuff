$(document).ready(function() {

     $(document).on('keyup', '.comment_box', function(e){
        $('#cbtn').show();  
     });
     
     $(document).on('keyup', '.reply_comment', function(e){
        var comment_id = $(this).data('comment_id');
        $('#rbtn'+comment_id).show();
     });
     
      $(document).on('click', '.post_comment', function(e){
         e.preventDefault();
         var article_id = $(this).data('article_id');
         var content = $("#comment_box").val();
        
         $.ajax({
            url:"/ajax/v2/article_comment.php",
            method:"POST",
            data: {article_id:article_id,content:content},
            success:function(data)
            {
              $('#comments_box').html(data);
              $("#comment_box").val("");
            }
          })
      
      });

      $(document).on('click', '.remove_article', function(e){
         e.preventDefault();
         var message = confirm("Remove this post?");
         if (message == true) {
         var a_i = $(this).data('a_i');
         var o_i = $(this).data('o_i');
         $.ajax({
            url:"/ajax/v2/remove_article.php",
            method:"POST",
            data: {a_i:a_i,o_i:o_i},
            success:function(data)
            {
               window.location.href = "articles.php?p=m_articles";
            }
          })
         }
      });
      
      $(document).on('click', '.post_reply', function(e){
      e.preventDefault();
         var article_id = $(this).data('article_id');
         var comment_id = $(this).data('comment_id');
         var content = $("#reply"+comment_id).val();
        
         $.ajax({
            url:"/ajax/v2/reply_comment.php",
            method:"POST",
            data: {article_id:article_id,content:content,comment_id:comment_id},
            success:function(data)
            {
              $('#comments_box').html(data);
              $("#reply"+comment_id).val("");
            }
          })
      });
      
      $(document).on('click', '.reply_btn', function(e){
      e.preventDefault();
      var comment_id = $(this).data('comment_id');
      $("#reply_box"+comment_id).slideToggle();
      });
     
});
