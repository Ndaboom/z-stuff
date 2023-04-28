function collapseCOVIDINFO() {
    $(this).hide();
    $('div#moreCinfos').slideToggle('slow');
    $('div#french_version').show();
}

function collapseENVERSION() {
    $('div#french_version').hide();
    $('div#english_version').slideToggle('slow');
}

$(document).on('click', '.suggestion_button', function(){
     var relatives_id = $(this).data('relative_id');
     var notification_id = $(this).data('notification_id');

     var url='ajax/user_relationships_suggestion_action.php';
     
     $.ajax({
                type:'POST',
                url:url,
                data: {
                       relatives_id: relatives_id,
                       notification_id: notification_id
                      },
                success: function(){
                $('a#suggestion_box'+notification_id).hide();
                 $('small#relatives_conf_sent'+notification_id).slideToggle('slow');    
                }

            });



});

$(document).on('click', '.follow_event', function(){
  
    var event_id = $(this).data('event_id');
    var event_name = $(this).data('event_name');
    var user_id = $(this).data('user_id');
    var notification_id = $(this).data('notification_id');
    var url='ajax/follow_event.php';
    $.ajax({
               type:'POST',
               url:url,
               data: {
                      event_id: event_id,
                      event_name: event_name,
                      user_id: user_id,
                      notification_id: notification_id
                     },
                beforeSend: function(){
                  $('#notification'+notification_id).slideToggle();
                },
               success: function(){
                $('#event_success_card'+notification_id).slideToggle();
               }
  
           });
  });
  
  $(document).on('click', '.ignore_event', function(){
  
    var notification_id = $(this).data('notification_id');

    var url='ajax/delete_notification.php';
    $.ajax({
               type:'POST',
               url:url,
               data: {
                      notification_id: notification_id
                     },
                beforeSend: function(){
                    $('#notification'+notification_id).slideToggle();
                    $('#event_ignored_card'+notification_id).slideToggle();
                },
               success: function(){
                
               }
  
           });
  
  });
  