<!DOCTYPE html>

<html lang="en">

<?php

if ($notifications_count > 0) {
    $notifications_nbr = "(" . $notifications_count . ")";
    $notifs_number = $notifications_nbr;
} else {
    $notifications_nbr = "";
}

$title = $notifications_nbr . " " . $user->name . " " . $user->nom2;
$page = "timeline";

require('includes/adds_functions.php');
include('partials/header1.php');

?>

<body>

    <div id="wrapper">

        <?php include('partials/_menu1.php'); ?>

        <!-- sidebar -->

        <div class="sidebar">
            <div class="sidebar_header">
                <img src="assets/images/logo.png" alt="">
                <img src="assets/images/logo.png" class="logo-icon" alt="">
                <span class="btn-mobile" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></span>
            </div>
            <?php
            include('partials/v2/side_bar.php');
            ?>
        </div>

        <!-- Main Contents -->
        <div class="main_content">
            <div class="mcontainer">
                <form method="post" enctype="multipart/form-data" action="/upload_profiles.php" id="upload_form">
                    <div class="profile user-profile bg-white rounded-2xl -mt-4">
                        <div class="profiles_banner">
                            <div uk-lightbox>
                                <a href="<?= $user->coverpic ?>"><img id="profileDisplay1" src="<?= $user->coverpic ?>" alt=""></a>
                            </div>
                            <?php if ($_SESSION['user_id'] == $_GET['id']) : ?>
                                <div class="profile_action absolute bottom-0 right-0 space-x-1.5 p-3 text-sm z-50 hidden lg:flex">
                                    <a href="#" class="flex items-center justify-center h-8 px-3 rounded-md bg-gray-700 bg-opacity-70 text-white space-x-1.5">
                                        <ion-icon name="crop-outline" class="text-xl"></ion-icon>
                                        <span onclick="triggerClick1()"> Edit cover </span>
                                        <input type="file" name="image1" id="image1" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage1(this)">
                                    </a>
                                    <a href="#" class="flex items-center justify-center h-8 px-3 rounded-md bg-gray-700 bg-opacity-70 text-white space-x-1.5">
                                        <ion-icon name="create-outline" class="text-xl"></ion-icon>
                                        <span onclick="triggerClick()"> Edit profile</span>
                                        <input type="file" name="image" id="image" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage(this)">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="profiles_content">
                            <div class="profile_avatar">
                                <div class="profile_avatar_holder">
                                    <div uk-lightbox>
                                        <a href="<?= $user->profilepic ?>"><img src="<?= $user->profilepic ?>" alt="profile image" id="profileDisplay"></a>

                                    </div>
                                </div>
                                <?php if ($user_last_activity > $current_timestamp) : ?>
                                    <div class="user_status status_online"></div>
                                <?php endif; ?>
                                <div class="icon_change_photo" hidden>
                                    <ion-icon name="camera" class="text-xl"></ion-icon>
                                </div>
                            </div>
                            <div class="profile_info">
                                <h1> <?= $user->name ?> <?= $user->nom2 ?> </h1>
                            </div>
                        </div>



                        <div class="flex justify-between lg:border-t flex-col-reverse lg:flex-row">
                            <nav class="cd-secondary-nav pl-2 is_ligh -mb-0.5 border-transparent">
                                <ul>
                                    <li <?= isset($_GET['t']) ? '' : 'class="active"' ?>><a href="timeline.php?id=<?= $user->id ?>"> <?= $long_text['timeline'][$_SESSION['locale']] ?></a></li>
                                    <li><a href="posts.php?id=<?= $user->id ?>"><?= $long_text['posts'][$_SESSION['locale']] ?></a></li>

                                    <li <?= isset($_GET['t']) ? 'class="active"' : '' ?>><a href="timeline.php?id=<?= $user->id ?>&t=friends"><?= $long_text['friends'][$_SESSION['locale']] ?> <span><?= friends_count($_GET['id']) ?> </span></a></li>

                                    <?php if (get_session('user_id') == $_GET['id']) : ?>
                                        <script src="v2/script.js"></script>
                                        <li><a href="profile_settings.php?id=<?= get_session('user_id') ?>"><?= $long_text['settings'][$_SESSION['locale']] ?></a></li>
                                    <?php endif; ?>

                                </ul>

                            </nav>



                            <div class="flex items-center space-x-1.5 flex-shrink-0 pr-3  justify-center order-1">
                                <button type="submit" id="update_photos" class="flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white  space-x-1.5" style="display:none;">
                                    <span> Save changes </span>
                                </button>
                                <?php if ($_GET['id'] != $_SESSION['user_id']) : ?>

                                    <?php if (relation_link_to_display($_GET['id']) == "cancel_relation_link") : ?>
                                        <a href="#" class="cancel_friend flex items-center justify-center h-10 px-5 rounded-md bg-gray-600 space-x-1.5" id="decline_request<?= $_GET['id'] ?>" data-user_id="<?= $_GET['id'] ?>">
                                            <span><i class="fas fa-ban"></i> Cancel request </span>
                                        </a>
                                    <?php elseif (relation_link_to_display($_GET['id']) == "accept_reject_relation_link") : ?>
                                        <a href="#" class="accept_friends flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5" data-user_id="<?= $_GET['id'] ?>" id="request_button<?= $_GET['id'] ?>">
                                            <span><i class="fas fa-check"></i> Accept </span>
                                        </a>
                                        <a href="#" class="cancel_friend flex items-center justify-center h-10 px-5 rounded-md bg-gray-600 space-x-1.5" id="decline_request<?= $_GET['id'] ?>" data-user_id="<?= $_GET['id'] ?>">
                                            <span><i class="fas fa-ban"></i> Decline </span>
                                        </a>
                                        <span id="accepted_msg<?= $_GET['id'] ?>" style="display:none;">Now connected to <?= $user->name ?></span>
                                    <?php elseif (relation_link_to_display($_GET['id']) == "delete_relation_link") : ?>
                                        Already friends.
                                        <a href="#" class="remove_friend flex items-center justify-center h-10 px-5 rounded-md bg-gray-600 space-x-1.5" data-name="<?= $user->name ?>" data-user_id="<?= $_GET['id'] ?>">
                                            <span><i class="fas fa-ban"></i> Remove friend </span>
                                        </a>
                                    <?php elseif (relation_link_to_display($_GET['id']) == "add_relation_link") : ?>
                                        <a href="#" class="add_friend flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white space-x-1.5" data-user_id="<?= $_GET['id'] ?>" id="requested_friends<?= $_GET['id'] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span> Friends </span>
                                        </a>
                                        <span class="text-green-600" style="display:none;" id="success_msg<?= $_GET['id'] ?>">Request sent</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="lg:flex lg:mt-8 mt-4 lg:space-x-8">
                    <div class="space-y-5 flex-shrink-0 lg:w-7/12">
                        <?php if (isset($_GET['t']) && $_GET['t'] == "friends") : ?>
                            <!-- Friends in here -->
                            <div class="card md:p-6 p-2 max-w-3xl mx-auto">
                                <h2 class="text-xl font-bold"> <?= $long_text['friends'][$_SESSION['locale']] ?></h2>

                                <div class="grid md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-2 gap-y-4 mt-3" id="friends_list">


                                </div>

                                <div class="flex justify-center mt-6" id="friends_spinner">
                                    <a href="#" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                        Load more ..</a>
                                </div>
                            </div>
                            <!-- Friends in here -->
                        <?php else : ?>
                            <!--  Post content here -->
                            <div id="post_list" uk-scrollspy="cls: uk-animation-slide-bottom; target: .post_box; delay: 500; repeat: false">
                            </div>
                            <!-- Post content here -->
                            <div class="flex justify-center mt-6">
                                <a href="#" class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                    Load more ..</a>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="lg:w-4/12 space-y-6">
                        <div class="widget">
                            <h4 class="text-2xl mb-3 font-semibold"> <?= $long_text['about'][$_SESSION['locale']] ?> <?= $user->name ?> </h4>
                            <ul class="text-gray-600 space-y-4">
                                <?php if ($user->city != '' && $user->country != '') : ?>
                                    <li class="flex items-center space-x-2">
                                        <ion-icon name="home-sharp" class=" rounded-full bg-gray-200 text-xl p-1.5 mr-3"></ion-icon>
                                        Lives In <strong> <?= $user->city ?> , <?= $user->country ?> </strong>
                                    </li>

                                <?php endif; ?>

                                <?php if ($user->relationshipStatus != '') : ?>

                                    <li class="flex items-center space-x-2">
                                        <ion-icon name="heart-sharp" class=" rounded-full bg-gray-200 text-xl p-1.5 mr-3"></ion-icon>
                                        <strong> <?= $user->relationshipStatus ?> </strong>
                                    </li>

                                <?php endif; ?>

                                <?php if (friends_count($_GET['id']) > 1) : ?>

                                    <li class="flex items-center space-x-2">
                                        <ion-icon name="logo-rss" class=" rounded-full bg-gray-200 text-xl p-1.5 mr-3"></ion-icon>
                                        <?= friends_count($_GET['id']) ?> <strong> Friends </strong>
                                    </li>

                                <?php endif; ?>

                            </ul>
                        </div>
                        <div class="widget border-t pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-2xl -mb-0.5 font-semibold"> Friends </h4>
                                    <p> <?= friends_count($_GET['id']) ?> Friends </p>
                                </div>
                                <!-- <a href="#" class="text-blue-600 ">See all</a> -->
                            </div>

                            <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">

                                <?php foreach ($friends as $friend) : ?>

                                    <?php
                                    if ($friend->user_id1 != $_GET['id']) {
                                        $him = find_user_by_id($friend->user_id1);
                                    } elseif ($friend->user_id2 != $_GET['id']) {
                                        $him = find_user_by_id($friend->user_id2);
                                    }
                                    ?>

                                    <?php if ($him->id != $_GET['id']) :  ?>

                                        <a href="timeline.php?id=<?= $him->id ?>">

                                            <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2">

                                                <img src="<?= $him->profilepic ?>" alt="<?= $him->name ?> <?= $him->nom2 ?>" class="w-full h-full object-cover absolute">

                                            </div>

                                            <div> <?= $him->name ?> <?= substr($him->nom2, 0, 1) ?> </div>

                                        </a>

                                    <?php endif; ?>



                                <?php endforeach; ?>

                            </div>
                            <!-- 
                          <a href="" class="bg-gray-100 py-2.5 text-center font-semibold w-full mt-4 block rounded"> See all </a> -->

                        </div>

                        <?php if (count($MeinsideF) != 0) : ?>

                            <div class="widget border-t pt-4">

                                <div class="flex items-center justify-between mb-2">

                                    <div>

                                        <h4 class="text-2xl -mb-0.5 font-semibold"> Forums (<?= count($MeinsideF) ?>)</h4>

                                    </div>

                                    <a href="forums.php?p=all_forums" class="text-blue-600 ">See all</a>

                                </div>

                                <?php foreach ($MeinsideF as $row) : ?>

                                    <?php $forum = get_forum_name($row->forum_id); ?>

                                    <div>

                                        <div class="flex items-center space-x-4 hover:bg-gray-100 rounded-md -mx-2 p-2">

                                            <div class="w-14 h-14 flex-shrink-0 rounded-md relative">

                                                <img src="<?= $forum->forum_pic != '' ? $forum->forum_pic : 'images/portada_7.png' ?>" class="absolute w-full h-full inset-0 rounded-md" alt="">

                                            </div>

                                            <div class="flex-1">

                                                <h3 class="text-lg font-semibold capitalize"> <?= $forum->forum_name ?> </h3>

                                                <div class="text-sm text-gray-500 -mt-0.5"> <?= forum_members_count($forum->id) ?> Member<?= forum_members_count($forum->id) > 1 ? 's' : '' ?></div>

                                            </div>

                                            <a href="forum_home.php?n=<?= $forum->forum_name ?>&fr_i=<?= $forum->id ?>" class="flex items-center justify-center h-9 px-4 rounded-md bg-gray-200 font-semibold"> Join </a>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- open chat box -->

    <div uk-toggle="target: #offcanvas-chat" class="start-chat">

        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>

        </svg>

    </div>

    <?php include('partials/right_pane.php'); ?>

    <!-- Create post modal -->

    <div id="create-post-modal" class="create-post" uk-modal>

        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">



            <div class="text-center py-4 border-b">

                <h3 class="text-lg font-semibold"> Create Post </h3>

                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>

            </div>

            <div class="flex flex-1 items-start space-x-4 p-5">

                <img src="<?= $user->profilepic ?>" class="bg-gray-200 border border-white rounded-full w-11 h-11">

                <div class="flex-1 pt-2">

                    <textarea class="uk-textare text-black shadow-none focus:shadow-none text-xl font-medium resize-none" rows="5" placeholder="What's Your Mind ? <?= $user->name ?>!"></textarea>

                </div>



            </div>

            <div class="bsolute bottom-0 p-4 space-x-4 w-full">

                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-3 shadow-sm items-center">

                    <div class="lg:block hidden"> Add to your post </div>

                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">



                        <svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>

                        <svg class="text-red-600 h-9 p-1.5 rounded-full bg-red-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"> </path>
                        </svg>

                        <svg class="text-green-600 h-9 p-1.5 rounded-full bg-green-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>

                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"> </path>
                        </svg>

                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path>
                        </svg>

                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>

                        <svg class="text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>



                        <!-- view more -->

                        <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more" uk-toggle="target: #veiw-more; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path>
                        </svg>



                    </div>

                </div>

            </div>

            <div class="flex items-center w-full justify-between p-3 border-t">



                <select class="selectpicker mt-2 col-4 story">

                    <option>Only me</option>

                    <option>Every one</option>

                    <option>People I Follow </option>

                    <optionion>People Follow Me</optionion>

                </select>



                <div class="flex space-x-2">
                    <a href="#" class="bg-red-100 flex font-medium h-9 items-center justify-center px-5 rounded-md text-red-600 text-sm">
                        <svg class="h-5 pr-1 rounded-full text-red-500 w-6 fill-current" id="veiw-more" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false" style="">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Live </a>
                    <a href="#" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium">Share </a>
                </div>

                <a href="#" hidden class="bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold">

                    Share </a>

            </div>

        </div>

    </div>





    <!-- Javascript

    ================================================== -->

    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="assets/js/jquery-3.3.1.min.js"></script>

    <script src="assets/js/uikit.js"></script>

    <script src="assets/js/simplebar.js"></script>

    <script src="assets/js/custom.js"></script>

    <script src="assets/js/bootstrap-select.min.js"></script>

    <script src="js/v2/timeline.js"></script>
    <script src="js/v2/base.js"></script>
    <?php if (isset($_GET['t']) && $_GET['t'] == "friends") : ?>
        <?php if (relation_link_to_display($_GET['id']) == "delete_relation_link" || $user->friends_privacy == 0 || $_SESSION['user_id'] == $_GET['id']) : ?>
            <script>
                $(document).ready(function() {
                    var ui = <?= $_GET['id'] ?>;
                    var flimit = 7;
                    var fstart = 0;
                    var flimit2 = 7;
                    var faction = 'inactive';

                    function load_friends(flimit, fstart) {
                        $.ajax({
                            url: "/ajax/v2/fetch_friends_timeline.php",
                            method: "POST",
                            data: {
                                limit: flimit,
                                start: fstart,
                                ui: ui
                            },
                            cache: false,
                            beforeSend: function() {
                                $("#friends_spinner").show();
                            },
                            success: function(data) {
                                $('#friends_list').append(data);
                                $("#friends_spinner").hide();
                                if (data == '') {
                                    faction = 'active';
                                } else {
                                    faction = 'inactive';
                                }
                            }
                        })
                    }

                    if (faction == 'inactive') {
                        action = 'active';
                        load_friends(flimit, fstart);
                    }

                    $(window).scroll(function() {
                        if ($(window).scrollTop() + $(window).height() > $("#friends_list").height() && faction == 'inactive') {
                            faction = 'active';
                            fstart = fstart + flimit;
                            flimit2 = fstart + 7;
                            setTimeout(function() {
                                load_friends(flimit, fstart);
                            }, 1000);
                        }
                    });

                });
            </script>
        <?php else : ?>
            <script>
                $('#friends_list').append("Friends list for this user is private");
            </script>
        <?php endif; ?>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            <?php if (relation_link_to_display($_GET['id']) == "delete_relation_link" || $user->posts_privacy == 0 || $_SESSION['user_id'] == $_GET['id']) : ?>
                var limit = 7;
                var start = 0;
                var limit2 = 7;
                var action = 'inactive';

                function load_data(limit, start) {
                    $.ajax({
                        url: "/ajax/v2/fetch_timeline.php",
                        method: "POST",
                        data: {
                            limit: limit,
                            start: start
                        },
                        cache: false,
                        beforeSend: function() {
                            $("#spinner1").show();
                        },
                        success: function(data) {
                            $('#post_list').append(data);
                            $("#spinner1").hide();
                            if (data == '') {
                                $('#post_list_message').html("<h5>No available post...</h5>");
                                action = 'active';
                            } else {
                                $('#post_list_message').html("<button class='btn btn-zung btn-block btn-sm more_post'>loading...</button>");
                                action = 'inactive';
                            }
                        }
                    })
                }

                if (action == 'inactive') {
                    action = 'active';
                    load_data(limit, start);
                }

                $(window).scroll(function() {
                    if ($(window).scrollTop() + $(window).height() > $("#post_list").height() && action == 'inactive') {
                        action = 'active';
                        start = start + limit;
                        limit2 = start + 7;
                        setTimeout(function() {
                            load_data(limit, start);
                        }, 1000);
                    }
                });

                $(document).on('click', '.like', function() {

                    var id = $(this).attr("id");
                    var url = '/ajax/micropost_like.php';
                    var action = $(this).data('action');
                    var poster = $(this).data('poster');
                    var postid = $(this).data('postid');
                    var micropostId = id.split("like")[1];
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            micropost_id: micropostId,
                            action: action,
                            poster: poster,
                            postid: postid
                        },
                        beforeSend: function() {
                            if (action == "like") {
                                $("#like" + micropostId).hide();
                                $("#unlike" + micropostId).fadeIn('fast');
                                audioElement.play();
                            } else {
                                $("#like" + micropostId).fadeIn('fast');
                                $("#unlike" + micropostId).hide();
                            }
                        },
                        success: function(likers) {
                            refresh_data(limit2, from);
                        }

                    });
                });

                var from = 0;

                function refresh_data(limit2, from) {
                    $.ajax({
                        url: "/ajax/v2/refetch_timeline.php",
                        method: "POST",
                        data: {
                            limit2: limit2,
                            from: from
                        },
                        success: function(data) {
                            $('#post_list').html(data);
                        }
                    })
                }
            <?php else : ?>
                $('#post_list').html('<div class="bg-whit border-t-4 border-red-600 p-5 shadow-lg relative rounded-md uk-alert" uk-alert=""><h3 class="text-lg font-semibold mt-1">Private Account </h3><p>You must be friends with this user to see these posts.</p><div class="flex space-x-2 items-center justify-end mt-2"></div></div>');
            <?php endif; ?>
        });
    </script>

</body>

</html>