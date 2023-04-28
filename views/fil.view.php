
<?php
if($notifications_count > 0)
{
  $notifications_nbr = "(".$notifications_count.")";
}else{
  $notifications_nbr = "";
}
 $title= $notifications_nbr." News feed";

 require ('includes/functions.php');
 require('includes/adds_functions.php');
 include('partials/_header.php');
 ?>

<link rel="stylesheet" href="assets/css/channel/style.css">
<body style="margin-top: 60px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                    <div id="best_of_user">

                    </div>

                        <h5 class="text-center">shortcuts</h5>

                      <?php if(count($MeinsideF) !=0): ?>
                            <?php foreach ($MeinsideF as $iamin): ?>
                                <?php $forum_name=get_forum_name($iamin->forum_id) ?>
                                <div class="card">
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-2">
                                            <a href="homeforum.php?name=<?= e($forum_name->forum_name) ?>"> <img src= "<?= e($src =($iamin->forum_pic != null) ? $iamin->forum_pic : 'images/portada_7.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle"style="width:30px; height:30px;" ></a>
                                        </div>
                                         <div class="col-md-8">
                                          <?= e($forum_name->forum_name) ?>
                                         </div>
                                         <?php if( unviewed_post($iamin->forum_id,get_session('user_id')) != 0): ?>
                                         <div class="col-md-2">
                                          <a href=""><span class="badge" style="background-color:  #F3BB00; color: white;"><?= unviewed_post($iamin->forum_id,get_session('user_id'))?></span></a>
                                         </div>
                                         <?php elseif( forum_notifications_count($iamin->forum_id) !=0 && get_session('user_id') == $my_forums->creator_id): ?>
                                         <div class="col-md-2">
                                         <a href=""><span class="badge" style="background-color:  #F3BB00; color: white;"><?= forum_notifications_count($iamin->forum_id)?></span></a>
                                         </div>
                                         <?php else: ?>
                                         <a class="text-warning" ><i class="far fa-envelope"></i> <?= unread_forum_msg($iamin->forum_id,get_session('user_id'))  ?></a>
                                         <?php endif; ?>
                                      </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                     <?php endif; ?>
                      <?php if(count($Places) !=0): ?>
                        <br>
                            <?php foreach ($Places as $place): ?>
                                <?php $place_displayer=selectPlaceDataById($place->place_id);  ?>
                                    <?php if(count($place_displayer) !=0): ?>
                                        <?php foreach ($place_displayer as $display): ?>
                                <div class="card">
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-2">
                                            <a href="homeplace.php?pl_i=<?= e($display->id) ?>"> <img src= "<?= e($src =($display->coverpic != null) ? $display->coverpic : 'images/portada_7.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle"style="width:30px; height:30px;" ></a>

                                        </div>
                                         <div class="col-md-8">
                                          <?= e($display->place_name) ?>
                                         </div>
                                         <div class="col-md-2">
                                          <a href=""><span class="badge" style="background-color:  #F3BB00; color: white;"><?= unviewed_placepost($place->place_id,get_session('user_id')) ?></span></a>
                                         </div>
                                      </div>
                                    </div>
                                </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                     <?php endif; ?>

                </div>
            </div>
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8">
            <?php if(!location_completed(get_session('user_id'))): ?>
                <div class="card my-3 bg-dark text-white card-md" id="location_form1">
                    <img src="/other_images/gomaTown.jpg" class="card-img" alt="..." with="95">
                   <div class="card-img-overlay text-center">
                    <h5 class="card-title text-primary" style="font-family:Arial Black;font-size:20px;font-style:bold; margin-top: 40px;">Hey <?= $user->name ?>,From where are you from. Goma, DRC?</h5>
                       <a class="btn btn-outline-primary btn-md" id="local_suggestion"><img src="<?= $user->profilepic ?>" class="rounded-circle" style="width: 30px;height: 30px;"> Youp!</a>
                       <a class="btn btn-outline-info" id="moreaboutlocalization" > Nope</a>
                    <a class="btn btn-success btn-md" id="conf_localization" style="display: none;"><i class="far fa-check-circle"></i> Saved,Thank you!</a>
                </div>
                </div>

                <div class="card my-3" style="display: none;" id="personalize_location">
                  <div class="card-body">
                    <div class="text-center" style="padding: 2px;">
                      <img src="<?= $user->profilepic ?>" class="rounded-circle"
                      style="width: 60px;height: 60px;" ><br>
                      <i class="fas fa-map-pin"></i><span style="font-size: 18px;font-family:georgia,garamond,serif;"> I'm from </span>
                    </div>
                    <h5 class="card-title text-primary text-center" style="font-family:Arial Black;font-size:20px;font-style:bold; margin-top: 50px; display: none;" id="confirm_localisation_reception"></h5>
                    <div class="row" style="margin-top: 5px; padding: 3px;" id="form_details">
                      <form>
                      <div class="row">
                      <div class="col-md-4">
                      <div class="form-group">
                      <input type="text" name="" class="form-control" placeholder="City" id="city_fields" value="<?= $user->city ?>"></div>
                      </div>
                      <div class="col-md-4">
                      <div class="form-group">
                      <input type="text" name="" class="form-control" placeholder="Country" id="country_fields" value="<?= $user->country ?>">
                      </div>
                      </div>
                      <div class="col-md-4">
                       <input type="submit" name="save_location" value="Save" class="btn btn-outline-primary btn-xs" id="submit_localization" />
                      </div>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
   <?php endif; ?>
   <?php if(!empty($_GET['id']) && $_GET['id'] == get_session('user_id')): ?>
    <a href="mobile/fil.php?id=<?= $_SESSION['user_id'] ?>" class="btn btn-outline-primary mobile_version" style="width:100%; margin-top:10px;"> Version mobile adaptée</a>
                      <div class="card my-3">

                            <div class="card-body py-2">
                                <div class="d-flex">
                                    <div>
                                        <img src= "<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle" style="height: 60px; width: 60px; border:1.5px solid #f5f6fa;" >
                                    </div>
                                    <div class="col">
                                        <form action="microposts.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group mb-0">
                                                <label class="sr-only" for="content">Add a post</label>
                                                <textarea class="form-control border-0" name="content" id="content" placeholder="Hey <?= e($user->name)?>,what's new today?" maxlength="100000" require="require" style="font-style: italic;" ></textarea>
                                            </div>
                                            <div class="form-group mb-0">
                                                <?php include('partials/add_pic_or_video_modal.php');
                                                       ?>
                                            </div>
                                            <img class="img-thumbnail img-responsive" id="preview2" style="width:70px; display:none;" />
                                            <div class="form-group mb-0 status-post-submit">
                                                <button type="submit" name="publish" id="publish" class="btn btn-default btn-xs" style="float: right; font-style: italic; border-radius: 14px 14px 14px 14px; display:none;"><i class="far fa-paper-plane"></i> Share</button>
                                            </div>
                                        </form> <script src="script.js"></script>
                                        <?php include('partials/post_quotes.php');
                                              include('partials/post_sounds.php');
                                              include('partials/post_videos.php');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col">
                                        <button type="button" class="btn btn-zungposts btn-block btn-sm" data-toggle="modal" data-target="#monModal" style="font-style: italic;"><i class="fas fa-images"></i></button>
                                    </div>
                                    <div class="col">
                                <button type="button" class="btn btn-zungposts btn-block btn-sm" style="font-style: italic;" data-toggle="modal" data-target="#quotes">
                                    <i class="fas fa-quote-left"></i> </i></button>
                                    </div>
                                 <div class="col">
                                <button type="button" class="btn btn-zungposts btn-block btn-sm" style="font-style: italic;" data-toggle="modal" data-target="#soundsModal">
                                    <i class="fas fa-headphones-alt"></i></button>
                                </div>
                                <div class="col">
                                <button type="button" class="btn btn-zungposts btn-block btn-sm" style="font-style: italic;" data-toggle="modal" data-target="#videosModal">
                                    <i class="fas fa-film"></i></button>
                                </div>
                                </div>
                            </div>
                            </div>
                          <?php endif; ?>
                       <?php  if(count($wishes) !=0): ?>
