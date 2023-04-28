<?php
session_start();
if ($_SESSION['user_id'] != 1 && $_SESSION['user_id'] != 323) {
?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    if ($notifications_count > 0) {
        $notifications_nbr = "(" . $notifications_count . ")";
        $notifs_number = $notifications_nbr;
    } else {
        $notifications_nbr = "";
    }
    $title = "Messages";
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
                    <img src="assets/images/logo-icon.html" class="logo-icon" alt="">
                    <span class="btn-mobile" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></span>
                </div>
                <?php
                include('partials/v2/side_bar.php');
                ?>
            </div>
            <!-- Main Contents -->
            <div class="main_content">
                <span uk-toggle="target: .message-content;" class="fixed left-0 top-36 bg-red-600 z-10 py-1 px-4 rounded-r-3xl text-white"> Users</span>
                <div class="messages-container">
                    <div class="messages-container-inner">
                        <div class="messages-inbox">
                            <div class="messages-headline">
                                <div class="input-with-icon" hidden>
                                    <input id="autocomplete-input" type="text" placeholder="Search">
                                    <i class="icon-material-outline-search"></i>
                                </div>
                                <h2 class="text-2xl font-semibold">Chats</h2>
                                <span class="absolute icon-feather-edit mr-4 text-xl uk-position-center-right cursor-pointer"></span>
                            </div>
                            <div class="messages-inbox-inner" data-simplebar>
                                <ul id="users_list">

                                </ul>
                            </div>
                        </div>
                        <div class="message-content" style="padding-bottom: 0px;">
                            <div class="messages-headline">
                                <h4 id="username"> </h4>
                                <?php if ($_SESSION['user_id'] == 1) : ?>
                                    <a href="#" class="message-action text-red-500" uk-toggle="target: #video-call" id="bell_button"><i class="fas fa-video"></i> <span class="md:inline hidden"> Give a bell</span> </a>
                                <?php endif; ?>
                            </div>
                            <div class="message-content-scrolbar" data-simplebar>
                                <!-- Message Content Inner -->
                                <div class="message-content-inner" id="chat_history" style="min-height: 300px;">



                                </div>
                                <!-- Message Content Inner / End -->

                                <!-- Reply Area -->
                                <div class="message-reply">
                                    <textarea cols="1" rows="1" id="msg_content" class="message_box" placeholder="Your Message"></textarea>
                                    <button class="button ripple-effect" id="send_btn">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  video call app  -->
        <div id="video-call" uk-modal>
            <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <video src="https://yootheme.com/site/images/media/yootheme-pro.mp4" controls playsinline uk-video></video>
                <video src="https://yootheme.com/site/images/media/yootheme-pro.mp4" controls playsinline uk-video></video>
            </div>
        </div>
        <!--  video call app  -->

        <!-- Javascript
    ================================================== -->
        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="assets/js/uikit.js"></script>
        <script src="assets/js/simplebar.js"></script>
        <script src="assets/js/tippy.all.min.js"></script>
        <script src="assets/js/custom.js"></script>
        <script src="assets/js/bootstrap-select.min.js"></script>
        <script src="js/v2/messages.js"></script>
        <script src="assets/js/emojionearea.min.js"></script>
        <script src="assets/unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>
        <script src="js/v2/base.js"></script>


        <script type="text/javascript">
            <?php if (isset($_GET['i'])) : ?>

                $(document).ready(function() {

                    init_messenger();

                    function init_messenger() {
                        var url = '/ajax/v2/messenger/fetch_chat.php';
                        var to_user_id = <?= $_GET['i'] ?>;
                        var username = "<?= $_GET['n'] ?>";
                        var from_user_id = <?= $_SESSION['user_id'] ?>;
                        var limit = 5,
                            start = 0;

                        // $('#msg_content').emojioneArea({
                        // pickerPosition:"top",
                        // toneStyle: "bullet"
                        // });

                        $.ajax({
                            url: "/ajax/v2/messenger/fetch_chat.php",
                            method: "POST",
                            data: {
                                to_user_id: to_user_id,
                                from_user_id: from_user_id,
                                start: start,
                                limit: limit
                            },
                            cache: false,
                            beforeSend: function() {
                                $("#username").html(username);
                                $('#msg_content').attr('placeholder', 'Your message to ' + username);
                                $('.ripple-effect').attr('data-uid', to_user_id);
                                $('.ripple-effect').attr('data-username', username);
                            },
                            success: function(data) {
                                $("#chat_history").html(data);
                            }
                        });

                    }


                });

            <?php endif; ?>
        </script>
    </body>

    </html>
<?php } elseif($_SESSION['user_id'] == 323 || $_SESSION['user_id'] == 1) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    if ($notifications_count > 0) {
        $notifications_nbr = "(" . $notifications_count . ")";
        $notifs_number = $notifications_nbr;
    } else {
        $notifications_nbr = "";
    }
    $title = "Messages";
    $page = "timeline";

    require('includes/functions.php');
    require('includes/adds_functions.php');
    include('partials/messenger/header.php');
    ?>


