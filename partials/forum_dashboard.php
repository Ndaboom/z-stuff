        <div class="modal fade" id="forumdashboard">
            <div class="modal-dialog modal-lg" >

                <div class="modal-content" style="background-color: #e9ebee; width:1000px; border-radius: 10px 10px;">
                    <div class="modal-header">

                    <h3 style="color: #44717C;" ><?= (e($forum->forum_name))?> Dashboard</h3>
                        <button type="button" class="close" data-dismiss="modal">X</button>

                    </div>

                <div class="modal-body" >

                <div class="row">
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body">
                        <!----Presentation de l'admin---->
                        <div class="welcomeWord text-center">
                          <h4 style="font-style: italic;">Welcome!!!</h4>
                        </div>
                     <div class="row" style="border-bottom: solid 1px #DDDDDD;">
                      <div class="col-md-3">
                    <img src="<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>" class="rounded-circle" width="40" style="height: 50px; width: 50px; border:1.5px solid #f5f6fa;" >
                      </div>
                      <div class="col-md-8">
                         <h5 style="color: #44717C;"><?= e($user->name) ?></h5>
                      </div>
                     </div>
                        <!----Presentation de l'admin fin---->
          <br>
          <ul class="list-group">
           <!--  <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                    <div class="col-xs-10">
                       <i class="fas fa-home"></i> Home
                    </div>
                </div>
            </li> -->
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-2" data-toggle="detail-2">
                    <div class="col-xs-10">
                        <i class="fa fa-bell"></i> <span class="badge" style="background-color: #FF0000; color: white;"><?= forum_notifications_count(get_session('fr_i'))?></span> Notification<?= forum_notifications_count(get_session('fr_i')) <=1 ? '' : 's'?></a>
                    </div>
                </div>
            </li>
             <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-4" data-toggle="detail-4">
                    <div class="col-xs-10">
                        <i class="fas fa-lock"></i> Confidentialite
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                 <div class="row toggle" id="dropdown-detail-3" data-toggle="detail-3">
                    <div class="col-xs-10">
                        <i class="fas fa-cog"></i> Parametres
                    </div>
                </div>
            </li>
        </ul><br>
        <div class="text-center">
          <a href="forumcontent.php?name=<?= get_session('fr_n') ?>" class="btn btn-outline-primary"><i class="far fa-images"></i> Gerer les contenus du forum</a>
        </div>
                         <!----Liste fin ---->
                      </div>

                    </div>

                  </div>
                  <div class="col-lg-8">
                     <div class="card" style="width: 640px;">
                      <div class="card-body">
                      <div class="defaultContent text-center">
                        <h6 style="color: #44717C;" >Invite friends to join</h6>
                      <div id="relativesList" style="height:200px; overflow-y:auto;">

                      </div>
                      <div  class="text-center">
                        <i class="fas fa-spinner fa-spin" style="display: none; color: blue; margin-top: 10px;" id="relatives_spinner"></i>
                      </div>
                      </div>

                         <div id="detail-3">
                    <hr></hr>
                    <div class="container">
                        <div class="fluid-row">
                            <div class="col-xs-1">
                                <h6 style="color: #44717C;" >About the forum</h6>
                            </div>
                            <div class="col-xs-5">
                              <form method="post" class ="well" autocomplete="off">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="">
                                        <label for="place_name">Forum name <span class="text-primary">*</span></label>
                                        <input type="text" class="form-control" placeholder="Nom du forum" id="forum_name" name="forum_name" value="<?= get_input('forum_name') ? get_input('forum_name') : e($forum->forum_name)?>"
                              required="require"/>
                                    </div>
                                  </div>
                                </div>
                                   <div class="form-group">
                                   <label for="description">About the forum :<span class="text-primary">*</span></label>
                                   <textarea name="description" id="description" cols="75" rows="02" class="form-control"
                                   placeholder="entrer une petite description" value="<?= nl2br(replace_links(e($forum->description))) ?>"><?= get_input('description') ? get_input('description') :e($forum->description)?>
                                   </textarea>

                                   </div>
                                    <div class="text-center">
                            <a><input type="submit" class="btn btn-outline-primary" value="Save" name="insert"/></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                         <div id="detail-4">
                    <hr></hr>
                    <div class="container">
                        <div class="card" style="border-bottom:solid 1px #DDDDDD;">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-12">
                              <h5 style="color: #44717C;">Parametres de confidentialite</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <form action="forum_confidentiality.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                               <div class="col-md-6">
                               <div class="form-group mb-0">
                                 <label for="sharing">Partage des contenus du forum<span class="text-primary">*</span></label>
                             <select required="required" name="sharing" id="sharing" class="form-control">
                                         <option value="Activer">
                                         Activer
                                         </option >
                                         <option value="Desactiver">
                                         Desactiver
                                         </option >
                                    </select >
                             </div>
                            </div>
                             <div class="col-md-6">
                              <div class="form-group mb-0">
                            <label for="subjectsVisibility">Visibilite des sujets du groupe<span class="text-primary">*</span></label>
                             <select required="required" name="subjectsVisibility" id="subjectsVisibility" class="form-control">
                                         <option value="private">
                                         Seul les membres du groupe
                                         </option >
                                         <option value="public">
                                         Tout le monde
                                         </option >
                                    </select ><br>
                            </div>
                            </div>

                            </div>
                            <div class="row">
                             <div class="col-md-6">
                              <div class="form-group mb-0">
                            <label for="membersVisibility">Visibilite des membres du groupe<span class="text-primary">*</span></label>
                             <select required="required" name="membersVisibility" id="membersVisibility" class="form-control">
                                         <option value="prive">
                                         Seul les membres du groupe
                                         </option >
                                         <option value="public">
                                         Tout le monde
                                         </option >
                                    </select ><br>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-12 text-center">
                              <button type="submit" name="save_confidentialies" class="btn btn-outline-success btn-xs"> Sauvegarder</button>
                            </div>

                          </form>
                          </div>
                        </div>
                    </div>
                </div>
                 <div id="detail-2">
                    <div class="container">
                        <div class="fluid-row">
                            <div class="col-xs-1">
                                <h5><?= forum_notifications_count(get_session('fr_i'))?> Notification<?= forum_notifications_count(get_session('fr_i')) <=1 ? '' : 's'?></h5>
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
                                    <?php if($notification->type="demande de rejoindre"): ?>
                                     <div class="col-md-3">
                                     <img src="<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
                                     </div>
                                     <div class="col-md-9" style="border-left: solid 1px #DDDDDD;">
                                       <a href=""><?= $userfirstname->name ?> <?=  $userlastname->nom2 ?> </a>
                                       <p><?= $notification->type ?></p>
                                       <div class="row">
                                        <div class="col-md-12">
                                          <?php if(!is_him_in($notification->poster_id,get_session('fr_i'))): ?>
                                        <a href="forum_member_validation.php?m_id=<?= $notification->poster_id ?>" class="btn btn-outline-success">Accepter</a>
                                        <a href="" class="btn btn-outline-warning">Refuser</a>
                                          <?php endif; ?>
                                        </div>
                                       </div>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $notification->posted_at ?>"><?= $notification->posted_at ?></span>
                                     </div>
                                     <?php else: ?>
                                      <p>C'est autre chose...</p>
                                   <?php endif; ?>

                                   </div>
                                  </div>

                                </div>
                                <!-- Fin de l'affichage des notifications-->
                             <?php endforeach; ?>
                             <?php else: ?>
                              <div class="text-center">
                                 <p>Aucune notification disponible pour l'instant...</p>
                              </div>
                      <?php endif; ?>
                        <a href="forum_notification_off.php" style="color: #44717C;">Tout marquer comme lu<?= forum_notifications_count(get_session('fr_i')) ==1 ? '' : 'es'?></a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div id="detail-1">
                    <div class="container">
                        <div class="fluid-row">
                          <div class="row">
                            <div class="card">
                              <div class="card-body">
                                <div class="text-center">
                                   <h6 style="color: #44717C;"><i class="far fa-eye"></i>48</h6>
                                <h6 style="color: #44717C;">Vues</h6>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-body">
                                <h4>Membres</h4>
                              </div>

                            </div>
                            <div class="card">
                              <div class="card-body">
                                <h4>Ranking </h4>
                              </div>

                            </div>



                          </div>

                        </div>
                    </div>
                </div>
                      </div>

                    </div>

                  </div>

                </div>
                </div>

                </div>
            </div>
        </div>
