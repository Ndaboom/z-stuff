<!-- Header -->
<?php 
    if($notifications_count>30){
    $notifs_max_number = "30+";
    }else{
        $notifs_max_number = $notifications_count;
        $notifications_count = $notifications_count;
    } 
?>
<style>
    .accept_friends{
        cursor: pointer;
    }
</style>

<header>

            <div class="header_wrap">

                <div class="header_inner mcontainer">

                    <div class="left_side">

                        <span class="slide_menu" uk-toggle="target: #wrapper ; cls: is-collapse is-active">

                        <img alt="zungvi logo" src="/images/logo/logo.png"/>    
                        </span>

                    </div>

                    <!-- search icon for mobile -->

                    <div class="header-search-icon" uk-toggle="target: #wrapper ; cls: show-searchbox"> </div>

                    <div class="header_search">

                        <input value="" type="text" id="search_box" class="form-control search_box" placeholder="<?= $long_text['search_box_text'][$_SESSION['locale']]  ?>" autocomplete="off">

                        <i class="uil-search-alt"></i>

                    </div>

                    <div uk-drop="mode: click" class="hidden md:w-1/3 w-11/12 shadow-lg rounded-md -mt-2 bg-white">

                        <div class="-mt-2 p-3" id="display-results">

                            <ul> 

                            </ul>

                        </div>

                    </div>

                    <div class="right_side">
                        <div class="header_widgets">
                            <?php if($_SESSION['user_id']): ?>
                            <a href="feed.php?id=<?= get_session('user_id') ?>" class="is_link"> <?= $long_text['home'][$_SESSION['locale']] ?>  </a> 

                            <a href="timeline.php?id=<?= get_session('user_id') ?>" class="is_link">  <?= $user2->name ?> <?= $user2->nom2 ?>  </a>  
                            <?php else: ?>
                                <div class="capitalize flex font-semibold hidden lg:block my-2 space-x-3 text-center text-sm">
                                    <a href="login.php" class="py-3 px-4"><?= $long_text['login_title'][$_SESSION['locale']] ?></a>
                                    <a href="inscription.php" class="bg-blue-500 purple-500 px-6 py-3 rounded-md shadow text-white"><?= $long_text['inscription_btn_texte'][$_SESSION['locale']] ?></a>
                                </div>
                            <?php endif; ?>

                            <a href="#" class="is_icon">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />

                                </svg>

                            </a>

                            <div uk-drop="mode: click" class="header_dropdown dropdown_cart" id="users_cart">


                            </div>



                            <a href="#" class="is_icon check_notifications">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"

                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />

                                </svg>

                               <?= $notifications_count > 0 ?  '<span>'.$notifs_max_number.'</span>' : '' ?>

                            </a>

                            <div uk-drop="mode: click" class="header_dropdown">

                                 <div  class="dropdown_scrollbar" data-simplebar>

                                     <div class="drop_headline">

                                         <h4>Notifications <?= $notifications_count > 0 ?  '('.$notifications_count.')' : '' ?></h4>

                                         <div class="btn_action">

                                             <a href="#">

                                                 <i class="icon-feather-settings" uk-tooltip="title: Notifications settings ; pos: left" title="" aria-expanded="false"></i>

                                             </a>

                                             <a href="#">

                                                 <i class="icon-feather-settings" uk-tooltip="title: Notifications settings ; pos: left" title="" aria-expanded="false"></i>

                                             </a>

                                         </div>

                                     </div>

                                     <ul id="notifications_list">

                                         

                                     </ul> 
                                 </div>

                            </div> 



                            <!-- Message -->

                            <a href="#" class="is_icon" id="message_icon">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />

                                </svg>

                                <span> </span>

                            </a>

                            <div uk-drop="mode: click" class="header_dropdown is_message">

                                <div  class="dropdown_scrollbar" data-simplebar>

                                    <div class="drop_headline">

                                        <h4>Messages (<?= unseen_message(get_session('user_id')) ?>)</h4>

                                        <div class="btn_action">

                                            <a href="#">

                                                <i class="icon-feather-settings" uk-tooltip="title: Notifications settings ; pos: left" title="" aria-expanded="false"></i>

                                            </a>

                                            <a href="#">

                                                <i class="icon-feather-settings" uk-tooltip="title: Notifications settings ; pos: left" title="" aria-expanded="false"></i>

                                            </a>

                                        </div>

                                    </div>

                                    <input type="text" class="uk-input search_in_message" id="messenger_box" placeholder="Search in Messages">

                                    <ul id="messages_list">

                                       

                                    </ul>

                                </div>

                                <a href="messages.php" class="see-all"> <?= $long_text['see_all_in_messages'][$_SESSION['locale']] ?></a>

                            </div>
                            <?php if($_SESSION['user_id']): ?>
                            <a href="#">

                                <img src="/<?= $user2->profilepic ?>" class="is_avatar" alt="">

                            </a>

                            <div uk-drop="mode: click;offset:5" class="header_dropdown profile_dropdown">



                                <a href="timeline.php?id=<?= $_SESSION['user_id'] ?>" class="user">

                                    <div class="user_avatar">

                                        <img src="/<?= $user2->profilepic ?>" style="height: 50px; width: 50px;"alt="">

                                    </div>

                                    <div class="user_name">

                                        <div> <?= $user2->name ?> <?= $user2->nom2 ?> </div>

                                        <span> @<?= strtolower($user2->name) ?><?= strtolower($user2->nom2) ?> </span>

                                    </div>

                                </a>

                                <hr class="border-gray-100">

                                <a href="profile_settings.php?id=<?= get_session('user_id') ?>">

                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>

                                    Settings

                                </a>

                                <!-- <a href="group-feed.html">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">

                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"  clip-rule="evenodd" />

                                    </svg>

                                    Manage Pages 

                                </a> -->
<!-- 
                                <a href="" id="night-mode" class="btn-night-mode">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">

                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />

                                      </svg>

                                     Night mode

                                    <span class="btn-night-mode-switch">

                                        <span class="uk-switch-button"></span>

                                    </span>

                                </a> -->

                                <a href="logout.php">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>

                                    </svg>

                                    Log Out 

                                </a>



                                

                            </div>
                        <?php endif; ?>
                        </div>

                        

                    </div>

                </div>

            </div>

        </header>