<body>

<div class="main-wrapper">

<div class="content main_content">

<div class="sidebar-menu">
<div class="logo-col">
<a href="feed.php"><img src="/images/logo/logo.min.png" alt="Zungvi logo"></a>
</div>
<div class="menus-col">
<div class="chat-menus">
<ul>
<li>
<a href="feed.php?id=<?= $_SESSION['user_id'] ?>" class="chat-unread blue">
<span class="material-icons">message</span>
<span>Chats</span>
</a>
</li>
<li>
<a href="group.html" class="chat-unread pink">
<span class="material-icons">group</span>
<span>Groups</span>
</a>
</li>
<li>
<a href="status.html" class="chat-unread">
<span class="material-icons">library_books</span>
<span>Status</span>
</a>
</li>
<li>
<a href="audio-call.html" class="chat-unread">
<span class="material-icons">call</span>
<span>Calls</span>
</a>
</li>
<li>
<a href="settings.html" class="chat-unread">
<span class="material-icons">settings</span>
<span>Settings</span>
</a>
</li>
</ul>
</div>
<div class="bottom-menus">
<ul>
<li>
<a href="#" data-bs-toggle="modal" data-bs-target="#add-new-group">
<span class="material-icons group-add-btn">group_add</span>
<span>Add Groups</span>
</a>
</li>
<li>
<a href="#" class="add-contacts-btn" data-bs-toggle="modal" data-bs-target="#add-contact">
<i class="fas fa-plus"></i>
<span>Add Contacts</span>
</a>
</li>
<li>
<a href="#" id="dark-mode-toggle" class="dark-mode-toggle">
<i class="far fa-moon"></i>
 </a>
</li>
<li>
<a href="#" class="chat-profile-icon" data-bs-toggle="dropdown">
<img src="<?= $user2->profilepic ?>" style="height:50px;width:50px;" alt="">
</a>
<div class="dropdown-menu dropdown-menu-end">
<a href="#" class="dropdown-item dream_profile_menu">Edit Profile <span class="edit-profile-icon"><i class="fas fa-edit"></i></span></a>
<a href="#" class="dropdown-item">Profile <span class="profile-icon-col"><i class="fas fa-id-card-alt"></i></span></a>
<a href="settings.html" class="dropdown-item">Settings <span class="material-icons">settings</span></a>
<a href="archived.html" class="dropdown-item">Archived <span class="material-icons">flag</span></a>
<a href="login-email.html" class="dropdown-item">Logout <span class="material-icons">power_settings_new</span></a>
</div>
</li>
</ul>
</div>
</div>
</div>

<div class="sidebar-group left-sidebar chat_sidebar">

<div id="chats" class="left-sidebar-wrap sidebar active slimscroll">
<div class="slimscroll">

<div class="left-chat-title d-flex justify-content-between align-items-center">
<div class="chat-title">
<h4>CHATS</h4>
</div>
<div class="add-section">
<ul>
<li><a href="group.html"><span class="material-icons">group</span></a></li>
<li><a href="#" data-bs-toggle="modal" data-bs-target="#add-user"><i class="fas fa-plus"></i></a></li>
</ul>
</div>
</div>

<div class="search_chat has-search">
<span class="fas fa-search form-control-feedback"></span>
<input class="form-control chat_input" id="search-contacts" type="text" placeholder="Search Contacts">
</div>

