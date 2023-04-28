<!DOCTYPE html>
    <html lang="en">
    <?php
    if ($notifications_count > 0) {
        $notifications_nbr = "(" . $notifications_count . ")";
        $notifs_number = $notifications_nbr;
    } else {
        $notifications_nbr = "";
    }
    $title = "Appel";
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
<a href="messages.php?id=<?= $_SESSION['user_id'] ?>" class="chat-unread blue">
<span class="material-icons">message</span>
<span>Chats</span>
</a>
</li>
</ul>
</div>
<div class="bottom-menus">
<ul>
<li>
<a href="#" class="chat-profile-icon" data-bs-toggle="dropdown">
<img src="/<?= $user->profilepic ?>" style="height:50px;width:50px;" alt="">
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

<div class="chat video-screen" id="middle">
<div class="chat-header">
<div class="chat-options">
<ul class="list-inline">
<li class="list-inline-item in-a-call d-flex align-items-center me-5">
<span class="icon-call"><i class="fas fa-phone-alt"></i></span>
<span class="call-text">in call : 1</span>
</li>
<li class="list-inline-item">
<a href="#" class="add-person-call no-bg d-flex align-items-center dream_profile_menu">
<span class="icon-call"><i class="fas fa-plus"></i></span>
<span class="call-text">Add person to call</span>
</a>
</li>
</ul>
</div>
</div>
<div class="chat-body pt-4 pb-0">
<video class="video-screen-inner" id="local_video">
<div class="call-user-avatar">
<div class="avatar-col">
<img src="/<?= $receiver->profilepic ?>" alt="">
</div>
</div>
<div class="record-time">
<span>0:12</span>
</div>
<div class="video-call-action">
<ul>
<li><a href="#"><span class="material-icons">fullscreen</span></a></li>
<li><a href="#" class="call-mute"><span class="material-icons">volume_off</span></a></li>
<li><a href="#" class="call-end"><span class="material-icons">call_end</span></a></li>
<li><a href="#"><span class="material-icons">videocam_off</span></a></li>
</ul>
</div>
</video>
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

<form action="#">
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

<form action="#">
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
<img src="assets/img/avatar/avatar-1.jpg" class="rounded-circle" alt="image">
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
<img src="assets/img/avatar/avatar-2.jpg" class="rounded-circle" alt="image">
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
<img src="assets/img/avatar/avatar-3.jpg" class="rounded-circle" alt="image">
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
<img src="assets/img/avatar/avatar-4.jpg" class="rounded-circle" alt="image">
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
<img alt="User Image" src="assets/img/avatar/avatar-8.jpg" class="call-avatar">
<h4>Brietta Blogg <span>video calling</span>
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


<div class="modal fade" id="voice_call" role="document">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content voice_content">
<div class="modal-body voice_body">
<div class="call-box incoming-box">
<div class="call-wrapper">
<div class="call-inner">
<div class="call-user">
<img alt="User Image" src="assets/img/avatar/avatar-8.jpg" class="call-avatar">
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
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script>
    'use strict';
let pc;
let sendTo = '<?= $_GET['u'] ?>';
let local_stream;

//Web socket connection 
const conn = new WebSocket('wss://zungvi.com:8080/?token=<?= $_SESSION['user_id'] ?>');

//video elements 

const local_video = document.querySelector("#local_video");
const remote_video = document.querySelector("#remote_video");

const mediaConst = {
    video:true
};

function getConn(){
    if(!pc){
        pc = new RTCPeerConnection();
    }
}

async function getCam(){
    let mediaStream;
    try{
        if(!pc){
            await getConn();
        }

        mediaStream = await navigator.mediaDevices.getUserMedia(mediaConst)
        local_video.srcObject = mediaStream
        local_stream - mediaStream
        local_stream.getTracks().forEach( track => pc.addTrack(track, local_stream));

    }catch(error){
        console.log(error)
    }
}

getCam();

conn.onopen = e =>{
    console.log('connected to websocket');
}

conn.onmessage = e =>{

}

function send(type, data, sendTo){
    conn.send(JSON.stringify({
        sendTo:sendTo,
        type:type,
        data:data
    }));
}
</script>
<?php include('partials/messenger/footer.php'); ?>
</body>
</html>
