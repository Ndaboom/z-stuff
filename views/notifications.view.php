<?php $title = "Notifications"; ?>
<?php 
      include('partials/_header.php');
      require 'includes/event_functions.php';

       ?>

<link rel="stylesheet" type="text/css" href="assets/css/notification/main.css">
<body style="margin-top: 80px;">
         <div id="main-content" >
         <div class="container">
         <div class="card">
          <div class="card-body">
             <p><b>COVID-19</b><br>
         Find all updates on COVID-19, provided by <b>WHO</b><br>
         <a href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019/situation-reports/" target="_blank" class="btn btn-info btn-xs" style="color:white;"><i class="fas fa-info-circle"></i> see more</a><br>
          </div>
         </div>
         <?php if(count($notifications) !=0): ?>
         <?php foreach($notifications as $notification): ?>
        <?php $user_profile=place_followerspic_displayer($notification->user_id);
              $first_name=get_user_name($notification->user_id);
              $second_name=get_user_second_name($notification->user_id);

               if($notification == 0){
                  $style='style="background-color: #e9ebee;"';
              }
              else
              {
                 $style = '';
              }
        ?>
        <?php if($notification->name=="friend_request_accepted"): ?>
            <div class="card" <?= $style ?>>
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                            <div class="col-md-2">
                             <a href="profile.php?id=<?= $notification->user_id ?>">
            <img src= "/<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>" alt="profile image"
            class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
            </a>
                            </div>
                            <div class="col-md-10">
            <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
           accepted your request for friendship <span><?= zungvi_time_ago($notification->created_at) ?></span>.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

         <?php elseif($notification->name=="friend_request_sent"): ?>
            <div class="card" id="requestCard<?= $notification->user_id ?>" <?= $style ?>>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
             <a href="profile.php?id=<?= $notification->user_id ?>">
             <img src= "/<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>" alt="profile image"
            class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;">
           </a>
                        </div>
                        <div class="col-md-10">
                        <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
                         sent you a friend request <span><?= zungvi_time_ago($notification->created_at) ?></span>.</br>
              <?php if(!already_friends_min($notification->user_id,get_session('user_id'))): ?>
                <button type="button" name="request_validator" class="btn btn-outline-primary accept_friends" id="request_button<?= $notification->user_id ?>" data-user_id="<?= $notification->user_id ?>">Accept</button>
             <a class="btn btn-outline-danger" href="delete_friend.php?id=<?= $notification->user_id?>&n_i=<?= $notification->id ?>" id="denied<?= $notification->user_id ?>">Refuse</a>
             <h5 style="display:none;" id="confirmation<?= $notification->user_id  ?>"><small class="text-success"><b>The friendship request has been accepted</b></small></h5>
             <?php else: ?>
              <h5><small class="text-success"><b>The friendship request has been accepted</b></small></h5>
             <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($notification->name=="newOrders"): ?>
             <?php include('partials/order_admin_modal.php'); ?>
            <div class="card" <?= $style ?>>
                <div class="card-body" data-toggle="modal" data-target="#orderModal">
                <div class="row">
                 <div class="col-md-2">
                 <h3 class="text-success"><i class="fas fa-shopping-basket"></i></div>
                 <div class="col-md-10">
                 </h3> You have received new orders!
                 </div>
                 </div>
                 <span><?= zungvi_time_ago($notification->created_at) ?></span>
                </div>
            </div>

         <?php elseif($notification->name == "mutoo_notif"): ?>
         <div class="card">
         <div class="card-body text-center">

               <span>New song <b>"Utilise-moi"</b> by Daniel Mutoo!</span><br>
               <iframe width="560" height="315" src="https://www.youtube.com/embed/8fnhfKw0km4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

         </div>
         </div>
        <?php elseif($notification->name == "covid_notif"): ?>
        <div class="card">
         <div class="card-body">
         <div class="row">
         <div class="col-md-2">
         <img src= "Pub/oms.jpg" alt="OMS image"
            class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
         </div>
         <div class="col-md-10">
         <p><b>COVID-19</b><br>
         Find all updates on COVID-19, provided by <b>WHO</b><br>
         <a class="btn btn-info btn-xs" onclick="collapseCOVIDINFO();" style="color:white;"><i class="fas fa-info-circle"></i> see more</a><br>
         <small onclick="collapseENVERSION();">English translation</small>
         </p>
         <div id="moreCinfos" style="display:none;">

         <div id="french_version" style="display:none;">
                         <h4>Qu’est-ce qu’un coronavirus ?</h4>
                <p>Les coronavirus forment une vaste famille de virus qui peuvent être pathogènes chez l’homme et chez l’animal. On sait que, chez l’être humain, plusieurs coronavirus peuvent entraîner des infections respiratoires dont les manifestations vont du simple rhume à des maladies plus graves comme le syndrome respiratoire du Moyen-Orient (MERS) et le syndrome respiratoire aigu sévère (SRAS). Le dernier coronavirus qui a été découvert est responsable de la maladie à coronavirus 2019 (COVID-19).</p>
                         <h4>Qu’est-ce que la COVID-19 ?</h4>
                <p>La COVID-19 est la maladie infectieuse causée par le dernier coronavirus qui a été découvert. Ce nouveau virus et cette maladie étaient inconnus avant l’apparition de la flambée à Wuhan (Chine) en décembre 2019. </p>
                         <h4>Quels sont les symptômes de la COVID-19 ?</h4>
                <p>Les symptômes les plus courants de la COVID-19 sont la fièvre, la fatigue et une toux sèche. Certains patients présentent des douleurs, une congestion nasale, un écoulement nasal, des maux de gorge ou une diarrhée. Ces symptômes sont généralement bénins et apparaissent de manière progressive. Certaines personnes, bien qu’infectées, ne présentent aucun symptôme et se sentent bien. La plupart (environ 80 %) des personnes guérissent sans avoir besoin de traitement particulier. Environ une personne sur six contractant la maladie présente des symptômes plus graves, notamment une dyspnée. Les personnes âgées et celles qui ont d’autres problèmes de santé (hypertension artérielle, problèmes cardiaques ou diabète) ont plus de risques de présenter des symptômes graves. Toute personne qui a de la fièvre, qui tousse et qui a des difficultés à respirer doit consulter un médecin.</p>
                         <h4>Comment la COVID-19 se propage-t-elle ?</h4>
                <p>La COVID-19 est transmise par des personnes porteuses du virus. La maladie peut se transmettre d’une personne à l’autre par le biais de gouttelettes respiratoires expulsées par le nez ou par la bouche lorsqu’une personne tousse ou éternue. Ces gouttelettes peuvent se retrouver sur des objets ou des surfaces autour de la personne en question. On peut alors contracter la COVID-19 si on touche ces objets ou ces surfaces et si on se touche ensuite les yeux, le nez ou la bouche. Il est également possible de contracter la COVID-19 en inhalant des gouttelettes d’une personne malade qui vient de tousser ou d’éternuer. C’est pourquoi il est important de se tenir à plus d’un mètre d’une personne malade.

                L’OMS examine les travaux de recherche en cours sur la manière dont la COVID-19 se propage et elle continuera à communiquer les résultats actualisés.</p>
                         <h4>Quelle est la probabilité de contracter la COVID-19 ?</h4>
                <p>Le risque dépend de l’endroit où vous habitez et, plus précisément, de la présence ou non d’une flambée.

                Pour la plupart des gens, à la plupart des endroits, le risque de contracter la COVID-19 reste faible. Cependant, la propagation d’intensifie désormais dans certaines villes ou régions. Pour les personnes qui y habitent ou s’y rendent, le risque de contracter la COVID-19 est plus élevé. Les gouvernements et les autorités sanitaires prennent des mesures énergiques chaque fois qu’un nouveau cas de COVID-19 est identifié. Respectez les restrictions locales aux voyages, aux déplacements ou aux grands rassemblements. En participant à ces efforts de lutte contre la maladie, vous réduisez le risque de contracter ou de propager la COVID-19.

                Les flambées de COVID-19 peuvent être endiguées et la transmission peut être enrayée, comme on l’a vu en Chine et dans certains autres pays. Malheureusement, de nouvelles flambées apparaissent rapidement. Il est important de connaître la situation là où vous êtes ou là où vous comptez aller. L’OMS publie quotidiennement des bulletins de situation. Vous pouvez les consulter à l’adresse <?= replace_links("https://www.who.int/emergencies/diseases/novel-coronavirus-2019/situation-reports/") ?> .</p>
         </div>
         <div id="english_version" style="display:none;">
                             <h4> What is a coronavirus? </h4>
                    <p> Coronaviruses are a large family of viruses that can be pathogenic in humans and animals. It is known that in humans, several coronaviruses can cause respiratory infections ranging from the common cold to more serious illnesses such as Middle East Respiratory Syndrome (MERS) and Severe Acute Respiratory Syndrome (SARS). The last coronavirus that was discovered is responsible for coronavirus disease 2019 (COVID-19). </p>
                             <h4> What is COVID-19? </h4>
                    <p> COVID-19 is the infectious disease caused by the last coronavirus that was discovered. This new virus and disease were unknown before the outbreak in Wuhan, China, in December 2019. </p>
                             <h4> What are the symptoms of COVID-19? </h4>
                    The most common symptoms of COVID-19 are fever, fatigue, and a dry cough. Some patients experience pain, nasal congestion, runny nose, sore throat or diarrhea. These symptoms are generally mild and appear gradually. Some people, although infected, have no symptoms and feel good. Most (around 80%) people recover without needing any special treatment. About one in six people with the disease have more severe symptoms, including dyspnea. Seniors and those with other health conditions (high blood pressure, heart problems or diabetes) are more likely to have severe symptoms. Anyone who has a fever, coughs, and has trouble breathing should see a doctor. </p>
                    <h4> How is COVID-19 spread? </h4>
                    <p> COVID-19 is transmitted by people with the virus. The disease can be spread from person to person through respiratory droplets expelled from the nose or mouth when a person coughs or sneezes. These droplets can be found on objects or surfaces around the person in question. COVID-19 can then be contracted if you touch these objects or surfaces and then touch your eyes, nose or mouth. COVID-19 can also be acquired by inhaling droplets from a sick person who has just coughed or sneezed. That’s why it’s important to stay more than a meter away from a sick person.

                    WHO is reviewing the ongoing research on how COVID-19 is spread and will continue to communicate the updated results. </p>
                    <h4> What is the probability of contracting COVID-19? </h4>
                    <p> The risk depends on where you live and, more specifically, whether or not an outbreak has occurred.

                    For most people, in most places, the risk of getting COVID-19 remains low. However, the spread is now intensifying in some cities or regions. For people who live or go there, the risk of getting COVID-19 is higher. Governments and health authorities are taking strong action whenever a new case of COVID-19 is identified. Observe local restrictions on travel, traveling, or large gatherings. By participating in these disease control efforts, you reduce the risk of contracting or spreading COVID-19.

                    COVID-19 outbreaks can be contained and transmission can be stopped, as seen in China and some other countries. Unfortunately, new outbreaks appear quickly. It is important to know the situation where you are or where you plan to go. WHO publishes situation bulletins daily. You can view them at <?= replace_links("https://www.who.int/emergencies/diseases/novel-coronavirus-2019/situation-reports/") ?>. </p>
         </div>
         </div>
         </div>
         </div>
         </div>
         </div>
        <?php elseif ($notification->name == "relatives_suggestion"): ?>
            <?php $relatives = find_user_by_id($notification->user_id); ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                        <a href="profile.php?id=<?= $relatives->id ?>"><img src= "<?= $relatives->profilepic ?>"  alt="<?= e($relatives->name) ?> profile picture" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
                        </div>
                        <div class="col-md-10">
        <p>It looks like you may know <b><?= $relatives->name ?> <?= $relatives->nom2 ?></b><br>
        <?php if($relatives->city && $relatives->country): ?>
        <b>From :</b> <?= $relatives->city ?> , <?= $relatives->country ?><br>
        <?php endif; ?>
        <?php if($relatives->profession): ?>
        <b class="text-info text-center"><?= $relatives->profession ?></b><br>
        <?php endif; ?>
        <?php if(!already_friends_min($relatives->id,get_session('user_id'))): ?>
        <a class="btn btn-info btn-xs suggestion_button" style="color: white; margin-left: 165px;" id="suggestion_box<?= $notification->id ?>" data-relative_id="<?= $relatives->id ?>" data-notification_id = "<?= $notification->id ?>"><i class="fas fa-user-plus"></i> friends</a>
        <?php endif; ?>
        <small style="margin-left: 165px; display: none;" id="relatives_conf_sent<?= $notification->id ?>" class="text-success">Request sent</small>
        </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($notification->name == "shared_your_post"): ?>
          <?php $user_profile = find_user_by_id($notification->user_id); ?>
          <div class="card">
              <div class="card-body">
              <div class="row">
             <div class="col-md-2">
                  <a href="profile.php?id=<?= $notification->user_id ?>"><img src="/<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
              </div>
              <div class="col-md-10" style="border-left: solid 1px #DDDDDD;">
                  <p>Shared your <a href="postviewer.php?p_i=<?= $notification->post_id ?>"><b class="text-primary"> post</b></a></p>
                  <i class="fa fa-globe" aria-hidden="true"></i> <span><?= zungvi_time_ago($notification->created_at) ?></span>
              </div>
              </div>
              </div>
          </div>
        <?php elseif($notification->type=="A commence a suivre votre place "): ?>
        <?php $user_profile=place_followerspic_displayer($notification->user_id);
              $place=selectPlaceDataById2($notification->place_id); ?>
        <div class="card" <?= $style ?>>
            <div class="card-body">
            <div class="row">
           <div class="col-md-2">
                <a href="profile.php?id=<?= $notification->user_id ?>"><img src="/<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
            </div>
            <div class="col-md-10" style="border-left: solid 1px #DDDDDD;">
                <h6>Started following <a href="homeplace.php?pl_i=<?= $place->id ?>"><b class="text-primary"><?= $place->place_name ?></b></a></h6>
                <i class="fa fa-globe" aria-hidden="true"></i> <span><?= zungvi_time_ago($notification->created_at) ?></span>
            </div>
            </div>
            </div>
        </div>

        <?php elseif($notification->type == "A commence a suivre votre activite"): ?>

          <?php $event = find_event_by_id($notification->event_id); ?>
          <div class="card">
            <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-2">
                        <a href="profile.php?id=<?=$notification->user_id?>">
                        <img src= "<?= $user_profile->profilepic?>" alt="profile image"
              class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
              </a>
                              </div>
                              <div class="col-md-10">
              <a href="profile.php?id=<?= $notification->user_id?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
              started following <a href="homeevent.php?ev_i=<?= $event->id ?>"><?= $event->event_name ?></a><span> <?= zungvi_time_ago($notification->created_at) ?></span>
                              </div>
                          </div>
                      </div>
                  </div>

          </div>

            <?php elseif($notification->name=="viewed_your_profile"): ?>
            <div class="card" <?= $style ?>>
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-2">
                                            <i class="fas fa-users"></i>
                                            </div>
                                        <div class="col-md-10">
                                          People viewed your profile <a href="zpeople.php"><b>Make you more friends</b></a><br>
                                          <span><?= zungvi_time_ago($notification->created_at) ?></span>
                                         </div>

                                      </div>
                                    </div>
                                </div>

         <?php elseif($notification->type=="A commence a suivre votre place"): ?>
            <div class="card" id="requestCard<?= $notification->user_id ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                           <a href="profile.php?id=<?= $notification->user_id ?>">
                             <img src= "/<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>" alt="profile image"
                            class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;">
                           </a>
                        </div>
                        <div class="col-md-10">
                        <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
                         started following your place <span><?= zungvi_time_ago($notification->created_at) ?></span>.</br></br>
                        </div>
                    </div>
                </div>
            </div>

         <?php elseif($notification->name=="forum request accepted"): ?>
            <?php  $fpic=get_forum_pic($notification->forum_id);
                   $fname=get_forum_name($notification->forum_id); ?>
            <div class="card" <?= $style ?>>
                                    <div class="card-body">
                                      <div class="row">
                                         <div class="col-md-2" style="border-right: solid 1px #DDDDDD;">
                                            <a href="homeforum.php?name=<?= e($fname->forum_name) ?>"> <img src= "<?= e($src =($fpic->forum_pic != null) ? $fpic->forum_pic : 'images/portada_7.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" width="150"></a>

                                        </div>
                                            <div class="col-md-10">
                                          Your request to join the forum <a href="homeforum.php?name=<?= e($fname->forum_name) ?>"><b><?= e($fname->forum_name) ?></b></a> was accepted<br>
                                          <span><?= zungvi_time_ago($notification->created_at) ?></span>
                                         </div>

                                      </div>
                                    </div>
                                </div>
         <?php elseif($notification->name=="join_forum_request"): ?>
            <?php  $userpic=selectUserProfilePic($notification->user_id);
                   $fname=get_forum_name($notification->forum_id); ?>
            <div class="card" <?= $style ?>>
                                    <div class="card-body">
                                      <div class="row">
                                         <div class="col-md-2" style="border-right: solid 1px #DDDDDD;">
                                            <a href="profile.php?id=<?= e($notification->user_id) ?>"> <img src= "/<?= $userpic->profilepic ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" width="150"></a>

                                        </div>
                                            <div class="col-md-10">
                                          <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
                                          request to join your forum <a href="homeforum.php?name=<?= e($fname->forum_name) ?>"><b><?= e($fname->forum_name) ?></b></a><br>
                                          <span><?= zungvi_time_ago($notification->created_at) ?></span>
                                          <div id="request<?= $notification->forum_id ?>">
                                            <?php if(!is_him_in($notification->user_id,$notification->forum_id)): ?>
                                            <button class="btn btn-outline-success accept" data-user_id="<?= $notification->user_id ?>" data-forum_id="<?= $notification->forum_id ?>">Accept</button>
                                            <button class="btn btn-outline-warning">Refuse</button>
                                          <?php endif; ?>
                                          </div>
                                         </div>

                                      </div>
                                    </div>
                                </div>
           <?php elseif($notification->type=="Invite you to join this event"):  ?>
              <?php 
              $user_info = find_user_by_id($notification->user_id);
              $event = find_event_by_id($notification->event_id);
              ?>

             <div class="card" id="notification<?= $notification->id ?>'">
                                  <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-2" style="border-right: solid 1px #DDDDDD;">
                                          <a href="profile.php?id=<?= e($notification->user_id)?>"> <img src= "/<?= $user_info->profilepic?>"   alt="image" class="img-thumbnail" width="150"></a>

                                      </div>
                                       <div class="col-md-10">
                                        <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $user_info->name ?> <?= $user_info->nom2 ?></b></a>
                                        invite you to follow <a href="homeevent.php?ev_i=<?= e($notification->event_id) ?>"><b> <?= e($event->event_name) ?></b></a><br>
                                        <span><?= zungvi_time_ago($notification->created_at) ?></span>
                                        <div id="request<?= $notification->event_id ?>">
                                       <?php  if(!an_event_has_already_been_followed($notitication->event_id, $notification->subject_id)): ?>
                                        <button class="btn btn-outline-success follow_event" data-user_id="<?= $notification->user_id ?>" 
                     data-event_id="<?= $notification->event_id ?>" data-event_name="<?= $event->event_name ?>" data-notification_id="<?= $notification->id ?>"> Follow</button>
                                   <button class="btn btn-outline-warning ignore_event" data-notification_id="<?= $notification->id ?>">Ignore</button>
                                       <?php else: ?>
                                        You are already following this activity
                                       <?php endif; ?>
                                        </div>
                                       </div>

                                    </div>
                                </div>
                  </div>
                  <div class="card" id="event_success_card<?= $notification->id ?>" style="display:none;">
                     <div class="card-body text-center">
                        <small class="text-success"><i class="far fa-check-circle"></i> You are now following this event, Sessions start soon...</small>
                     </div>
                  </div>

                  <div class="card" id="event_ignored_card<?= $notification->id ?>" style="display:none;">
                     <div class="card-body text-center">
                        <h5 class="text-warning"><i class="far fa-check-circle"></i> Invitation ignored ...</h5><a href="notifications.php"> Refresh notifications</a>
                     </div>
                  </div>

           <?php elseif($notification->name=="viewed_your_profile"): ?>
            <div class="card" <?= $style ?>>
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-2"><h3 class="text-primary"><i class="fas fa-users"></i></h3></div>
                                        <div class="col-md-10">
                                          People viewed your profile <a href="zpeople.php"><b>Make you more friends</b></a><br>
                                          <span><?= zungvi_time_ago($notification->created_at) ?></span>
                                         </div>

                                      </div>
                                    </div>
                                </div>

         <?php elseif($notification->name=="liked_post"): ?>
            <?php $row=get_post_data($notification->post_id) ?>
            <div class="card" <?= $style ?>>
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                            <div class="col-md-2">
                             <a href="profile.php?id=<?= $notification->user_id ?>">
            <img src= "/<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>" alt="profile image"
            class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
            </a>
                            </div>
                            <div class="col-md-8">
            <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
            liked your post <span><?= zungvi_time_ago($notification->created_at) ?></span>.
                            </div>
                            <div class="col-md-2" data-toggle="modal" data-target="#monModal<?= $notification->post_id ?>">
                                <?php if($row->urlMedia != null && $row->type == ""): ?>
                                <img src="<?= $row->urlMedia ?>" class="img-thumbnail img-responsive" >
                            <?php endif; ?>
                                <p><?= $row->legend ?></p>
                                <div class="text-center">
                                  <?= likers_updater($row->id,$db) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--- Modal  --->
              <div class="modal fade" id="monModal<?= $notification->post_id ?>">

            <div class="modal-dialog" >

                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" >posted <span><?= zungvi_time_ago($row->created_at) ?></span></div>
                        <button type="button" class="close" data-dismiss="modal"></button>

                    </div>

                <div class="modal-body">
                    <?php if($row->urlMedia != null && $row->type == ""): ?>
                                <img src="/<?= $row->urlMedia ?>" class="img-thumbnail img-responsive" >
                            <?php endif; ?>
                                <p><?= $row->legend ?></p>
                                <a href="postviewer.php?p_i=<?= $row->id?>"><div class="text-center">
                                  <?= likers_updater($row->id,$db) ?>
                                </div></a>
                </div>
                </div>
            </div>
        </div>
         <?php elseif($notification->name=="has_commented"): ?>
            <?php $row=get_post_data($notification->post_id) ?>
            <div class="card" <?= $style ?>>
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                            <div class="col-md-2">
                             <a href="profile.php?id=<?= $notification->user_id ?>">
            <img src= "/<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>" alt="profile image"
            class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
            </a>
                            </div>
                            <div class="col-md-7">
            <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
            commented on your post <span><?= zungvi_time_ago($notification->created_at) ?></span>.
                            </div>
                            <div class="col-md-3" data-toggle="modal" data-target="#monModal<?= $notification->post_id ?>">
                                <p><?= $notification->type ?></p>
                                <div class="text-center">
                                  <?= likers_updater($row->id,$db) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php elseif($notification->name=="comment_liked"): ?>
            <?php $row=get_post_data($notification->post_id) ?>
            <div class="card" <?= $style ?>>
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                            <div class="col-md-2">
                             <a href="profile.php?id=<?= $notification->user_id ?>">
            <img src= "/<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>" alt="profile image"
            class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
            </a>
                            </div>
                            <div class="col-md-8">
            <a href="profile.php?id=<?= $notification->user_id ?>"><b><?= $first_name->name ?> <?= $second_name->nom2 ?></b></a>
            liked your comment <span><?= zungvi_time_ago($notification->created_at) ?></span>.
                            </div>
                            <div class="col-md-2">
                                <p><?= $notification->type ?></p>
                                <a href="postviewer.php?p_i=<?= $row->id?>"><div class="text-center">
                                  <?= likers_updater($row->id,$db) ?>
                                </div></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
          <?php elseif($notification->type == "post_liked"): ?>
                                      <?php $row=fetch_place_post_data($notification->post_id);  ?>
                                      <div class="card" <?= $style ?>>
                                        <div class="card-body">
                                          <div class="row">
                                        <div class="col-md-2">
                                           <img src="/<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
                                       </div>
                                       <div class="col-md-7" style="border-left: solid 1px #DDDDDD;">
                                       liked your post<br>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span><?= zungvi_time_ago($notification->created_at) ?></span>
                                      </div>

                                      <div class="col-md-3">
                                      <a href="homeplace.php?pl_i=<?= $notification->place_id ?>#card<?= $notification->post_id ?>"><img src="<?= $row->urlMedia ?>" class="img-thumbnail" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
                                      </div>
                                          </div>
                                        </div>
                                      </div>
           <?php elseif($notification->type == "has_commented"): ?>
                                      <?php $row=fetch_place_post_data($notification->post_id);  ?>
                                      <div class="card" <?= $style ?>>
                                        <div class="card-body">
                                          <div class="row">
                                            <div class="col-md-2">
                                           <img src="/<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
                                       </div>
                                       <div class="col-md-7" style="border-left: solid 1px #DDDDDD;">
                                       has commented your post<br>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span><?= zungvi_time_ago($notification->created_at) ?></span>
                                      </div>

                                      <div class="col-md-3">
                                      <a href="homeplace.php?pl_i=<?= $notification->place_id ?>#card<?= $notification->post_id ?>"><img src="<?= $row->urlMedia ?>" class="img-thumbnail" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
                                      </div>
                                          </div>
                                        </div>
                                      </div>
          <?php elseif($notification->type == "place_admin_has_commented"): ?>
                                      <?php $row=fetch_place_post_data($notification->post_id);  ?>
                                      <div class="card" <?= $style ?>>
                                        <div class="card-body">
                                          <div class="row">
                                            <div class="col-md-2">
                                           <img src="/<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
                                       </div>
                                       <div class="col-md-7" style="border-left: solid 1px #DDDDDD;">
                                       has also commented his post<br>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span><?= zungvi_time_ago($notification->created_at)?></span>
                                      </div>

                                      <div class="col-md-3">
                                      <a href="homeplace.php?pl_i=<?= $notification->place_id ?>#card<?= $notification->post_id ?>"><img src="<?= $row->urlMedia ?>" class="img-thumbnail" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
                                      </div>
                                          </div>
                                        </div>
                                      </div>
         <?php endif; ?>

         <?php endforeach; ?>
         <?php else: ?>
          No notification available for now ...
         <?php endif; ?>
         <div id="pagination"><?= $pagination ?></div>
         </div>

         </div>