<div class="top-online-contacts">
<div class="swiper-container">
<div class="swiper-wrapper" id="online_users">
    
    
</div>
</div>
</div>

<div class="sidebar-body" id="chatsidebar">

<div class="left-chat-title d-flex justify-content-between align-items-center ps-0 pe-0">
<div class="chat-title">
<h4>Recent Chats</h4>
</div>
<div class="add-section">
<a href="#"><i class="fas fa-edit"></i></a>
</div>
</div>

<ul class="user-list mt-2" id="users_list">


</ul>

</div>
</div>
</div>

</div>
<div class="chat" id="middle">
<div class="slimscroll" id="slimscroll_box">
<div class="chat-header">
<div class="user-details">
<div class="d-lg-none ms-2">
<ul class="list-inline mt-2 me-2">
<li class="list-inline-item">
<a class="text-muted px-0 left_side" href="#" data-chat="open">
<i class="fas fa-arrow-left"></i>
</a>
</li>
</ul>
</div>
<figure class="avatar ms-1">
<img id="user_profile" src="images/default.png" class="rounded-circle" alt="image">
</figure>
<div class="mt-1">
<h5 id="username">Username</h5>
<small class="online">
Online
</small>
</div>
</div>
<div class="chat-options">
<ul class="list-inline">
<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search">
<a href="javascript:void(0)" class="btn btn-outline-light chat-search-btn">
<i class="fas fa-search"></i>
</a>
</li>
<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Voice call">
<a href="javascript:void(0)" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#voice_call">
<i class="fas fa-phone-alt voice_chat_phone"></i>
</a>
</li>
<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Video call">
<a href="javascript:void(0)" id="vcall_launcher" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#video_call">
<i class="fas fa-video"></i>
 </a>
</li>
<li class="list-inline-item dream_profile_menu" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
<a href="javascript:void(0)" class="btn btn-outline-light">
<i class="fas fa-user"></i>
</a>
</li>
<li class="list-inline-item">
<a class="btn btn-outline-light no-bg" href="#" data-bs-toggle="dropdown">
<i class="fas fa-ellipsis-h"></i>
</a>
<div class="dropdown-menu dropdown-menu-end">
<a href="#" class="dropdown-item dream_profile_menu">Archive <span><i class="fas fa-archive"></i></span></a>
<a href="#" class="dropdown-item">Muted <span class="material-icons">volume_off</span></a>
<a href="#" class="dropdown-item">Delete <span><i class="far fa-trash-alt"></i></span></a>
</div>
</li>
</ul>
</div>
<div class="chat-search">
<form>
<span class="fas fa-search form-control-feedback"></span>
<input type="text" name="chat-search" class="chat_search" placeholder="Search Chats" class="form-control">
<div class="close-btn-chat"><span class="material-icons">close</span></div>
</form>
</div>
</div>
<div class="chat-body">
<div class="messages" id="chat_history">
<div class="chat-line">
<span class="chat-date">Today</span>
</div>
</div>
</div>
</div>
 <div class="chat-footer">
<form>
<div class="smile-col">
<a href="#"><i class="far fa-smile"></i></a>
</div>
<div class="attach-col">
<a href="#"><i class="fas fa-paperclip"></i></a>
</div>
<input type="text" class="form-control chat_form" id="msg_content" placeholder="Enter Message.....">
<div class="form-buttons">
<button class="btn send-btn" type="submit">
<span class="material-icons">send</span>
</button>
</div>
<div class="specker-col">
<a href="#"><span class="material-icons">settings_voice</span></a>
</div>
</form>
</div>
</div>
<div class="right-sidebar right_sidebar_profile" id="middle1">
<div class="right-sidebar-wrap active">
<div class="slimscroll" id="slimscroll_box">
<div class="left-chat-title d-flex justify-content-between align-items-center p-3">
<div class="chat-title">
<h4>PROFILE</h4>
</div>
<div class="contact-close_call text-end">
<a href="#" class="close_profile close_profile4">
<span class="material-icons">close</span>
</a>
</div>
</div>
<div class="sidebar-body">
<div class="mt-0 right_sidebar_logo">
<div class="text-center mb-2 right-sidebar-profile">
<figure class="avatar avatar-xl mb-3">
<img id="current_userprofifle" src="images/default.png" class="rounded-circle" alt="image">
</figure>
<h5 id="current_username" class="profile-name">Username</h5>
<div class="online-profile">
<span>online</span>
</div>
</div>
<div>
<div class="about-media-tabs">
<nav>
<div class="nav nav-tabs justify-content-center" id="nav-tab">
<a class="nav-item nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#about">About</a>
<a class="nav-item nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#media">Media</a>
</div>
</nav>
<div class="tab-content" id="nav-tabContent">
<div class="tab-pane fade show active" id="about">

