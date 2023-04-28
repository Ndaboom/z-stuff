<div class="modal fade" id="eventdashboard">    
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content" style="width:1000px; border-radius: 10px 10px;">
                    <div class="modal-header">
     
                    <h3 style="" ><?= (e($event->event_name))?> Dashboard</h3>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body">
                  
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body">
                        <!----Presentation de l'admin---->
                     <div class="row" style="border-bottom: solid 1px #DDDDDD;">
                      <div class="col-md-3">
                    <img src="<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>" class="rounded-circle" width="40" style="height: 50px; width: 50px; border:1.5px solid #f5f6fa;" >
                      </div>
                      <div class="col-md-8">
                         <small>Admin</small><br>
                         <h5 style="color: #44717C;"><?= e($user->name) ?></h5>
                      </div>
                     </div>
                        <!----Presentation de l'admin fin---->
          <br>         
          <ul class="list-group">
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-2" data-toggle="detail-2">
                    <div class="col-xs-10">
                        <i class="fa fa-bell"></i> <span class="badge" style="background-color: #FF0000; color: white;"><?= event_notifications_count($event->id)?></span> Notification<?= event_notifications_count($event->id) <=1 ? '' : 's'?></a>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                 <div class="row toggle" id="dropdown-detail-3" data-toggle="detail-3">
                    <div class="col-xs-10">
                        <i class="fas fa-cog"></i> Parameters
                    </div>
                </div>
            </li>
             <li class="list-group-item">
                 <div class="row toggle">
                    <div class="col-xs-10">
                        <i class="fas fa-chart-line"></i> <a href="event_dashboard.php?ev_i=<?= $event->id ?>" style="text-decoration:none; color:#495057;">Plus des details</a>
                    </div>
                </div>
            </li>
        </ul><br>
       <!--  <div class="text-center">
          <a href="forumcontent.php?name=<?= get_session('fr_n') ?>" class="btn btn-outline-primary"><i class="far fa-images"></i> Manage contents</a>
        </div>  -->               
                         <!----Liste fin ---->
                      </div>
                      
                    </div>
                    
                  </div>
                  <div class="col-lg-8">
                     <div class="card" style="width: 640px;">
                      <div class="card-body">
                      <div class="defaultContent text-center">
                        <h6 style="">Invite friends to join this event</h6>
                      </div>
                      <div id="relativesList" style="height:200px; overflow-y:auto;">
                      
                      </div>
                      <div class="text-center">
                      <br><a href="" class="request_all">Invite all my friends(<?= friends_count_wparameter(get_session('user_id'))?>) to join</a> <small class="text-primary" style="display:none;" id="loading_message" > Sending in progress...</small>
                      </div>

                    <div id="detail-3">
                    <hr></hr>
                    <div class="container">
                        <div class="fluid-row">
                            <div class="col-xs-1">
                                <h6 style="color: #44717C;" >About this page</h6>
                            </div>
                            <div class="col-xs-5">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="">
                                        <label for="place_name">Event name <span class="text-primary">*</span></label>
                                        <input type="text" class="form-control" placeholder="Event name" id="event_name" name="event_name" value="<?= get_input('event_name') ? get_input('event_name') : e($event->event_name)?>" 
                              required="require"/>
                                    </div> 
                                  </div>
                                </div>
                                   <div class="form-group">
                                   <label for="description">Event description :<span class="text-primary">*</span></label>
                                   <textarea name="description" id="description" cols="75" rows="02" class="form-control"
                                   placeholder="Short description" value="<?= nl2br(replace_links(e($event->event_description))) ?>"><?= get_input('event_description') ? get_input('event_description') :e($event->event_description)?></textarea>
                                   
                                   </div>
                                    <div class="text-center">
                            <small class="text-success" id="AboutConfMessage" style="display:none;">Informations updated successfully</small><br>
                            <a><input type="button" class="btn btn-outline-success updateEventInfo" value="Sauvegarder" name="insert"/></a>
                                    </div>          
                            </div>
                        </div>
                    </div>
                </div>
                
                 <div id="detail-2">
                    <div class="container" style="height:200px; overflow-y:auto;">
                        <div class="fluid-row">
                            <div class="col-xs-1">
                            <br>
                                <h5><?= event_notifications_count($event->id)?> Notification<?= event_notifications_count($event->id) <= 1 ? '' : 's'?></h5>
                                <?php $notifications = event_notifications_displayer($event->id); ?>
                                 <?php if(count($notifications) !=0): ?>
                            <?php foreach ($notifications as $notification): ?>
                                <!-- Debut de l'affichage des notifications-->
                                <?php $userfirstname=get_user_name($notification->poster_id);
                                      $userlastname=get_user_second_name($notification->poster_id); ?>
                                <div class="card">
                                  <div class="card-body">
                                   <div class="row">
                                    <?php $user_profile=place_followerspic_displayer($notification->poster_id);
                                          ?>
                             <?php if($notification->content="you have 1 follower"): ?>
                              <div class="col-md-3">
                                     <img src="<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" > 
                                     </div>
                                     <div class="col-md-9" style="border-left: solid 1px #DDDDDD;">
                                       Starting followed you<br>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $notification->posted_at ?>"><?= $notification->posted_at ?></span>
                                     </div>
                                     <?php else: ?>
                                      <p>Something else...</p>
                                   <?php endif; ?>
                                   
                                   </div> 
                                  </div>
                                  
                                </div>
                                <!-- Fin de l'affichage des notifications-->
                             <?php endforeach; ?>
                             <?php else: ?>
                              <div class="text-center">
                                 <p>Oups no notifications for now :(...</p>
                              </div>
                      <?php endif; ?>
                      <?php if(event_notifications_count($event->id) > 0): ?>
                        <a href="event_notifications_off.php?ev_i=<?= $event->id ?>" style="color: #44717C;">Mark as read<?= event_notifications_count($event->id) ==1 ? '' : 's'?></a>
                      <?php endif; ?>  
                            </div>
                        </div>
                    </div>
                </div>
                
                      </div>
                      
                    </div>
                    
                  </div>
                  
                </div>
                </div>
                
                <!-- <div class="modal-footer">
                                
                </div>  -->
                    
                </div>
            </div>
        </div>