</body>
<!-- SCRIPTS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.timeago.js"></script>
<script src="assets/js/jquery.timeago.en.js"></script>
 <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="js/notifications.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".timeago").timeago();
        fetch_incomming_msg();

         setInterval(function(){
           fetch_incomming_msg();
        },5000);

         function fetch_incomming_msg()
        {
          $.ajax({
            url:"ajax/fetch_incomming_msg.php",
            method:"POST",
            success:function(data)
            {
              $('#message').html(data);
            }
          })
        }

        $(document).on('click', '.accept', function(){
           var user_id = $(this).data('user_id');
           var forum_id = $(this).data('forum_id');
           $.ajax({
            url:'ajax/valide_forum_request.php',
            method:"POST",
            data:{user_id:user_id,forum_id:forum_id},
            success:function(data)
            {
             $("#request"+forum_id).hide();
            }
           })
        });

        $(document).on('click', '.action_button', function(){
           var customer_id = $(this).data('customer');
           var order_id = $(this).data('order');
           var chat_message= $('#'+order_id).val();
            if (chat_message.length > 0) {
              alert(chat_message);
              alert(customer_id);
              $.ajax({
            url:'ajax/responser.php',
            method:"POST",
            data:{customer_id:customer_id,chat_message:chat_message,order_id:order_id},
            success:function(data)
            {
             alert(data);
             $('#chat_box').hide();
             $('#acknolegment').show();
            }
           });
              }
        });

         $(document).on('click', '.accept_friends', function(e){
           var user_id = $(this).data('user_id');
           var action = 'accept_friends_request';
           $("#request_button"+user_id).hide();
           $("#denied"+user_id).hide();
           $.ajax({
            url:'action.php',
            method:"POST",
            data:{user_id:user_id,action:action},
            success:function(data)
            {
            $("#confirmation"+user_id).show();
            }
           })
        });

        var url ='ajax/search.php';
        $('input#searchbox').on('keyup', function(){
            var query = $(this).val();
        if (query.length > 2) {
          $.ajax({
                type:'POST',
                url:url,
                data: {
                       query: query
                      },
                beforeSend: function(){
                    $("#spinner").show();
                },
                success: function(data){
                   $("#spinner").hide();
                   $("#display-results ").html(data).show();

                }

            });
        }else{
            $("#display-results ").hide();
        }

    });

    });


</script>
</html>