<div class="member-details">
<ul>
<li>
<h6 id="userphone">Phone</h6>
<span>xxx-xxx-xxx</span>
</li>
<li>
<h6>Email</h6>
<span><a href="https://dreamschat.dreamguystech.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="47062b2522353e302807202a262e2b6924282a">[email&#160;protected]</a></span>
</li>
</ul>
</div>
<div class="social-media-col">
<h6>Social media accounts</h6>
<ul>
<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
<li><a href="#"><i class="fab fa-twitter"></i></a></li>
<li><a href="#"><i class="fab fa-youtube"></i></a></li>
 <li><a href="#"><i class="fab fa-instagram"></i></a></li>
<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
</ul>
</div>
<div class="settings-col">
<h6>Settings</h6>
<ul>
<li class="d-flex align-items-center">
<label class="switch">
<input type="checkbox" checked>
<span class="slider round"></span>
</label>
<div>
<span>Block</span>
</div>
</li>
<li class="d-flex align-items-center">
<label class="switch">
<input type="checkbox">
<span class="slider round"></span>
</label>
<div>
<span>Mute</span>
</div>
</li>
<li class="d-flex align-items-center">
<label class="switch">
<input type="checkbox">
<span class="slider round"></span>
</label>
<div>
<span>Get notification</span>
</div>
</li>
</ul>
</div>
</div>
<div class="tab-pane fade" id="media">
<div class="file-download-col">
<ul>
<li>
<div class="image-download-col">
<a href="assets/messenger/img/chat-download.jpg" data-fancybox="gallery" class="fancybox">
<img src="assets/messenger/img/chat-download.jpg" alt="">
</a>
<div class="download-action d-flex align-items-center">
<div><a href="#"><i class="fas fa-cloud-download-alt"></i></a></div>
<div><a href="#"><i class="fas fa-ellipsis-h"></i></a></div>
</div>
</div>
</li>
<li>
<div class="image-download-col">
<a href="assets/messenger/img/chat-download.jpg" data-fancybox="gallery" class="fancybox">
<img src="assets/messenger/img/chat-download.jpg" alt="">
</a>
<div class="download-action d-flex align-items-center">
<div><a href="#"><i class="fas fa-cloud-download-alt"></i></a></div>
<div><a href="#"><i class="fas fa-ellipsis-h"></i></a></div>
</div>
</div>
</li>
<li>
<div class="image-download-col">
<a href="assets/messenger/img/chat-download.jpg" data-fancybox="gallery" class="fancybox">
<img src="assets/messenger/img/chat-download.jpg" alt="">
</a>
<div class="download-action d-flex align-items-center">
<div><a href="#"><i class="fas fa-cloud-download-alt"></i></a></div>
<div><a href="#"><i class="fas fa-ellipsis-h"></i></a></div>
</div>
</div>
</li>
<li>
<div class="image-download-col">
<a href="assets/messenger/img/chat-download.jpg" data-fancybox="gallery" class="fancybox">
<img src="assets/messenger/img/chat-download.jpg" alt="">
</a>
<div class="download-action d-flex align-items-center">
<div><a href="#"><i class="fas fa-cloud-download-alt"></i></a></div>
<div><a href="#"><i class="fas fa-ellipsis-h"></i></a></div>
</div>
</div>
</li>
<li>
<div class="image-download-col">
<a href="assets/messenger/img/chat-download.jpg" data-fancybox="gallery" class="fancybox">
<img src="assets/messenger/img/chat-download.jpg" alt="">
</a>
<div class="download-action d-flex align-items-center">
<div><a href="#"><i class="fas fa-cloud-download-alt"></i></a></div>
<div><a href="#"><i class="fas fa-ellipsis-h"></i></a></div>
</div>
</div>
</li>
<li>
<div class="image-download-col">
<a href="assets/messenger/img/chat-download.jpg" data-fancybox="gallery" class="fancybox">
<img src="assets/messenger/img/chat-download.jpg" alt="">
</a>
<div class="download-action d-flex align-items-center">
<div><a href="#"><i class="fas fa-cloud-download-alt"></i></a></div>
<div><a href="#"><i class="fas fa-ellipsis-h"></i></a></div>
</div>
</div>
</li>
<li class="full-width text-center">
<a href="#" class="load-more-btn">More 154 Files <i class="fas fa-sort-down"></i></a>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="report-col">
<ul>
<li><a href="#"><span class="material-icons">report_problem</span> Report Chat</a></li>
<li><a href="#"><span><i class="far fa-trash-alt"></i></span> Delete Chat</a></li>
</ul>
</div>
</div>
</div>
</div>

