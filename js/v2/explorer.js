$(document).ready(function() {
      let start = 0;
      let rows = 100;
      relatives_suggestion(start,rows);
     
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
                    $('#unfollow_place'+place_id).slideToggle();
                },
            success:function(data)
            {
               $('#followers_box'+place_id).html(data);      
            }
          })
      
      });
   
      $(document).on('click', '.join_forum', function(e){
         e.preventDefault();
         var fr_i = $(this).data('fr_i');
         
         $.ajax({
            url:"/ajax/v2/join_forum_request.php",
            method:"POST",
            data: {fr_i:fr_i},
            beforeSend: function(){
                    $('#join_btn'+fr_i).slideToggle();
                    $('#mforum'+fr_i).slideToggle();
                },
            success:function(data)
            {
               //$('#followers_box'+place_id).html(data);      
            }
          })
      
      });
      
      function relatives_suggestion(start,rows)
       {

          $.ajax({
            url:"/ajax/v2/fetch_relatives.php",
            method:"POST",
            data:{start:start,rows:rows},
            success:function(data){
              $('#friends_suggestion').html(data);
            }
          })
       }

    $(window).scroll(function(){
      if($(window).scrollTop() + $(window).height() > $("#friends_suggestion").height())
      {
         rows = rows + 25;
         relatives_suggestion(start,rows);
      }
   });

});
