$(document).ready(function() {
     
      $(document).on('click', '.follow', function(e){
         e.preventDefault();
         var event_id = $(this).data('event_id');
         var event_name = $(this).data('event_name');
         var cr_i = $(this).data('cr_i');
         var action = $(this).data('action');
        
         $.ajax({
            url:"/ajax/v2/follow_event.php",
            method:"POST",
            data: {event_id:event_id,event_name:event_name,cr_i:cr_i,action:action},
            beforeSend: function(){
                    $('#follow_event'+event_id).slideToggle();
                    $('#unfollow_event'+event_id).slideToggle();
                },
            success:function(data)
            {
                     
            }
          })
      
      });
      
      
      
});