</div>

<div class="modal fade" id="add-user">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
<span class="material-icons">person_add</span>Add Friends
</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span class="material-icons">close</span>
</button>
</div>
<div class="modal-body">

<form action="https://dreamschat.dreamguystech.com/template2/new-friends">
<div class="form-group">
<label>User Name</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="text">
</div>
<div class="form-group">
<label>Phone Number</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="text">
</div>
</form>

<div class="form-row profile_form text-end float-end m-0 align-items-center">

<div class="cancel-btn me-4">
<a href="#" data-bs-dismiss="modal" aria-label="Close">Cancel</a>
</div>
<div class="">
<button type="button" class="btn btn-block newgroup_create mb-0" data-bs-dismiss="modal" aria-label="Close">
Add User
</button>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="add-contact">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
<span class="material-icons">person_add</span>Add Friends
</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
 <span class="material-icons">close</span>
</button>
</div>
<div class="modal-body">

<form action="https://dreamschat.dreamguystech.com/template2/new-friends">
<div class="form-group">
<label>Name</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="text">
</div>
<div class="form-group">
<label>Nickname</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="text">
</div>
<div class="form-group">
<label>Phone Number</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="text">
</div>
<div class="form-group">
<label>Email</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="email">
</div>
</form>

<div class="form-row profile_form text-end float-end m-0 align-items-center">

<div class="cancel-btn me-4">
<a href="#" data-bs-dismiss="modal" aria-label="Close">Cancel</a>
</div>
<div class="">
<button type="button" class="btn btn-block newgroup_create mb-0" data-bs-dismiss="modal" aria-label="Close">
Add to contacts
</button>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="add-new-group">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
<span class="material-icons group-add-btn">group_add</span>Create a New Group
</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span class="material-icons">close</span>
</button>
</div>
<div class="modal-body">

<form action="https://dreamschat.dreamguystech.com/template2/new-friends">
<div class="form-group">
<label>Group Name</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="text">
</div>
<div class="form-group">
<label>Choose profile picture</label>
<div class="custom-input-file form-control form-control-lg group_formcontrol">
<input type="file" class="">
<span class="browse-btn">Browse File</span>
</div>
</div>
<div class="form-group">
<label>Topic (optional)</label>
<input class="form-control form-control-lg group_formcontrol" name="new-chat-title" type="text">
</div>
 <div class="form-group">
<label>Description</label>
<textarea class="form-control form-control-lg group_formcontrol"></textarea>
</div>
<div class="form-group">
<div class="d-flex align-items-center">
<label class="custom-radio me-3">Private Group
<input type="radio" checked="checked" name="radio">
<span class="checkmark"></span>
</label>
<label class="custom-radio">Public Group
<input type="radio" name="radio">
<span class="checkmark"></span>
</label>
</div>
</div>
</form>

<div class="form-row profile_form text-end float-end m-0 align-items-center">

