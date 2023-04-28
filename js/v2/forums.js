$(document).ready(function() {

     $(document).on('click', '.join_forum', function(e){
             e.preventDefault();
             var url='/ajax/v2/join_forum.php';
             var id= $(this).attr("id");
             var forumId = id.split("forum")[1];
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       forumId: forumId
                      },
                beforeSend: function(){
                   $("#forum"+forumId).slideToggle();
                },
                success: function(response){
                    
                }
            });
            
         });
});