<?php foreach($wishes as $row):  ?>
<?php $him=find_user_by_id($row->from_user_id);  ?>
<?php if(strpos($row->color,'flag') !== false): ?>
<div class="card" style="background:white; border :5px 5px 5px 5px;margin:5px;border: 8px solid; background-image: url('/flags/drc_flag.jpg');" id="wish<?= $row->id ?>">
    <div class="card-body  wish" data-card_id="<?= $row->id ?>">
      <a href="profile.php?id=<?= $him->id ?>"><img src= "/<?= e($src =($him->profilepic != null) ? $him->profilepic : 'images/default.png') ?>"  alt="<?= e($him->name) ?>"   alt="image" class="rounded-circle" style="height: 50px; width: 50px; border:1.5px solid #ffff;" ></a>
      <small style="color:white;font-weight:bold;"><?= $him->name ?></small><br>
      <b style="color:white;font-size:16px; font-family:arial,sans-serif; margin-left:45px;"><?= $row->content ?></b>
      <i class="fas fa-times" style="float:right;"></i><br>
      <small style="float:right;"><?= zungvi_time_ago($row->created_at) ?></small>
    </div>
    <div class="card-footer" style="background:white; display:none;" id="reply<?= $row->id ?>">
    <div class="row">
        <textarea class="form-control border-0" placeholder="your reply..." id="replycontent<?= $row->id  ?>"></textarea>
        <a class="btn btn-outline-primary send_msg" style="width:100%;background:#0062E8;border-radius:10px 10px 10px 10px;color:white;"
        data-user_id="<?= $row->from_user_id ?>" data-wish_id="<?= $row->id ?>" data-wish="<?= $row->content ?>" data-color="<?= $row->color ?>">REPLY <i class="far fa-paper-plane"></i></a>
    </div>
    </div>