<div class="cancel-btn me-4">
<a href="#" data-bs-dismiss="modal" aria-label="Close">Cancel</a>
</div>
<div class="">
<button type="button" class="btn btn-block newgroup_create mb-0" data-bs-toggle="modal" data-bs-target="#add-group-member" data-bs-dismiss="modal" aria-label="Close">
Add Participants
</button>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="modal fade custom-border-modal" id="add-group-member">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
<span class="material-icons group-add-btn">group_add</span>Add Group Members
</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span class="material-icons">close</span>
</button>
</div>
<div class="modal-body">
<div class="search_chat has-search me-0 ms-0">
<span class="fas fa-search form-control-feedback"></span>
<input class="form-control chat_input" id="search-contact1" type="text" placeholder="Search Contacts">
</div>
<div class="sidebar">
<span class="contact-name-letter">A</span>
<ul class="user-list mt-2">
<li class="user-list-item">
<div class="avatar avatar-online">
<img src="assets/messenger/img/avatar/avatar-1.jpg" class="rounded-circle" alt="image">
</div>
<div class="users-list-body align-items-center">
<div>
<h5>Albert Rodarte</h5>
</div>
<div class="last-chat-time">
<label class="custom-check">
<input type="checkbox" checked="checked">
<span class="checkmark"></span>
 </label>
</div>
</div>
</li>
<li class="user-list-item">
<div class="avatar avatar-online">
<img src="assets/messenger/img/avatar/avatar-2.jpg" class="rounded-circle" alt="image">
</div>
<div class="users-list-body align-items-center">
<div>
<h5>Allison Etter</h5>
</div>
<div class="last-chat-time">
<label class="custom-check">
<input type="checkbox">
<span class="checkmark"></span>
</label>
</div>
</div>
</li>
</ul>
<span class="contact-name-letter mt-3">C</span>
<ul class="user-list mt-2">
<li class="user-list-item">
<div class="avatar avatar-online">
<img src="assets/messenger/img/avatar/avatar-3.jpg" class="rounded-circle" alt="image">
</div>
<div class="users-list-body align-items-center">
<div>
<h5>Craig Smiley</h5>
</div>
<div class="last-chat-time">
<label class="custom-check">
<input type="checkbox">
<span class="checkmark"></span>
</label>
</div>
</div>
</li>
<li class="user-list-item">
<div class="avatar avatar-online">
<img src="assets/messenger/img/avatar/avatar-4.jpg" class="rounded-circle" alt="image">
</div>
<div class="users-list-body align-items-center">
<div>
<h5>Caniel Clay</h5>
</div>
<div class="last-chat-time">
<label class="custom-check">
<input type="checkbox">
<span class="checkmark"></span>
</label>
</div>
</div>
</li>
</ul>
</div>
<div class="form-row profile_form text-end float-end m-0 mt-3 align-items-center">

<div class="cancel-btn me-3">
<a href="#" data-bs-dismiss="modal" aria-label="Close">Cancel</a>
</div>
<div class="">
<button type="button" class="btn newgroup_create previous mb-0 me-3" data-bs-toggle="modal" data-bs-target="#add-new-group" data-bs-dismiss="modal" aria-label="Close">
 Previous
</button>
</div>
<div class="">
<button type="button" class="btn btn-block newgroup_create mb-0" data-bs-dismiss="modal" aria-label="Close">
Create Group
</button>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="video_call" role="document">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content voice_content">
<div class="modal-body voice_body">
<div class="call-box incoming-box">
<div class="call-wrapper">
<div class="call-inner">
<div class="call-user">
<img alt="User Image" id="vdc_img" src="images/default.png" class="call-avatar">
<h4><span id="vdc_username">Username</span> <span>video calling</span>
</h4>
</div>
<div class="call-items">
<a href="#" class="btn call-item call-end" data-bs-dismiss="modal" id="vcall_canceled"><span class="material-icons">close</span></a>
<a href="#" class="btn call-item call-start"><i class="fas fa-video"></i></a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="voice_call" role="document">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content voice_content">
<div class="modal-body voice_body">
<div class="call-box incoming-box">
<div class="call-wrapper">
<div class="call-inner">
<div class="call-user">
<img alt="User Image" src="assets/messenger/img/avatar/avatar-8.jpg" class="call-avatar">
<h4>Brietta Blogg <span>voice calling</span>
</h4>
</div>
<div class="call-items">
<a href="#" class="btn call-item call-end" data-bs-dismiss="modal">
<span class="material-icons">close</span>
</a>
<a href="#" class="btn call-item call-start" data-bs-dismiss="modal">
<i class="fas fa-video"></i>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include('partials/messenger/footer.php'); ?>
</body>
</html>

<?php } ?>