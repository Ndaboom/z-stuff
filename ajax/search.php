<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
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
	echo '<h4 class="font-semibold mb-1 mt-2 px-2.5 text-lg"> Search "'.$query.'"  </h4>

  <ul>';
	foreach ($users as $user) {
?>
   <li>
      <a href="timeline.php?id=<?= $user->id ?>" class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md"> 

          <img src="/<?= e($src =($user->profilepic != null) ? $user->profilepic : 'images/default.png') ?>" alt="" class="border mr-3 rounded-full shadow-sm w-8">

          <?= e($user->name) ?> <?= e($user->nom2) ?>

      </a>

  </li>
<?php
}
  echo '</ul>
      ';
}else{
	echo '
	';
}

?>
