<?php
session_start();
require '../../../../config/database.php';
require '../../../../includes/functions.php';
extract($_POST);

if (isset($_POST["limit"], $_POST["start"])) {

    $q = $db->prepare("SELECT * FROM chat_message
                  WHERE conversation_id= " . $_POST['c_i'] . " 
                  ORDER BY created_at DESC
	              LIMIT " . $_POST["start"] . ", " . $_POST["limit"] . "
	            ");

    $q->execute();
    $messages = $q->fetchAll(PDO::FETCH_OBJ);
    $q->closecursor();

    $output = '';

    $reversed_array = array_reverse($messages);

    foreach ($reversed_array as $message) {

        $user1 = find_user_by_id($message->from_user_id);
        $time = strtotime($message->created_at);
        $getDate = date('Y-m-d', $time);
        $getHour = date('H', $time);
        $getMinute = date('i', $time);

        if ($message->status == 1) {
            $read = "";
        } else if ($message->status == 0) {
            $read = '<div class="chat-read-col">
        <span class="material-icons">done_all</span>
        </div>';
        }

        if ($from_user_id == $message->from_user_id) {

            $output .= '<div class="chats chats-right" id="msg_box' . $message->id . '">
            <div class="chat-content">
            <div class="message-content" id="msg_content' . $message->id . '">
            ' . $message->chat_message . '
            <div class="chat-time">
            <div>
            <div class="time"><i class="fas fa-clock"></i>' . $getHour . ':' . $getMinute . '</div>
            </div>
            </div>
            </div>
            <div class="chat-profile-name text-end">
            <h6>' . $user1->name . '</h6>
            </div>
            </div>
            <div class="chat-avatar">
            <img src="' . $user1->profilepic . '" class="rounded-circle dreams_chat" alt="image">
            </div>
            <div class="chat-action-btns me-2">
            <div class="chat-action-col">
            <a class="#" href="#" data-bs-toggle="dropdown">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
            <a href="#" class="dropdown-item dream_profile_menu copy_msg" data-clipboard-target="#msg_content' . $message->id . '">Copy <span><i class="far fa-copy"></i></span></a>
            <a href="#" class="dropdown-item delete_msg" data-msg_id="' . $message->id . '" data-msg_owner="' . $message->from_user_id . '">Delete <span><i class="far fa-trash-alt"></i></span></a>
            </div>
            </div>
            ' . $read . '
            </div>
            </div>';
        } else {

            $output .= '<div class="chats">
            <div class="chat-avatar">
            <img src="' . $user1->profilepic . '" class="rounded-circle dreams_chat" alt="image">
            </div>
            <div class="chat-content">
            <div class="message-content" id="msg_content' . $message->id . '">
            ' . $message->chat_message . '
            <div class="chat-time">
            <div>
            <div class="time"><i class="fas fa-clock"></i> ' . $getHour . ':' . $getMinute . '</div>
            </div>
            </div>
            </div>
            <div class="chat-profile-name">
            <h6>' . $user1->name . ' ' . $user1->nom2 . '</h6>
            </div>
            </div>
            <div class="chat-action-btns ms-3">
            <div class="chat-action-col">
            <a class="#" href="#" data-bs-toggle="dropdown">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
            <a href="#" class="dropdown-item dream_profile_menu copy_msg" data-clipboard-target="#msg_content' . $message->id . '">Copy <span><i class="far fa-copy"></i></span></a>
            </div>
            </div>
            </div>
            </div>';
        }

        if ($message->conversation_id == null) {
            $query = "
            UPDATE chat_message
            SET conversation_id = " . $_POST['c_i'] . "
            WHERE from_user_id = '" . $from_user_id . "'
            AND to_user_id = '" . $to_user_id . "'
            ";
            $statement = $db->prepare($query);
            $statement->execute();
        }
    }

    $query = "
    UPDATE chat_message
    SET status = '0'
    WHERE from_user_id = '" . $to_user_id . "'
    AND to_user_id = '" . $from_user_id . "'
    AND status = '1'
    ";
    $statement = $db->prepare($query);
    $statement->execute();

    echo $output;
}
