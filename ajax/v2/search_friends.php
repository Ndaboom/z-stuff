<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

$q = $db->prepare('SELECT id,email, name,nom2, created_at,profilepic FROM users
	               WHERE (name LIKE :query OR nom2 LIKE :query OR email LIKE :query)
	               LIMIT 5
	               ');
$q->execute([
             'query'=> '%'.$query.'%'
]);

$users = $q->fetchAll(PDO::FETCH_OBJ);

if (count($users)>0) {
	foreach ($users as $user) {
	    if(!is_already_in_forum(get_session('fr_i'), $user->id)){
	        if(!forum_invitation_already_sent(get_session('fr_i'), $user->id, "join_forum_request")){
?>
  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
    <a href="timeline.php?id=<?= $user->id ?>'" href="timeline.php?id=<?= $user->id ?>"iv class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
        <img src="/<?= e($user->profilepic) ?>" class="absolute w-full h-full inset-0 " alt="">
    </a>
    <div class="flex-1">
        <a href="timeline.php?id=<?= $user->id ?>" class="text-base font-semibold capitalize">  <?= e($user->name) ?> <?= e($user->nom2) ?> </a>
    </div>
    <a href="" id="iButt<?= $user->id ?>" data-user_id="<?= $user->id ?>"
        class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold invite_friends">
        Invite
    </a>
    <small class="text-green-600" style="display:none;" id="conf<?= $user->id ?>">invitation sent</small>
  </div>  
<?php
	    }
	}
}
}else{
	echo '<div class="display-box text-center">No user found! sorry.</div>';
}

?>