</div>
<?php else: ?>
<div class="card" style="background:white; border :5px 5px 5px 5px;margin:5px;border: 8px solid <?= $row->color ?>;" id="wish<?= $row->id ?>">
    <div class="card-body  wish" data-card_id="<?= $row->id ?>">
      <img src= "/<?= e($src =($him->profilepic != null) ? $him->profilepic : 'images/default.png') ?>"  alt="<?= e($him->name) ?>"   alt="image" class="rounded-circle" style="height: 50px; width: 50px; border:1.5px solid #ffff;" >
      <b style="color:black;font-size:16px; font-family:arial,sans-serif;"><?= $row->content ?></b>
      <i class="fas fa-times" style="float:right;"></i><br>
      <small style="float:right;"><?= zungvi_time_ago($row->created_at) ?></small>
    </div>
    <div class="card-footer" style="background:white; display:none;" id="reply<?= $row->id ?>">
    <div class="row">
        <textarea class="form-control border-0" placeholder="your reply..." id="replycontent<?= $row->id  ?>"></textarea>
        <a class="btn btn-outline-primary send_msg" style="width:100%; background:#00387E;border-radius:10px 10px 10px 10px;color:white;"
        data-user_id="<?= $row->from_user_id ?>" data-wish_id="<?= $row->id ?>" data-wish="<?= $row->content ?>" data-color="<?= $row->color ?>">REPLY <i class="far fa-paper-plane"></i></a>
    </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
 <a class="btn btn-primary maker" style="width:100%;"><i class="fas fa-plus"></i> Make a wish</a>
 <input type="search" id="searchbox2" placeholder="Make a wish to" class="form-control" style="font-style: italic; width:100%; display:none;"><br>
<div id="display-box" style="position:relative; display:none; margin-left:15px;">
</div>
                       <!-- Current user last post-->
                       <div id="last_post">

                       </div>
                       <!--   Affichage des posts -->
                        <div id="post_list">

                        </div>
                        <div id="post_list_message">

                        </div>

                        <div class="timeline-item" id="spinner1" style="margin-top:20px;">
                           <div class="animated-background">
                             <div class="background-masker header-top"></div>
                             <div class="background-masker header-left"></div>
                             <div class="background-masker header-right"></div>
                             <div class="background-masker header-bottom"></div>
                             <div class="background-masker subheader-left"></div>
                             <div class="background-masker subheader-right"></div>
                             <div class="background-masker subheader-bottom"></div>
                             <div class="background-masker content-top"></div>
                             <div class="background-masker content-first-end"></div>
                             <div class="background-masker content-second-line"></div>
                             <div class="background-masker content-second-end"></div>
                             <div class="background-masker content-third-line"></div>
                             <div class="background-masker content-third-end"></div>
                           </div>
                         </div>
                       <!--   Affichage des posts -->

                    </div>
                    <div class="col-lg-4" id="people">


                        <div class="card my-3">
                            <div class="card-body p-2">
                                <div class="h6">People on Zungvi :</div>
                                <?php foreach ($users as $user): ?>
                                <!-- style="background-color: #e9ebee;"-->
                                <?php if(!already_friends($user->id,get_session('user_id'))): ?>
                                  <?php if(!request_already_sent(get_session('user_id'), $user->id)):  ?>
                                <div class="row" id="friend<?= $user->id ?>">
                                  <div class="col-md-4">
                                            <a href="profile.php?id=<?= $user->id ?>"><img class="rounded-circle img-responsive" src="<?= e($user->profilepic)?>"
                                            alt="<?= e($user->name)?>" style="height: 60px; width: 60px; border:1.5px solid #f5f6fa;"></a>
                                  </div>
                                  <div class="col-md-8">
                                    <a href="profile.php?id=<?= e($user->id) ?>"><h5><b><?= e($user->name)?></b></h5></a>
                                    <button type="button" name="follow_button" class="btn btn-outline-primary action_button" data-action="follow" data-destinator_id="<?= $user->id ?>"><i class="fas fa-user-plus"></i> friends</button>
                                  </div>
                                </div>
                                <br>
                                <?php endif; ?>
                            <?php endif; ?>
                                 <?php endforeach ?>
                                <!-- -->
                                <?php include('partials/suggestion_modal.php');   ?>
                                <a class="btn btn-link" href="zpeople.php">see more</a><!--<a class="btn btn-link" data-toggle="modal" data-target="#suggestionModal"><i class="fas fa-mail-bulk"></i> suggestions</a>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-fixed f-right">
                <div class="side-right">
                    <div class="h7 text-center">Friends <i class="fas fa-users"></i> <?= friends_count(get_session('user_id')) ?></div>
                    <div id="user_details">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.form.min.js" ></script>
    <script src="assets/js/readMoreJS.min.js"></script>
    <script src="js/fil.js"></script>

<!-- SCRIPT -->

</body>
