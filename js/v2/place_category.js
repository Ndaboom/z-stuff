$(document).ready(function() {
    
   
    $(document).on('click', '.follow_place', function(e){
       e.preventDefault();
       var place_id = $(this).data('place_id');
       var action = $(this).data('action');
       var place_name = $(this).data('place_name');
       var cr_i = $(this).data('cr_i');
       
       $.ajax({
          url:"/ajax/v2/follow_place.php",
          method:"POST",
          data: {place_id:place_id,action:action,place_name:place_name,cr_i:cr_i},
          beforeSend: function(){
                  $('#follow_place'+place_id).slideToggle();
              },
          success:function(data)
          {
                
          }
        })
    
    });

});