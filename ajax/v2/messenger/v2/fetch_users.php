<?php
session_start();
require '../../../../config/database.php';
require '../../../../includes/functions.php';
extract($_POST);

if (isset($_POST["limit"], $_POST["start"])) {
    $q = $db->prepare("SELECT * FROM conversations_tb WHERE user_id1= :user_id1 OR user_id2= :user_id1
                  ORDER BY id DESC LIMIT " . $_POST["start"] . ", " . $_POST["limit"] . "");
    $q->execute([
        'user_id1' => $_SESSION['user_id']
    ]);
    $conversations = $q->fetchAll(PDO::FETCH_OBJ);
    $output = '';

    if (count($conversations) != 0) {
        foreach ($conversations as $row) {

            $status = '';
            $current_timestamp = strtotime(date('Y-m-d H:i:s') . '-25 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $user_last_activity = fetch_user_last_activity($row->user, $db);

            if ($user_last_activity > $current_timestamp) {
                $status = 'avatar-online';
            } else {
                $status = 'avatar-away';
            }

            if ($row->user_id1 != $_SESSION['user_id']) {
                $user = find_user_by_id($row->user_id1);
            } elseif ($row->user_id2 != $_SESSION['user_id']) {
                $user = find_user_by_id($row->user_id2);
            }

            $chat = latest_chat_messages($user->id, $_SESSION['user_id']);

            if ($user->id != $_SESSION['user_id']) {

                $output .= '
                  <li class="user-list-item open-chat" data-to_user_id="' . $user->id . '" data-data-uid="' . $user->id . '" data-from_user_id="' . $_SESSION['user_id'] . '" data-username="' . substr(e($user->name) . ' ' . e($user->nom2), 0, 15) . '" data-image_path="' . e($user->profilepic) . '" data-c_i="' . $row->id . '" data-userphone="' . $user->phoneNumber . '" data-bio="' . $user->bio . '">
                        <div class="avatar ' . $status . '">
                            <img src="' . e($user->profilepic) . '" class="rounded-circle" alt="image">
                        </div>
                        <div class="users-list-body">
                            <div>
                                <h5>' . substr(e($user->name) . ' ' . e($user->nom2), 0, 15) . '</h5>
                                ' . fetch_is_type_status_v2($user->id, $db) . '
                                <p>' . substr(e($chat->chat_message), 0, 15) . '...</p>
                            </div>
                            <div class="last-chat-time">
                                <small class="text-muted">' . zungvi_time_ago($chat->created_at) . '</small>
                                <div class="new-message-count">' . unseen_message_2_vs_2($row->id, $_SESSION['user_id']) . '</div>
                            </div>
                        </div>
                    </li>
		         ';
            }
        }
    }

    $output .= '';

    echo $output;
}
