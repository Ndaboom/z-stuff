<?php
//require_once('simple_image.php');

//Fonction pour trouver un utilisateur par id
if (!function_exists('find_user_by_id')) {
	function find_user_by_id($id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM users WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour selectionner un les infos d'un event par id
if (!function_exists('find_event_by_id')) {
	function find_event_by_id($id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM events WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour trouver une place par id
if (!function_exists('find_place_by_id')) {
	function find_place_by_id($id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM places WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();

		return $data;
	}
}

//Fonction pour trouver un article par id
if (!function_exists('find_article_by_id')) {
	function find_article_by_id($id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM articles WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour recuperer une tele par id
if (!function_exists('find_channel_by_id')) {
	function find_channel_by_id($id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM channels_tb WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour recuperer un jeu par id
if (!function_exists('find_game_by_id')) {
	function find_game_by_id($id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM games_tb WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour recuperer les articles par categorie
if (!function_exists('fetch_articles_by_category')) {
	function fetch_articles_by_category($category)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM articles WHERE category like :category');
		$q->execute(['category' => '%' . $category . '%']);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour trouver un article par l'author
if (!function_exists('find_article_by_author')) {
	function find_article_by_author($author_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM articles WHERE user_id=?');
		$q->execute([$author_id]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour recuperer toutes les articles avec limite
if (!function_exists('fetch_all_articles')) {
	function fetch_all_articles($limit, $start)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM articles
	                 ORDER BY posted_at DESC
	                 LIMIT ' . $start . ', ' . $limit . '');
		$q->execute();
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour recuperer toutes les articles avec limite
if (!function_exists('fetch_article_comments')) {
	function fetch_article_comments($limit, $start, $article_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM article_comments
	                 WHERE article_id= ' . $article_id . ' 
	                 ORDER BY commented_at ASC
	                 LIMIT ' . $start . ', ' . $limit . '');
		$q->execute();
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour recuperer les reponses aux commentaires
if (!function_exists('fetch_article_comments_reply')) {
	function fetch_article_comments_reply($limit, $start, $comment_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM article_comments_reply
	                 WHERE comment_id= ' . $comment_id . ' 
	                 ORDER BY commented_at ASC
	                 LIMIT ' . $start . ', ' . $limit . '');
		$q->execute();
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour trouver un utilisateur par id
if (!function_exists('find_user_by_email')) {
	function find_user_by_email($email)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM users WHERE email=?');
		$q->execute([$email]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour verifier si un utilisateur est active
if (!function_exists('is_user_activated_email')) {
	function is_user_activated_email($id)
	{
		global $db;
		$q = $db->prepare('SELECT active FROM users WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		if ($data->active == 1) {
			return true;
		} else {
			return false;
		}
	}
}

// Fonction pour compter les nombres de followers d'une place avec parametre
if (!function_exists('event_followers_count')) {
	function event_followers_count($event_id)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM event_followers
                              WHERE event_id = :event_id
                              AND status ='1'");
		$q->execute([
			'event_id' => $event_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

// Fonction pour verifier si l'ulisateur suit deja une activite
if (!function_exists('an_event_has_already_been_followed')) {
	function an_event_has_already_been_followed($event_id, $id)
	{
		global $db;
		$q = $db->prepare("SELECT created_at FROM event_followers
	                            WHERE event_id = :event_id AND user_id = :user_id1 AND status = :status");
		$q->execute([
			'event_id' => $event_id,
			'user_id1' => $id,
			'status' => 1
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		$q->closeCursor();
	}
}


//Fonction pour compter les nombres de commandes en cours
if (!function_exists('orders_count')) {
	function orders_count($user_id, $place_id)
	{
		global $db;
		$q = $db->prepare("SELECT * FROM place_orders
                 WHERE user_id= :user_id AND place_id= :place_id AND is_send= :is_send
                 ");
		$q->execute([
			'user_id' => $user_id,
			'place_id' => $place_id,
			'is_send' => '0'
		]);
		$data = $q->rowCount();
		return $data;
	}
}

//Fonction pour recuperer les commandes en cours
if (!function_exists('get_orders')) {
	function get_orders($place_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM place_orders
                   WHERE place_id= :place_id AND is_send= :is_send AND is_received= :is_received');
		$q->execute([
			'place_id' => $place_id,
			'is_send' => 1,
			'is_received' => 0
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

// Fonction pour compter les nombres de followers d'une place avec parametre
if (!function_exists('followers_count2')) {
	function followers_count2($place_id)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM places_followers
                              WHERE place_id = :place_id
                              AND status ='1'");
		$q->execute([
			'place_id' => $place_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

//Fonction pour recuperer les info d'un produit par id
if (!function_exists('find_product_by_id')) {
	function find_product_by_id($id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM marketplace WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Function pour verifier si un utilisateur a deja la views notifications
if (!function_exists('views_notifications')) {
	function views_notifications($user_id)
	{

		// initialisation de la variable $Db
		global $db;

		// verification de l'exesitance par query
		$q = $db->prepare("SELECT subject_id,name,user_id FROM notifications
                         WHERE subject_id = :subject_id AND name= :name AND user_id= :user_id");
		$q->execute([
			'subject_id' => $_GET['id'],
			'name' => 'viewed_your_profile',
			'user_id' => $user_id,
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

//Function pour verifier si un utlilisateur est deja membre d'un forum -- deprecated function
if (!function_exists('already_in_forum')) {
	function already_in_forum($user_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM forum_members WHERE user_id= :user_id AND etat= :etat');
		$q->execute([
			'user_id' => $user_id,
			'etat' => 1
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		return $data;
	}
}

// Fonction pour incrementer channel view
if (!function_exists('channel_viewed')) {
	function channel_viewed($channel_id)
	{
		global $db;

		$q = $db->prepare('UPDATE channels_tb
					SET views= views+1
					WHERE id= :channel_id');
		$q->execute([
			'channel_id' => $channel_id
		]);
	}
}

//Fonction pour trouver une place by name
if (!function_exists('find_place_by_name')) {
	function find_place_by_name($place_name)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM places WHERE place_name=?');
		$q->execute([$place_name]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Fonction pour recuperer les messages non lues dans un forum
if (!function_exists('unseen_msg')) {
	function unseen_msg($forum_id, $user_id)
	{
		global $db;
		$query = "
            SELECT * FROM unseen_forum
            WHERE forum_id= '$forum_id'
            AND user_id= '.$user_id.'
            AND seen = '0'
           ";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$output = '';
		if ($count > 0) {
			$output = '' . $count . '';
		}
		return $output;
	}
}

//Function pour compter le nombre des msgs non-lues dans un forum
if (!function_exists('unread_forum_msg')) {
	function unread_forum_msg($forum_id, $user_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM unseen_forum
                                 WHERE forum_id= :forum_id AND user_id= :user_id
                                 AND seen= :seen
                               ');
		$q->execute([
			'forum_id' => $forum_id,
			'user_id' => $user_id,
			'seen' => 0
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

//Fonction pour recuperer les donnees d'une publication par son id
if (!function_exists('get_post_data')) {
	function get_post_data($post_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM microposts WHERE id=?');
		$q->execute([$post_id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}
//Function for image compression
if (!function_exists('compress')) {
	function compress($source_image, $compress_image)
	{
		$image_info = getimagesize($source_image);

		if ($image_info['mime'] == 'image/jpeg') {
			$source_image = imagecreatefromjpeg($source_image);
			imagejpeg($source_image, $compress_image, 35);
		} else if ($image_info['mime'] == 'image/gif') {
			$source_image = imagecreatefromgif($source_image);
			imagegif($source_image, $compress_image, 35);
		} else if ($image_info['mime'] == 'image/png') {
			$source_image = imagecreatefrompng($source_image);
			imagepng($source_image, $compress_image, 6);
		}
	}
}

// function pour recuperer les informations d'une place
if (!function_exists('selectCurrentPlace')) {
	function selectCurrentPlace()
	{
		global $db;
		$current_place = $_GET['pl_i'];
		$q = $db->prepare('SELECT * FROM places WHERE id= :current_place');
		$q->execute([
			'current_place' => $current_place
		]);
		$places = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $places;
	}
}

// function pour recuperer les informations d'une placepost
if (!function_exists('fetch_place_post_data')) {
	function fetch_place_post_data($placepost_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM placeposts WHERE id= :current_post');
		$q->execute([
			'current_post' => $placepost_id
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}
// function pour recuperer toutes les photos de profil deja postee par un user
if (!function_exists('selectUserProfilePics')) {
	function selectUserProfilePics($user_id)
	{
		global $db;
		$current_place = $_GET['name'];
		$q = $db->prepare('SELECT * FROM profilePics WHERE user_id = :user_id');
		$q->execute([
			'user_id' => $user_id
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Function pour verifier si un utlilisateur est deja membre d'un forum
if (!function_exists('already_in_forum')) {
	function already_in_forum($user_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM forum_members WHERE user_id= :user_id AND etat= :etat');
		$q->execute([
			'user_id' => $user_id,
			'etat' => 1
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		return $data;
	}
}

// function pour recuperer les informations d'une place au travers de la methode post
if (!function_exists('zungvi_time_ago')) {
	function zungvi_time_ago($timestamp)
	{
		$timeago = strtotime($timestamp);
		$current_time = time();
		$time_difference = $current_time - $timeago;
		$seconds   = $time_difference;
		$minutes   = round($seconds / 60);
		$hours     =  round($seconds / 3600);
		$days      = round($seconds / 86400);
		$weeks     = round($seconds / 604800);
		$months    = round($seconds / 2629440);
		$years     = round($seconds / 31553280);

		if ($seconds <= 60) {
			return "just now";
		} else if ($minutes <= 60) {
			if ($minutes == 1) {
				return "One minute ago";
			} else {
				return "$minutes minutes ago";
			}
		} else if ($hours <= 24) {
			if ($hours == 1) {
				return "an hour ago";
			} else {
				return "$hours hrs ago";
			}
		} else if ($days <= 7) {
			if ($days == 1) {
				return "yesterday";
			} else {
				return "$days days ago";
			}
		} else if ($weeks <= 4.3) {
			if ($weeks == 1) {
				return "a week ago";
			} else {
				return "$weeks weeks ago";
			}
		} else if ($months <= 12) {
			if ($months == 1) {
				return "a month ago";
			} else {
				return "$months months ago";
			}
		} else {
			if ($years == 1) {
				return "one year ago";
			} else {
				return "$years years ago";
			}
		}
	}
}

// function pour recuperer les informations d'une place au travers de la methode post
if (!function_exists('short_time_ago')) {
	function short_time_ago($timestamp)
	{
		$timeago = strtotime($timestamp);
		$current_time = time();
		$time_difference = $current_time - $timeago;
		$seconds   = $time_difference;
		$minutes   = round($seconds / 60);
		$hours     =  round($seconds / 3600);
		$days      = round($seconds / 86400);
		$weeks     = round($seconds / 604800);
		$months    = round($seconds / 2629440);
		$years     = round($seconds / 31553280);

		if ($seconds <= 60) {
			return "few sec";
		} else if ($minutes <= 60) {
			if ($minutes == 1) {
				return "One minute";
			} else {
				return "$minutes minutes";
			}
		} else if ($hours <= 24) {
			if ($hours == 1) {
				return "an hour";
			} else {
				return "$hours hrs";
			}
		} else if ($days <= 7) {
			if ($days == 1) {
				return "yesterday";
			} else {
				return "$days days";
			}
		} else if ($weeks <= 4.3) {
			if ($weeks == 1) {
				return "a week";
			} else {
				return "$weeks weeks";
			}
		} else if ($months <= 12) {
			if ($months == 1) {
				return "a month";
			} else {
				return "$months months";
			}
		} else {
			if ($years == 1) {
				return "one year";
			} else {
				return "$years years";
			}
		}
	}
}
//Function pour recuperer les informations d'une place par son id
if (!function_exists('selectPlaceDataById')) {
	function selectPlaceDataById($place_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM places WHERE id= :current_place');
		$q->execute([
			'current_place' => $place_id
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Function pour recuperer les informations d'une place par son id
if (!function_exists('selectPlaceDataById2')) {
	function selectPlaceDataById2($place_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM places WHERE id= :current_place');
		$q->execute([
			'current_place' => $place_id
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

//Function pour recuperer les top 6 places 
if (!function_exists('selectTop6Places')) {
	function selectTop6Places()
	{
		global $db;
		$q = $db->prepare('SELECT * FROM places ORDER BY place_views DESC LIMIT 6');
		$q->execute();
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

// function pour recuperer un forum en fonction du nom passer a $_GET
if (!function_exists('selectCurrentForumData')) {
	function selectCurrentForumData()
	{
		global $db;
		$current_forum = $_GET['name'];
		$q = $db->prepare('SELECT * FROM forums WHERE forum_name= :current_forum');
		$q->execute([
			'current_forum' => $current_forum
		]);
		$forums = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $forums;
	}
}

// function pour recuperer les forums dans lequels un user est
if (!function_exists('getUserForumsData')) {
	function getUserForumsData()
	{
		global $db;
		$q = $db->prepare('SELECT F.forum_name,F.description,F.forum_pic,F.id, F.created_at
                          FROM forums F, forum_members M
                          WHERE F.id= M.forum_id

                          AND
                          M.user_id= :user_id

                          AND M.etat = 1
                          ORDER BY F.id DESC');
		$q->execute([
			'user_id' => get_session('user_id')
		]);
		$forums = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $forums;
	}
}
//Fonction pour compter le nombre de commentaires
if (!function_exists('count_comment')) {
	function count_comment($db, $post_id)
	{
		$query = "
             SELECT * FROM comments
             WHERE post_id ='" . $post_id . "'
		   	";
		$statement = $db->prepare($query);
		$statement->execute();

		return $statement->rowCount();
	}
}

//Fonction pour recuperer 3 reactions sur un sujet
if (!function_exists('getUserForumReaction')) {
	function getUserForumReaction($subject_id)
	{
		global $db;
		$q = $db->prepare('SELECT id,user_id,content_text,content_img,like_count,created_at
                  FROM forum_reactions
                  WHERE forum_id= :forum_id AND subject_id= :subject_id
                  LIMIT 3');
		$q->execute([
			'forum_id' => get_session('fr_i'),
			'subject_id' => $subject_id
		]);
		$reactions = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $reactions;
	}
}

//Fonction pour recuperer toutes les reactions sur un sujet
if (!function_exists('getAllUserForumReaction')) {
	function getAllUserForumReaction()
	{
		global $db;
		$q = $db->prepare('SELECT id,user_id,content_text,content_img,like_count,created_at
                  FROM forum_reactions
                  WHERE forum_id= :forum_id AND subject_id= :subject_id');
		$q->execute([
			'forum_id' => get_session('fr_i'),
			'subject_id' => $_GET['rid']
		]);
		$reactions = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $reactions;
	}
}

// Fonction pour selectionner la photo de profil de l'utilisateur
if (!function_exists('selectUserProfilePic')) {
	function selectUserProfilePic($id)
	{
		global $db;
		$q = $db->prepare('SELECT profilepic FROM users WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

// Fonction pour selectionner le poster d'un sujet dans un forum
if (!function_exists('selectSubjectPoster')) {
	function selectSubjectPoster($id)
	{
		global $db;
		$q = $db->prepare('SELECT name FROM users WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}
// Fonction pour selectionner la photo de couverture de la place actuelle
if (!function_exists('selectCurrentPlaceCover')) {
	function selectCurrentPlaceCover($id)
	{
		global $db;
		$q = $db->prepare('SELECT coverpic FROM places WHERE id=?');
		$q->execute([$id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

// Fonction pour verifier que l'ulisateur utilise des balises html
if (!function_exists('e')) {
	function e($string)
	{
		if ($string) {
			return htmlspecialchars($string);
		}
	}
}

//Fonction pour selectionner le premier nom d'un user
if (!function_exists('get_user_name')) {
	function get_user_name($user_id)
	{
		global $db;

		$q = $db->prepare('SELECT name FROM users
			   	                WHERE id= :id');
		$q->execute(['id' => $user_id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		return $data;
	}
}

//Fonction pour prendre le nom d'un forum par l id
if (!function_exists('get_forum_name')) {
	function get_forum_name($forum_id)
	{
		global $db;

		$q = $db->prepare('SELECT * FROM forums
			   	                WHERE id= :id');
		$q->execute(['id' => $forum_id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		return $data;
	}
}

//Fonction pour prendre le nom d'un forum par l id
if (!function_exists('get_forum_pic')) {
	function get_forum_pic($forum_id)
	{
		global $db;

		$q = $db->prepare('SELECT forum_pic FROM forums
			   	                WHERE id= :id');
		$q->execute(['id' => $forum_id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		return $data;
	}
}
//Fonction pour selectionner le second nom d'un user
if (!function_exists('get_user_second_name')) {
	function get_user_second_name($user_id)
	{
		global $db;

		$q = $db->prepare('SELECT nom2 FROM users
			   	                WHERE id= :id');
		$q->execute(['id' => $user_id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		return $data;
	}
}
// Fonction pour compter le nombre des likers d'un post
if (!function_exists('get_like_count')) {
	function get_like_count($micropost_id)
	{
		global $db;

		$q = $db->prepare('SELECT like_count FROM microposts
			   	                WHERE id= :id');
		$q->execute(['id' => $micropost_id]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		return intval($data->like_count);
	}
}

// Fonction pour afficher les likers d'un post
if (!function_exists('get_likers')) {
	function get_likers($micropost_id)
	{
		global $db;

		$q = $db->prepare('SELECT users.id,users.nom2, users.profilepic
			   	                 FROM users
			   	                 LEFT JOIN micropost_like
			   	                 ON users.id = micropost_like.user_id
			   	                 WHERE micropost_like.micropost_id= ?
			   	                 LIMIT 3');
		$q->execute([$micropost_id]);
		return $q->fetchAll(PDO::FETCH_OBJ);
	}
}

// Fonction verifier si un utilisateur a deja envoye une demande d'admission dans un forum
if (!function_exists('if_already_sent')) {
	function if_already_sent($forum_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM forum_members
			   	                 WHERE user_id= ? AND forum_id = ?');
		$q->execute([get_session('user_id'), $forum_id]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction verifier si un utilisateur a deja aimer un commentaire d'une personne donnee
if (!function_exists('if_already_liked')) {
	function if_already_liked($user_id, $comment_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM notifications
			   	                 WHERE user_id= :user_id AND name= :name AND comment_id= :comment_id');
		$q->execute([
			'user_id' => $user_id,
			'name' => "comment_liked",
			'comment_id' => $comment_id
		]);
		$count = $q->rowCount();
		$q->closeCursor();
		return (bool) $count;
	}
}

// Fonction pour verifier si un utilisateur a deja valider une reaction sur un sujet dans un forum
if (!function_exists('already_validate')) {
	function already_validate($reaction_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM reaction_like
			   	                 WHERE user_id= :user_id AND forum_id = :forum_id AND reaction_id= :reaction_id
			   	                 AND type= :type');
		$q->execute([
			'user_id' => get_session('user_id'),
			'forum_id' => get_session('fr_i'),
			'reaction_id' => $reaction_id,
			'type' => "valide"
		]);
		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour verifier si un utilisateur est deja dans le login details
if (!function_exists('already_in_login_details')) {
	function already_in_login_details($user_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM login_details
			   	                WHERE user_id = :user_id
			   	                ');
		$q->execute([
			'user_id' => $user_id
		]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour verifier si un utilisateur a deja valider une reaction sur un sujet dans un forum
if (!function_exists('already_denied')) {
	function already_denied($reaction_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM reaction_like
			   	                 WHERE user_id= :user_id AND forum_id = :forum_id AND reaction_id= :reaction_id
			   	                 AND type= :type');
		$q->execute([
			'user_id' => get_session('user_id'),
			'forum_id' => get_session('fr_i'),
			'reaction_id' => $reaction_id,
			'type' => "denied"
		]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour verifier si un utilisateur est deja satisfait avec une reaction
if (!function_exists('already_satisfied')) {
	function already_satisfied($reaction_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM reaction_like
			   	                 WHERE user_id= :user_id AND forum_id = :forum_id AND reaction_id= :reaction_id
			   	                 AND type= :type');
		$q->execute([
			'user_id' => get_session('user_id'),
			'forum_id' => get_session('fr_i'),
			'reaction_id' => $reaction_id,
			'type' => "satisfied"
		]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}
//Function pour compter le nombre de validation d'une reaction
if (!function_exists('reaction_validation_count')) {
	function reaction_validation_count($reaction_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM reaction_like
			   	                 WHERE  reaction_id= :reaction_id
			   	                 AND type= :type');
		$q->execute([
			'reaction_id' => $reaction_id,
			'type' => "valide"
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

//Function pour compter le nombre des refus d'une reaction
if (!function_exists('reaction_denied_count')) {
	function reaction_denied_count($reaction_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM reaction_like
			   	                 WHERE  reaction_id= :reaction_id
			   	                 AND type= :type');
		$q->execute([
			'reaction_id' => $reaction_id,
			'type' => "denied"
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

//Function pour compter le nombre des posts non vus
if (!function_exists('unviewed_post')) {
	function unviewed_post($forum_id, $user_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM new_forum_post
                                 WHERE forum_id= :forum_id AND user_id= :user_id
                                 AND seen= :seen
                               ');
		$q->execute([
			'forum_id' => $forum_id,
			'user_id' => $user_id,
			'seen' => 0
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

//Function pour compter le nombre des placeposts non vus
if (!function_exists('unviewed_placepost')) {
	function unviewed_placepost($place_id, $user_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM new_place_post
                                 WHERE place_id= :place_id AND user_id= :user_id
                                 AND seen= :seen
                               ');
		$q->execute([
			'place_id' => $place_id,
			'user_id' => $user_id,
			'seen' => 0
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}


//Function pour compter le nombre des satisfation d'une reaction
if (!function_exists('reaction_satisfied_count')) {
	function reaction_satisfied_count($reaction_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM reaction_like
			   	                 WHERE  reaction_id= :reaction_id
			   	                 AND type= :type');
		$q->execute([
			'reaction_id' => $reaction_id,
			'type' => "satisfied"
		]);

		$count = $q->rowCount();
		$q->closeCursor();

		return $count;
	}
}

//Fonction pour prendre les commentaires d'un forumpost dans la base des donnees
if (!function_exists('getAllForumComment')) {
	function getAllForumComment($forum_id, $reactionId)
	{
		global $db;
		$q = $db->prepare('SELECT id,user_id,forum_id,subject_id,created_at,content_text
                  FROM forum_comments
                  WHERE forum_id= :forum_id AND subject_id= :subject_id');
		$q->execute([
			'forum_id' => $forum_id,
			'subject_id' => $reactionId
		]);
		$comments = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $comments;
	}
}

//Fonction pour prendre les commentaires d'un placepost dans la base des donnees
if (!function_exists('getAllPlaceComment')) {
	function getAllPlaceComment($place_id, $post_Id)
	{
		global $db;
		$q = $db->prepare('SELECT id,user_id,place_id,post_id,created_at,content_text
                  FROM place_comments
                  WHERE place_id= :place_id AND post_id= :post_id');
		$q->execute([
			'place_id' => $place_id,
			'post_id' => $post_Id
		]);
		$comments = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $comments;
	}
}
// Fonction pour afficher les commentaires pour un forumpost
if (!function_exists('display_comment')) {
	function display_comment($forum_id, $reactionId, $user_id)
	{
		$comments = getAllForumComment($forum_id, $reactionId);
		$output = '';
		if (count($comments) != 0) {
			foreach ($comments as $comment) {
				$username = get_user_name($comment->user_id);
				$user_profile = place_followerspic_displayer($comment->user_id);
				$output .= '
                                   <div class="card">
                                      <div class="card-body">
                                      <div class="row">
                                        <div class="col-lg-2">
                                       <img src= "' . e($user_profile->profilepic) . '" alt="profile image"
                                           class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
                                        </div>
                                         <div class="col-lg-8" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; font-style: italic; ">
                                       <h6 class="text-info">' . $username->name . '</h6>
                                       <h5 style="color: #44717C;">' . nl2br(replace_links(e($comment->content_text))) . '</h5>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="' . $comment->created_at . '">' . e($comment->created_at) . '</span>
                                     </div>
                                      <div class="col-lg-2 text-center">

                                     </div>
                                      </div>
                                      </div>
                                   </div>
                     		';
			}
		}
		return $output;
	}
}

// Fonction pour afficher les commentaires pour un placepost
if (!function_exists('pdisplay_comment')) {
	function pdisplay_comment($place_id, $post_Id, $user_id, $creator_id)
	{
		$comments = getAllPlaceComment($place_id, $post_Id);
		$output = '';
		if (count($comments) != 0) {
			foreach ($comments as $comment) {
				$username = get_user_name($comment->user_id);
				$user_profile = place_followerspic_displayer($comment->user_id);

				if ($comment->user_id == $creator_id) {
					$by = get_session('pl_n');
				} else {
					$by = $username->name;
				}
				$output .= '
							<div class="card">
								<div class="card-body">
								<div class="row">
								<div class="col-lg-2">
								<img src= "' . e($user_profile->profilepic) . '" alt="profile image"
									class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >
								</div>
									<div class="col-lg-8" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; font-style: italic; ">
								<b><h6 class="text-info">' . $by . '</h6></b>
								<h5 style="color: #44717C;">' . nl2br(replace_links(e($comment->content_text))) . '</h5>
								<i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="' . $comment->created_at . '">' . e($comment->created_at) . '</span>
								</div>
								<div class="col-lg-2 text-center">

								</div>
								</div>
								</div>
							</div>
					';
			}
		}
		return $output;
	}
}

//Function pour compter le nombre des commentaires sur un statut
if (!function_exists('forum_comment_count')) {
	function forum_comment_count($subject_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM forum_comments
			   	                 WHERE  subject_id= :subject_id
			   	                ');
		$q->execute([
			'subject_id' => $subject_id
		]);

		$count = $q->rowCount();
		$q->closeCursor();
		return $count;
	}
}

//Function pour compter le nombre des commentaires sur un statut
if (!function_exists('place_comment_count')) {
	function place_comment_count($post_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM place_comments
			   	                 WHERE  post_id= :post_id
			   	                ');
		$q->execute([
			'post_id' => $post_id
		]);

		$count = $q->rowCount();
		$q->closeCursor();

		return $count;
	}
}

// Fonction pour actualiser les details d'un forumpost
if (!function_exists('refresh_forumpost_details')) {
	function refresh_forumpost_details($subject_id)
	{
		$output = '';
		$number_of_comment = forum_comment_count($subject_id);
		$number_of_likes = fget_like_count($subject_id);
		$output .= '' . $number_of_likes . ' <i class="far fa-heart" aria-hidden="true"></i> ' . $number_of_comment . ' <i class="far fa-comments" aria-hidden="true"></i>
			   			           ';
		return $output;
	}
}




// Fonction pour afficher les utlisateurs aimant un post
if (!function_exists('display_validations')) {
	function display_validations($reaction_id)
	{
		$output = '';
		$output .= '
			   			<h5><span>' . reaction_satisfactions_count($reaction_id) . ' <i class="far fa-smile"></i> persons(are) satisfied par by this reaction</span><br>
			   			<span style="padding-left:120px;">' . reaction_validation_count($reaction_id) . ' <i class="far fa-thumbs-up"></i></span> <span class="text-danger">' . reaction_denied_count($reaction_id) . ' <i class="far fa-thumbs-down"></i></span> <span class="text-info">' . reaction_satisfied_count($reaction_id) . ' <i class="far fa-smile"></i></span></h5>
			   			';
		return $output;
	}
}


// Fonction pour afficher les utlisateurs aimant un post
if (!function_exists('likers_updater')) {
	function likers_updater($micropost_id, $db)
	{

		$like_count = get_like_count($micropost_id);
		$output1 = '';
		$output1 = '<div class="h7">
			   			<i class="far fa-heart" aria-hidden="true"></i> ' . $like_count . ' <i class="far fa-comments"></i> ' . count_comment($db, $micropost_id) . '
			   			            </div>';
		return $output1;
	}
}


// Fonction verifier si un utilisateur a deja aime un post
if (!function_exists('check_if_the_current_user_has_liked_the_micropost')) {
	function check_if_the_current_user_has_liked_the_micropost($micropost_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM micropost_like
			   	                 WHERE user_id= ? AND micropost_id = ?');
		$q->execute([get_session('user_id'), $micropost_id]);
		$count = $q->rowCount();
		$q->closeCursor();
		return (bool) $count;
	}
}


// Fonction pour afficher les utlisateurs aime un post
if (!function_exists('display_likers')) {
	function display_likers($micropost_id)
	{

		$like_count = get_like_count($micropost_id);
		$likers = get_likers($micropost_id);

		$output = '';

		if ($like_count > 0) {
			$remaining_like_count = $like_count - 3;
			$itself_like = check_if_the_current_user_has_liked_the_micropost($micropost_id);

			foreach ($likers as $liker) {
				if (get_session('user_id') !== $liker->id) {
					$output .= '<a href="profile.php?id=' . $liker->id . '"><img src="/' . $liker->profilepic . '" class="rounded-circle" style="height: 20px; width: 20px;
			border:1.5px solid #f5f6fa;"></a>';
				}
			}
			$output = $itself_like ?
				'<small>You, </small>' . $output : $output;

			if (($like_count == 2 || $like_count == 3) && $output != "") {
				$output = trim($output, ',');
				$arr = explode(',', $output);
				$lastItem = array_pop($arr);
				$output = implode(', ', $arr);
				$output .= ' ,' . $lastItem;
			}
			$output = trim($output, ', ');

			switch ($like_count) {
				case 1:
					$output .= $itself_like ?
						'<small> like</small>' : '<small> likes.</small>';
					break;
				case 2:
				case 3:
					$output .= $itself_like ?
						'<small> like</small>' : '<small> like.</small>';
					break;
				case 4:
					$output .= $itself_like ?
						'<small>and 1 other person like </small>' : '<small> and 1 more.</small>';
					break;
				default:
					$output .= $itself_like ?
						'<small>and ' . $remaining_like_count . ' more like. ' : ' and ' . $remaining_like_count . ' more like.</small>';
					break;
			}
		}
		return $output;
	}
}

// Fonction pour afficher les utlisateurs aime un post
if (!function_exists('display_likers_v2')) {
	function display_likers_v2($micropost_id)
	{

		$like_count = get_like_count($micropost_id);
		$likers = get_likers($micropost_id);

		$output = '<div class="flex items-center">';

		if ($like_count > 0) {
			$remaining_like_count = $like_count - 1;
			$itself_like = check_if_the_current_user_has_liked_the_micropost($micropost_id);

			foreach ($likers as $liker) {
				$last_user = find_user_by_id($liker->id);
			}
			$output .= '<strong>';
			if (count($likers) == 1) {
				$output .= '<a href="timeline.php?id=' . $last_user->id . '">' . $last_user->name . ' ' . $last_user->nom2 . '</a> likes</strong>';
			} elseif (count($likers) > 1) {
				$output .= '<a href="timeline.php?id=' . $last_user->id . '">' . $last_user->name . ' ' . $last_user->nom2 . '</a> <span uk-toggle="target: #liked-modal' . $micropost_id . '">and ' . $remaining_like_count . ' more</span></strong>';
			} else {
				$output .= '</strong>';
			}
			$output .= '</div>';
			return $output;
		}
	}
}


// Fonction pour aimer un forumpost
if (!function_exists('like_forumpost')) {
	function like_forumpost($forumpost_id)
	{
		global $db;
		$q = $db->prepare('INSERT INTO forumpost_like(user_id, forumpost_id)
		             VALUES(:user_id, :forumpost_id)');
		$q->execute([
			'user_id' => get_session('user_id'),
			'forumpost_id' => $forumpost_id
		]);

		$q = $db->prepare('UPDATE forum_subject
		             SET like_count= like_count+1
		             WHERE id= :forumpost_id');
		$q->execute([
			'forumpost_id' => $forumpost_id
		]);
	}
}

// Fonction pour unlike un forumpost
if (!function_exists('unlike_forumpost')) {
	function unlike_forumpost($forumpost_id)
	{
		global $db;
		$q = $db->prepare('DELETE FROM forumpost_like
        	             WHERE user_id= :user_id AND forumpost_id= :forumpost_id');
		$q->execute([
			'user_id' => get_session('user_id'),
			'forumpost_id' => $forumpost_id
		]);

		$q = $db->prepare('UPDATE forum_subject
		             SET like_count= like_count-1
		             WHERE id= :forumpost_id');
		$q->execute([
			'forumpost_id' => $forumpost_id
		]);
	}
}

// Fonction pour aimer un micropost
if (!function_exists('like_micropost')) {
	function like_micropost($micropost_id)
	{
		global $db;
		$q = $db->prepare('INSERT INTO micropost_like(user_id, micropost_id)
		             VALUES(:user_id, :micropost_id)');
		$q->execute([
			'user_id' => get_session('user_id'),
			'micropost_id' => $micropost_id
		]);

		$q = $db->prepare('UPDATE microposts
		             SET like_count= like_count+1
		             WHERE id= :micropost_id');
		$q->execute([
			'micropost_id' => $micropost_id
		]);
	}
}

// Fonction pour unlike un micropost
if (!function_exists('unlike_micropost')) {
	function unlike_micropost($micropost_id)
	{
		global $db;
		$q = $db->prepare('DELETE FROM micropost_like
        	             WHERE user_id= :user_id AND micropost_id= :micropost_id');
		$q->execute([
			'user_id' => get_session('user_id'),
			'micropost_id' => $micropost_id
		]);

		$q = $db->prepare('UPDATE microposts
		             SET like_count= like_count-1
		             WHERE id= :micropost_id');
		$q->execute([
			'micropost_id' => $micropost_id
		]);
	}
}
//FONCTION POUR COMPTER LES NOMBRES DE LIKES D'UN FORUMPOST
//Fonction pour compter le nombre des likes sur un forumpost
if (!function_exists('fget_like_count')) {
	function fget_like_count($forumpost_id)
	{
		global $db;

		$q = $db->prepare('SELECT like_count FROM forum_subject
			   	                WHERE id= :id');
		$q->execute(['id' => $forumpost_id]);

		$data = $q->fetch(PDO::FETCH_OBJ);

		return intval($data->like_count);
	}
}

// Fonction pour afficher les likes sur un forumpost
if (!function_exists('fget_likers')) {
	function fget_likers($forumpost_id)
	{
		global $db;

		$q = $db->prepare('SELECT users.id,users.nom2, users.profilepic
			   	                 FROM users
			   	                 LEFT JOIN forumpost_like
			   	                 ON users.id = forumpost_like.user_id
			   	                 WHERE forumpost_like.forumpost_id= ?
			   	                 ');
		$q->execute([$forumpost_id]);

		return $q->fetchAll(PDO::FETCH_OBJ);
	}
}
// Fonction verifier si un utilisateur a deja aime une publication d'un forum
if (!function_exists('check_if_the_current_user_has_liked_the_forumpost')) {
	function check_if_the_current_user_has_liked_the_forumpost($forumpost_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM forumpost_like
			   	                 WHERE user_id= ? AND forumpost_id = ?');
		$q->execute([get_session('user_id'), $forumpost_id]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}

// FONCTION POUR LES LIKES DE PLACE
// Fonction pour compter le nombre des likers d'un placepost
if (!function_exists('pget_like_count')) {
	function pget_like_count($placepost_id)
	{
		global $db;

		$q = $db->prepare('SELECT like_count FROM placeposts
			   	                WHERE id= :id');
		$q->execute(['id' => $placepost_id]);

		$data = $q->fetch(PDO::FETCH_OBJ);

		return intval($data->like_count);
	}
}

// Fonction pour afficher les likers d'un placepost
if (!function_exists('pget_likers')) {
	function pget_likers($placepost_id)
	{
		global $db;

		$q = $db->prepare('SELECT users.id,users.name,users.nom2, users.profilepic
			   	                 FROM users
			   	                 LEFT JOIN placepost_like
			   	                 ON users.id = placepost_like.user_id
			   	                 WHERE placepost_like.placepost_id= ?
			   	                 LIMIT 3');
		$q->execute([$placepost_id]);

		return $q->fetchAll(PDO::FETCH_OBJ);
	}
}

// Fonction verifier si un utilisateur a deja aime une publication d'une place
if (!function_exists('check_if_the_current_user_has_liked_the_placepost')) {
	function check_if_the_current_user_has_liked_the_placepost($placepost_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM placepost_like
			   	                 WHERE user_id= ? AND placepost_id = ?');
		$q->execute([get_session('user_id'), $placepost_id]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}
// Fonction pour afficher les utlisateurs aimant un placepost
if (!function_exists('pdisplay_likers')) {
	function pdisplay_likers($placepost_id)
	{

		$like_count = pget_like_count($placepost_id);
		$likers = pget_likers($placepost_id);

		$output = '';

		if ($like_count > 0) {
			$remaining_like_count = $like_count - 3;
			$itself_like = check_if_the_current_user_has_liked_the_placepost($placepost_id);

			foreach ($likers as $liker) {
				if (get_session('user_id') !== $liker->id) {
					$output .= '<a href="profile.php?id=' . $liker->id . '"><img src="' . $liker->profilepic . '" class="rounded-circle" style="height: 20px; width: 20px;
			border:1.5px solid #f5f6fa;"></a>';
				}
			}
			$output = $itself_like ?
				'You, ' . $output : $output;

			if (($like_count == 2 || $like_count == 3) && $output != "") {
				$output = trim($output, ',');
				$arr = explode(',', $output);
				$lastItem = array_pop($arr);
				$output = implode(', ', $arr);
				$output .= ' ,' . $lastItem;
			}
			$output = trim($output, ', ');

			switch ($like_count) {
				case 1:
					$output .= $itself_like ?
						' like' : ' likes.';
					break;
				case 2:
				case 3:
					$output .= $itself_like ?
						' like' : ' like.';
					break;
				case 4:
					$output .= $itself_like ?
						'and 1 other person like' : ' and 1 other person.';
					break;
				default:
					$output .= $itself_like ?
						'and ' . $remaining_like_count . ' other person like. ' : ' and ' . $remaining_like_count . ' other people like.';
					break;
			}
		}
		return $output;
	}
}

// Fonction pour afficher les utlisateurs aimant un forumpost
if (!function_exists('display_forum_likers')) {
	function display_forum_likers($forumpost_id)
	{

		$like_count = fget_like_count($forumpost_id);
		$likers = fget_likers($forumpost_id);

		$output = '';

		if ($like_count > 0) {
			$remaining_like_count = $like_count - 3;
			$itself_like = check_if_the_current_user_has_liked_the_forumpost($forumpost_id);

			foreach ($likers as $liker) {
				if (get_session('user_id') !== $liker->id) {
					$output .= '<a href="profile.php?id=' . $liker->id . '"><img src="' . $liker->profilepic . '" class="rounded-circle" style="height: 20px; width: 20px;
			border:1.5px solid #f5f6fa;"></a>';
				}
			}
			$output = $itself_like ?
				'You, ' . $output : $output;

			if (($like_count == 2 || $like_count == 3) && $output != "") {
				$output = trim($output, ',');
				$arr = explode(',', $output);
				$lastItem = array_pop($arr);
				$output = implode(', ', $arr);
				$output .= ' ,' . $lastItem;
			}
			$output = trim($output, ', ');

			switch ($like_count) {
				case 1:
					$output .= $itself_like ?
						' like' : ' likes.';
					break;
				case 2:
				case 3:
					$output .= $itself_like ?
						' like' : ' like.';
					break;
				case 4:
					$output .= $itself_like ?
						'and 1 other person like' : ' and 1 other person.';
					break;
				default:
					$output .= $itself_like ?
						'and ' . $remaining_like_count . ' other person like. ' : ' and ' . $remaining_like_count . ' other people like.';
					break;
			}
		}
		return $output;
	}
}

// Fonction pour afficher les utlisateurs suivant un forum
if (!function_exists('forum_followers_displayer')) {
	function forum_followers_displayer($forum_id)
	{
		global $db;
		$q = $db->prepare("SELECT * FROM forum_members
	                            WHERE forum_id = :current_forum
	                            AND etat ='1' LIMIT 3");
		$q->execute([
			'current_forum' => $forum_id
		]);

		$flw_nbrs = $q->rowCount();
		$followers = $q->fetchAll(PDO::FETCH_OBJ);
		$output = '<div class="flex items-center -space-x-4">';



		$remaining_followers = forum_members_count($forum_id) - 3;

		foreach ($followers as $follower) {
			$him = find_user_by_id($follower->user_id);
			$output .= '<a href="timeline.php?id=' . $him->id . '"><img src="/' . $him->profilepic . '" class="w-10 h-10 rounded-full border-2 border-white"></a>';
		}

		if (count($followers) >= 3) {
			$output .= '<div class="w-10 h-10 rounded-full flex justify-center items-center bg-red-100 text-red-500 font-semibold">+' . $remaining_followers . ' </div> ';
		}
		return $output;
	}
}

// Fonction pour aimer un placepost
if (!function_exists('like_placepost')) {
	function like_placepost($placepost_id)
	{
		global $db;
		$q = $db->prepare('INSERT INTO placepost_like(user_id, placepost_id)
		             VALUES(:user_id, :placepost_id)');
		$q->execute([
			'user_id' => get_session('user_id'),
			'placepost_id' => $placepost_id
		]);

		$q = $db->prepare('UPDATE placeposts
		             SET like_count= like_count+1
		             WHERE id= :placepost_id');
		$q->execute([
			'placepost_id' => $placepost_id
		]);
		if (get_session('user_id') != get_session('cr_i')) {
			$q = $db->prepare("INSERT INTO place_notifications(poster_id,content,place_name,place_id,object_id,seen,posted_at)
                     VALUES(:poster_id,:content,:place_name,:place_id,:object_id,:seen,NOW())
		            ");
			$q->execute([
				'poster_id' => get_session('user_id'),
				'content' => "post_liked",
				'place_name' => get_session('pl_n'),
				'place_id' => get_session('pl_i'),
				'object_id' => $placepost_id,
				'seen' => 0
			]);

			$q = $db->prepare('INSERT INTO notifications(place_id,subject_id ,user_id,post_id,type,created_at)
                         VALUES(:place_id,:subject_id ,:user_id,:post_id,:type, NOW())');
			$q->execute([
				'place_id' => get_session('pl_i'),
				'user_id' => get_session('user_id'),
				'subject_id' => get_session('cr_i'),
				'post_id' => $placepost_id,
				'type' => "post_liked"
			]);
		}
	}
}

// Fonction pour aimer une chaine
if (!function_exists('channel_likes')) {
	function channel_likes($action)
	{
		global $db;

		if ($action == "like") {
			$q = $db->prepare('INSERT INTO channel_likes(user_id, channel_id, action)
			   VALUES(:user_id, :channel_id, :action)');
			$q->execute([
				'user_id' => get_session('user_id'),
				'channel_id' => get_session('channel_id'),
				'action' => "liked"
			]);
		} elseif ($action == "unlike") {
			$q = $db->prepare('DELETE FROM channel_likes WHERE
			user_id= :user_id AND channel_id= :channel_id AND action= :action');
			$q->execute([
				'user_id' => get_session('user_id'),
				'channel_id' => get_session('channel_id'),
				'action' => "liked"
			]);

			$q = $db->prepare('INSERT INTO channel_likes(user_id, channel_id, action)
			   VALUES(:user_id, :channel_id, :action)');
			$q->execute([
				'user_id' => get_session('user_id'),
				'channel_id' => get_session('channel_id'),
				'action' => "unliked"
			]);
		} elseif ($action == "neutral") {
			$q = $db->prepare('DELETE FROM channel_likes WHERE
			user_id= :user_id AND channel_id= :channel_id');
			$q->execute([
				'user_id' => get_session('user_id'),
				'channel_id' => get_session('channel_id')
			]);
		}
	}
}

if (!function_exists('count_channel_likes')) {
	function count_channel_likes($channel_id)
	{
		global $db;

		$q = $db->prepare("SELECT * FROM channel_likes WHERE
	                    channel_id= :channel_id AND action= :action");
		$q->execute([
			'channel_id' => $channel_id,
			'action' => "liked"
		]);

		$likes = $q->rowCount();
		$q->closeCursor();
		return $likes;
	}
}

if (!function_exists('count_channel_unlikes')) {
	function count_channel_unlikes($channel_id)
	{
		global $db;

		$q = $db->prepare("SELECT * FROM channel_likes WHERE
	                    channel_id= :channel_id AND action= :action");
		$q->execute([
			'channel_id' => $channel_id,
			'action' => "unliked"
		]);

		$unlikes = $q->rowCount();

		return $unlikes;
	}
}


// Fonction pour unlike un placepost
if (!function_exists('unlike_placepost')) {
	function unlike_placepost($placepost_id)
	{
		global $db;
		$q = $db->prepare('DELETE FROM placepost_like
        	             WHERE user_id= :user_id AND placepost_id= :placepost_id');
		$q->execute([
			'user_id' => get_session('user_id'),
			'placepost_id' => $placepost_id
		]);

		$q = $db->prepare('UPDATE placeposts
		             SET like_count= like_count-1
		             WHERE id= :placepost_id');
		$q->execute([
			'placepost_id' => $placepost_id
		]);
	}
}

// Checks if a friend request has already liked the given micropost
if (!function_exists('user_has_already_liked_the_micropost')) {
	function user_has_already_liked_the_micropost($micropost_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM micropost_like
		             WHERE user_id= :user_id AND micropost_id= :micropost_id');
		$q->execute([
			'user_id' => get_session('user_id'),
			'micropost_id' => $micropost_id
		]);
		return (bool) $q->rowCount();
	}
}

// Checks if a user has already liked a forumpost
if (!function_exists('user_has_already_liked_the_forumpost')) {
	function user_has_already_liked_the_forumpost($forumpost_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM forumpost_like
		             WHERE user_id= :user_id AND forumpost_id= :forumpost_id');
		$q->execute([
			'user_id' => get_session('user_id'),
			'forumpost_id' => $forumpost_id
		]);
		return (bool) $q->rowCount();
	}
}

// Checks if a friend request has already liked the given placepost
if (!function_exists('user_has_already_liked_the_placepost')) {
	function user_has_already_liked_the_placepost($placepost_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM placepost_like
		             WHERE user_id= :user_id AND placepost_id= :placepost_id');
		$q->execute([
			'user_id' => get_session('user_id'),
			'placepost_id' => $placepost_id
		]);
		return (bool) $q->rowCount();
	}
}

// Checks if a user has already liked a given channel 
if (!function_exists('user_has_already_liked_the_channel')) {
	function user_has_already_liked_the_channel()
	{
		global $db;
		$q = $db->prepare('SELECT id FROM channel_likes
			  WHERE user_id= :user_id AND channel_id= :channel_id AND action= :action');
		$q->execute([
			'user_id' => get_session('user_id'),
			'channel_id' => get_session('channel_id'),
			'action' => "liked"
		]);
		return (bool) $q->rowCount();
	}
}


// Fonction pour rediriger l'utisateur qu'il demande au cas ou il ne serait pas connecte
if (!function_exists('friendly_redirection')) {
	function friendly_redirection($default_url)
	{
		if ($_SESSION['forwarding_url']) {
			$url = $_SESSION['forwarding_url'];
		} else {
			$_SESSION['forwarding_url'] = null;
			$url = $default_url;
		}
		redirect($url);
	}
}

// Fonction pour verifier si l'ulisateur a deja envoye une demande
if (!function_exists('if_a_friend_request_has_already_been_sent')) {
	function if_a_friend_request_has_already_been_sent($id1, $id2)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
	                            WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
			   	                 OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");
		$q->execute([
			'user_id1' => $id1,
			'user_id2' => $id2
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour verifier si le marketplace a deja ete cree
if (!function_exists('a_marketplace_has_already_been_created')) {
	function a_marketplace_has_already_been_created()
	{
		global $db;
		$q = $db->prepare("SELECT id FROM places WHERE marketplace_state= :marketplace_state AND id= :place_id");
		$q->execute([
			'marketplace_state' => 1,
			'place_id' => get_session('pl_i')
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour verifier si l'ulisateur suit deja une place
if (!function_exists('a_place_has_already_been_followed')) {
	function a_place_has_already_been_followed($place_id, $id)
	{
		global $db;
		$q = $db->prepare("SELECT created_at FROM places_followers
	                            WHERE place_id = :place_id AND user_id = :user_id");
		$q->execute([
			'place_id' => $place_id,
			'user_id' => $id
		]);

		$data = $q->fetch(PDO::FETCH_OBJ);

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		$q->closeCursor();
	}
}

// Fonction pour prendre toutes les places suivies par l'utilisateur
if (!function_exists('places_followed_by_the_current_user')) {
	function places_followed_by_the_current_user($id)
	{
		global $db;
		$q = $db->prepare("SELECT place_id FROM places_followers
	                            WHERE user_id = :user_id1 AND status = :status");
		$q->execute([
			'user_id1' => $id,
			'status' => 1
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}


// Fonction pour verifier si l'ulisateur en cours est deja dans un forum
if (!function_exists('is_already_in')) {
	function is_already_in($forum_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM forum_members
	                            WHERE (user_id = :user_id AND forum_id = :forum_id AND etat = :etat)");
		$q->execute([
			'user_id' => get_session('user_id'),
			'forum_id' => $forum_id,
			'etat' => 1
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		$q->closeCursor();
	}
}

//Fonction pour verifier si un utlisateur quelconque est deja dans un forum
if (!function_exists('is_him_in')) {
	function is_him_in($user_id, $forum_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM forum_members
	                            WHERE (user_id = :user_id AND forum_id = :forum_id AND etat = :etat)");
		$q->execute([
			'user_id' => $user_id,
			'forum_id' => $forum_id,
			'etat' => 1
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		$q->closeCursor();
	}
}

// Fonction 1 pour identifier tout les forums ou est l'user
if (!function_exists('forum_where_user_is')) {
	function forum_where_user_is()
	{
		global $db;
		$q = $db->prepare("SELECT id,forum_id FROM forum_members
	                            WHERE (user_id = :user_id AND etat = :etat)");
		$q->execute([
			'user_id' => get_session('user_id'),
			'etat' => 1
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

// Fonction 1 pour identifier tout les forums ou l'utilisateur courant est admin
if (!function_exists('forum_where_user_is_admin')) {
	function forum_where_user_is_admin()
	{
		global $db;
		$q = $db->prepare("SELECT id,forum_name,forum_pic,creator_id FROM forums
	                            WHERE creator_id = :creator_id");
		$q->execute([
			'creator_id' => get_session('user_id')
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}




// Fonction pour compter les nombres d'amis
if (!function_exists('friends_count')) {
	function friends_count()
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
	                            WHERE (user_id1 = :user_connected OR user_id2 = :user_connected)
	                            AND status ='1'");
		$q->execute([
			'user_connected' => $_GET['id']
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

// Fonction pour verifier si deux utilisateurs sont deja amis
if (!function_exists('already_friends')) {
	function already_friends($id1, $id2)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
	                            WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
	                            OR (user_id1 = :user_id2 AND user_id2 = :user_id1)
	                            AND status= :status
			   	                 ");
		$q->execute([
			'user_id1' => $id1,
			'user_id2' => $id2,
			'status' => 1
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour verifier si un utilisateur a deja envoye une demande a un autre utilisateur
if (!function_exists('request_already_sent')) {
	function request_already_sent($id1, $id2)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
	                            WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
	                            OR (user_id1 = :user_id2 AND user_id2 = :user_id1)
	                            AND status= :status
			   	                 ");
		$q->execute([
			'user_id1' => $id1,
			'user_id2' => $id2,
			'status' => 2
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction minimiser pour verifier si deux users sont deja amis
if (!function_exists('already_friends_min')) {
	function already_friends_min($id1, $id2)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
	                            WHERE user_id1= :user_id1 AND user_id2= :user_id2
	                            AND status= :status
			   	                 ");
		$q->execute([
			'user_id1' => $id1,
			'user_id2' => $id2,
			'status' => 1
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour compter le nombre des notifications d'une place
if (!function_exists('place_notifications_count')) {
	function place_notifications_count()
	{
		global $db;
		$q = $db->prepare("SELECT content,posted_at FROM place_notifications
	                            WHERE place_id = :current_place
	                            AND seen ='0'");
		$q->execute([
			'current_place' => get_session('pl_i')
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}


// Fonction pour compter le nombre des notifications d'un forum
if (!function_exists('forum_notifications_count')) {
	function forum_notifications_count($forum_id)
	{
		global $db;
		$q = $db->prepare("SELECT type,posted_at FROM forum_notifications
	                            WHERE forum_id = :current_forum
	                            AND seen ='0'");
		$q->execute([
			'current_forum' => $forum_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

// Fonction pour compter le nombre des personnes satisfaites par une reaction
if (!function_exists('reaction_satisfactions_count')) {
	function reaction_satisfactions_count($reaction_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM reaction_like
	                            WHERE reaction_id = :current_reaction
	                            AND type ='satisfied'");
		$q->execute([
			'current_reaction' => $reaction_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

// Fonction pour compter le nombre des membres d'un forum
if (!function_exists('forum_members_count')) {
	function forum_members_count($forum_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM forum_members
	                            WHERE forum_id = :current_forum
	                            AND etat ='1'");
		$q->execute([
			'current_forum' => $forum_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

// Fonction pour compter le nombre des questions d'un forum
if (!function_exists('forum_subject_count')) {
	function forum_subject_count($forum_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM forum_subject
	                            WHERE forum_id = :current_forum
	                            ");
		$q->execute([
			'current_forum' => $forum_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

// Fonction pour afficher les notifications d'une place
if (!function_exists('place_notifications_displayer')) {
	function place_notifications_displayer()
	{
		global $db;
		$q = $db->prepare("SELECT * FROM place_notifications
	                            WHERE place_id = :current_place
	                            AND seen ='0' ORDER BY -posted_at");
		$q->execute([
			'current_place' => $_GET['pl_i']
		]);


		$data = $q->fetchAll(PDO::FETCH_OBJ);

		$q->closeCursor();

		return $data;
	}
}

// Fonction pour afficher les notifications d'un forum
if (!function_exists('forum_notifications_displayer')) {
	function forum_notifications_displayer()
	{
		global $db;
		$q = $db->prepare("SELECT poster_id,type,forum_id,posted_at FROM forum_notifications
	                            WHERE forum_id = :current_forum
	                            AND seen ='0' LIMIT 3");
		$q->execute([
			'current_forum' => get_session('fr_i')
		]);

		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();

		return $data;
	}
}

// Fonction pour afficher les trois premieres dernieres questions d'un forum
if (!function_exists('forum_three_subject_getters')) {
	function forum_three_subject_getters($forum_id)
	{
		global $db;
		$q = $db->prepare("SELECT id,subject,reaction,created_at FROM forum_subject
	                            WHERE forum_id = :current_forum
	                            LIMIT 3");
		$q->execute([
			'current_forum' => $forum_id
		]);

		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();

		return $data;
	}
}

// Fonction pour afficher les photos de followers
if (!function_exists('place_followerspic_displayer')) {
	function place_followerspic_displayer($id)
	{
		global $db;
		$q = $db->prepare("SELECT profilepic FROM users
	                            WHERE id = :current_id
	                            ");
		$q->execute([
			'current_id' => $id
		]);

		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();

		return $data;
	}
}


// Fonction pour compter les nombres de followers d'une place
if (!function_exists('followers_count')) {
	function followers_count()
	{
		global $db;
		$q = $db->prepare("SELECT status FROM places_followers
	                            WHERE place_id = :place_id
	                            AND status ='1'");
		$q->execute([
			'place_id' => get_session('pl_i')
		]);
		$count = $q->rowCount();
		$q->closeCursor();
		return $count;
	}
}


// Fonction pour checker d'amitie le lien d;amitie a envoyer
if (!function_exists('relation_link_to_display')) {
	function relation_link_to_display($id)
	{
		global $db;
		$q = $db->prepare('SELECT user_id1, user_id2, status FROM friends_relationships
			   	                 WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
			   	                 OR (user_id1 = :user_id2 AND user_id2 = :user_id1)');
		$q->execute([
			'user_id1' => get_session('user_id'),
			'user_id2' => $id
		]);

		$data = $q->fetch();

		if ($data['user_id1'] == $id && $data['status'] == '2') {
			return "accept_reject_relation_link";
		} elseif ($data['user_id1'] == get_session('user_id') && $data['status'] == '2') {
			return "cancel_relation_link";
		} elseif (($data['user_id1'] == get_session('user_id') or $data['user_id1']
			== $id) and $data['status'] == '1') {
			return "delete_relation_link";
		} else {
			return "add_relation_link";
		}
		$q->closeCursor();
		die($data->status);
	}
}

// Fonction pour rendre le lien ecrit par les utilisateurs cliquable
if (!function_exists('replace_links')) {
	function replace_links($texte)
	{
		$regex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";
		return  preg_replace($regex_url, "<a href=\"$0\" target=\"_blank\">$0</a>", $texte);
	}
}

// Fonction pour savoir si un utilisateur est connecté

if (!function_exists('is_logged_in')) {
	function is_logged_in()
	{
		return isset($_SESSION['user_id']) and isset($_SESSION['nom2']);
	}
}
// Fonction pour trouver la valeur de la session en cours

if (!function_exists('get_session')) {
	function get_session($key)
	{
		if ($key) {
			return !empty($_SESSION[$key])
				? e($_SESSION[$key])
				: null;
		}
	}
}
//Fonction qui charge notre gravatar
if (!function_exists('get_avatar_url')) {
	function get_avatar_url($email)
	{
		return "http://gravatar.com/avatar/" . md5(strtolower(trim(e($email))));
	}
}
// Fonction verifiant si les champs ne sont pas vides
if (!function_exists('not_empty')) {

	function not_empty($fields = [])
	{
		if (count($fields) != 0) {
			foreach ($fields as $field) {
				if (empty($_POST[$field]) || trim($_POST[$field]) == "") {
					return false;
				}
			}
			return true;
		}
	}
}
// *
// Deuxieme fonctions
if (!function_exists('is_already_in_use')) {
	function is_already_in_use($field, $value, $table)
	{

		// initialisation de la variable $Db
		global $db;
		// verification de l'exesitance par query
		$q = $db->prepare("SELECT id FROM $table WHERE $field =?");
		$q->execute([$value]);
		$count = $q->rowCount();
		$q->closeCursor();
		return $count;
	}
}
// troisieme fonctions pour afficher les differents messages
if (!function_exists('set_flash')) {
	function set_flash($message, $type = 'info')
	{

		$_SESSION['notification']['message'] = $message;
		$_SESSION['notification']['type'] = $type;
	}
}
if (!function_exists('redirect')) {
	function redirect($page)
	{

		header('Location: ' . $page);
		exit();
	}
}

// Fonction pour enregistrer les informations en session

if (!function_exists('save_input_data')) {
	function save_input_data()
	{

		foreach ($_POST as $key => $value) {
			if (strpos($key, 'password') === false) {
				$_SESSION['input'][$key] = $value;
			}
		}
	}
}

// Fonction pour recuperer les données d'un formulaire
if (!function_exists('get_input')) {
	function get_input($key)
	{

		return !empty($_SESSION['input'][$key])
			? e($_SESSION['input'][$key])
			: null;
	}
}
// Supprime tous les données en session
if (!function_exists('clear_input_data')) {
	function clear_input_data()
	{
		if (isset($_SESSION['input'])) {
			$_SESSION['input'] = [];
		}
	}
}

// Fonction pour trouver la valeur de la session locale de la langue par default

if (!function_exists('get_current_locale')) {
	function get_current_locale()
	{
		return $_SESSION['locale'];
	}
}

// function pour recuperer les forums dans lequels un user est
if (!function_exists('countForumUserIsIn')) {
	function countForumUserIsIn()
	{
		global $db;
		$q = $db->prepare('SELECT F.forum_name,F.forum_pic,F.id
                          FROM forums F, forum_members M
                          WHERE F.id= M.forum_id

                          AND
                          M.user_id= :user_id

                          AND M.etat = 1
                          ORDER BY F.id DESC LIMIT 3');
		$q->execute([
			'user_id' => get_session('user_id')
		]);
		$forums = $q->rowCount();
		$q->closeCursor();
		return $forums;
	}
}

// Fonction pour verifier si l'utilisateur a deja partager une publication
if (!function_exists('a_post_has_already_been_shared')) {
	function a_post_has_already_been_shared($user_id, $post_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM microposts
	                            WHERE user_id = :id AND content_id = :content_id");
		$q->execute([
			'id' => $user_id,
			'content_id' => $post_id
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		$q->closeCursor();
	}
}

// Fonction pour compte des partages d'une publication
if (!function_exists('post_shares_count')) {
	function post_shares_count($post_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM microposts
		                            WHERE type = :type AND content_id = :content_id");
		$q->execute([
			'type' => "shared_post",
			'content_id' => $post_id
		]);
		$data = $q->rowCount();

		if ($data > 0) {
			return $data;
		} else {
			return "";
		}

		$q->closeCursor();
	}
}

// function pour convertir les hashtags
if (!function_exists('convertHashtags')) {
	function convertHashtags($str)
	{

		$regex = "/#+([a-zA-Z0-9_]+)/";
		$str = preg_replace($regex, '<a href="explore.php?tag=$1">$0</a>', $str);
		return ($str);
	}
}

// Fonction pour compter les nombres d'amis
if (!function_exists('friends_count_wparameter')) {
	function friends_count_wparameter($user_id)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
						 WHERE (user_id1 = :user_connected OR user_id2 = :user_connected)
						 AND status ='1'");
		$q->execute([
			'user_connected' => $user_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

//Fonction pour recuperer le nombre de candidats pour un vote
if (!function_exists('get_candidates')) {
	function get_candidates($event_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM poll_tb WHERE event_id= :event_id AND status= :status');
		$q->execute([
			'event_id' => $event_id,
			'status' => 1
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}
//Fonction pour compter le nombre des candidats pour une session
if (!function_exists('candidates_count')) {
	function candidates_count($session_id, $event_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM poll_tb
                          WHERE session_id= :session_id AND event_id= :event_id');
		$q->execute([
			'session_id' => $session_id,
			'event_id' => $event_id
		]);

		$count = $q->rowCount();

		return $count;
	}
}
// verifier si un utilisateur a deja voter
if (!function_exists('user_has_already_vote')) {
	function user_has_already_vote($user_id, $session_id, $event_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM poll_count
		             WHERE user_id= :user_id AND session_id= :session_id AND event_id= :event_id');
		$q->execute([
			'user_id' => $user_id,
			'session_id' => $session_id,
			'event_id' => $event_id
		]);
		return (bool) $q->rowCount();
	}
}

// verifier si un utilisateur a deja voter un candidate
if (!function_exists('user_has_already_vote_a_candidate')) {
	function user_has_already_vote_a_candidate($user_id, $session_id, $event_id, $candidate_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM poll_count
		             WHERE user_id= :user_id AND session_id= :session_id AND event_id= :event_id AND candidate_id= :candidate_id');
		$q->execute([
			'user_id' => $user_id,
			'session_id' => $session_id,
			'event_id' => $event_id,
			'candidate_id' => $candidate_id
		]);
		return (bool) $q->rowCount();
	}
}

// verifier si un utilisateur a deja voter un candidate specifique
if (!function_exists('user_has_already_voted_a_specified_candidate')) {
	function user_has_already_voted_a_specified_candidate($user_id, $candidate_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM poll_count
		             WHERE user_id= :user_id AND candidate_id= :candidate_id');
		$q->execute([
			'user_id' => $user_id,
			'candidate_id' => $candidate_id
		]);
		return (bool) $q->rowCount();
	}
}

// Fonction pour voter un candidate
if (!function_exists('user_vote_action')) {
	function user_vote_action($user_id, $event_id, $session_id, $candidate_id)
	{
		global $db;
		$q = $db->prepare('INSERT INTO poll_count(user_id,event_id,session_id,candidate_id)
                 VALUES(:user_id, :event_id,:session_id,:candidate_id)');
		$q->execute([
			'user_id' => $user_id,
			'event_id' => $event_id,
			'session_id' => $session_id,
			'candidate_id' => $candidate_id
		]);

		$q = $db->prepare('UPDATE poll_tb
                 SET points= points+1
                 WHERE id= :candidate_id');
		$q->execute([
			'candidate_id' => $candidate_id
		]);
		if (get_session('user_id') != get_session('cr_i')) {
			$q = $db->prepare("INSERT INTO event_notifications(poster_id,content,session_name,event_id,candidate_id,seen,posted_at)
                     VALUES(:poster_id,:content,:session_name,:event_id,:candidate_id,:seen,NOW())
                ");
			$q->execute([
				'poster_id' => get_session('user_id'),
				'content' => "has_voted",
				'session_name' => $session_name,
				'event_id' => $event_id,
				'candidate_id' => $candidate_id,
				'seen' => 0
			]);

			$q = $db->prepare('INSERT INTO notifications(event_id,subject_id ,user_id,session_id,type,created_at)
                         VALUES(:event_id,:subject_id ,:user_id,:session_id,:type, NOW())');
			$q->execute([
				'event_id' => $event_id,
				'user_id' => get_session('user_id'),
				'subject_id' => get_session('cr_i'),
				'session_id' => $session_id,
				'type' => "has_voted"
			]);
		}

		$q->closeCursor();
	}
}

// Fonction pour devoter un candidat
if (!function_exists('unvote_candidate')) {
	function unvote_candidate($user_id, $event_id, $session_id, $candidate_id)
	{
		global $db;
		$q = $db->prepare('DELETE FROM poll_count
                       WHERE user_id= :user_id
                       AND event_id= :event_id
                       AND session_id= :session_id
                       AND candidate_id= :candidate_id');
		$q->execute([
			'user_id' => $user_id,
			'event_id' => $event_id,
			'session_id' => $session_id,
			'candidate_id' => $candidate_id
		]);

		$q = $db->prepare('UPDATE poll_tb
                 SET points= points-1
                 WHERE id= :candidate_id');
		$q->execute([
			'candidate_id' => $candidate_id
		]);

		$q->closeCursor();
	}
}

//Formation pour affichage optimisee des nbres
if (!function_exists('number_format_short')) {

	function number_format_short($n, $precision = 1)
	{
		if ($n < 900) {
			// 0 - 900
			$n_format = number_format($n, $precision);
			$suffix = '';
		} else if ($n < 900000) {
			// 0.9k-850k
			$n_format = number_format($n / 1000, $precision);
			$suffix = 'K';
		} else if ($n < 900000000) {
			// 0.9m-850m
			$n_format = number_format($n / 1000000, $precision);
			$suffix = 'M';
		} else if ($n < 900000000000) {
			// 0.9b-850b
			$n_format = number_format($n / 1000000000, $precision);
			$suffix = 'B';
		} else {
			// 0.9t+
			$n_format = number_format($n / 1000000000000, $precision);
			$suffix = 'T';
		}

		// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
		// Intentionally does not affect partials, eg "1.50" -> "1.50"
		if ($precision > 0) {
			$dotzero = '.' . str_repeat('0', $precision);
			$n_format = str_replace($dotzero, '', $n_format);
		}

		return $n_format . $suffix;
	}
}

// Fonction pour recuperer tous les amis d'un utilisateur quelconque
if (!function_exists('friends_of')) {
	function friends_of($user_id)
	{
		global $db;
		$q = $db->prepare("SELECT * FROM friends_relationships
	                            WHERE (user_id1 = :user_id
								OR user_id2 = :user_id)
								AND status = :status
			   	                 ");
		$q->execute([
			'user_id' => $user_id,
			'status' => 1
		]);

		$data = $q->fetchAll(PDO::FETCH_OBJ);

		$q->closeCursor();

		return $data;
	}
}

// Fonction pour recuperer tous les amis d'un utilisateur quelconque
if (!function_exists('limited_friends_of')) {
	function limited_friends_of($user_id, $limit)
	{
		global $db;
		$q = $db->prepare("SELECT * FROM friends_relationships
	                            WHERE (user_id1 = :user_id
								OR user_id2 = :user_id)
								AND status = :status
			   	                LIMIT " . $limit . "");
		$q->execute([
			'user_id' => $user_id,
			'status' => 1
		]);

		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

// Fonction pour afficher les reactions sur un forum post
if (!function_exists('display_reactions')) {
	function display_reactions($reactionId)
	{
		// ======= Fetching subject reactions ==========
		$reactions_data = getUserForumReaction($reactionId);
		$reactions = '';

		foreach ($reactions_data as $reaction) {
			$owner = find_user_by_id($reaction->user_id);
			//Check if user has already validate a reaction
			if (already_validate($reaction->id)) {
				$validate_btn = '<a href="" class="validate" id="validate' . $reaction->id . '" style="display:none;"> <i class="far fa-thumbs-up"></i> Validate </a>
				<a href="" class="text-red-600 validated" id="validated' . $reaction->id . '"> <i class="far fa-thumbs-up"></i>You validate </a>';
			} else {
				$validate_btn = '<a href="" class="validate" id="validate' . $reaction->id . '"> <i class="far fa-thumbs-up"></i> Validate </a>
								<a href="" class="text-red-600 validated" id="validated' . $reaction->id . '" style="display:none;"> <i class="far fa-thumbs-up"></i>You validate </a>';
			}

			//Check if user has already denied a reaction
			if (already_denied($reaction->id)) {
				$denied_btn = '<a href="" class="denied" id="denied' . $reaction->id . '" style="display:none;"> <i class="far fa-thumbs-down"></i> Denied </a>
				<a href="" class="text-blue-600 denied" id="denieded' . $reaction->id . '"> <i class="far fa-thumbs-down"></i> Denied </a>';
			} else {
				$denied_btn = '<a href="" class="denied" id="denied' . $reaction->id . '"> <i class="far fa-thumbs-down"></i> Denied </a>
				<a href="" class="text-blue-600 denied" id="denieded' . $reaction->id . '" style="display:none;"> <i class="far fa-thumbs-up"></i>Denied </a>';
			}

			//Check if a user is already satisfied with a reaction
			if (already_satisfied($reaction->id)) {
				$satisfied_btn = '<a href="" class="satisfied" id="satisfieded' . $reaction->id . '" style="display:none;"><i class="far fa-smile"></i> Satisfied</a>
				<a href="" class="text-green-600 satisfied" id="satisfied' . $reaction->id . '"> <i class="far fa-smile"></i> Satisfied </a>';
			} else {
				$satisfied_btn = '<a href="" class="satisfied" id="satisfied' . $reaction->id . '"><i class="far fa-smile"></i> Satisfied</a>
				<a href="" class="text-green-600 satisfied" id="satisfieded' . $reaction->id . '" style="display:none;"> <i class="far fa-smile"></i> Satisfied </a>';
			}

			$reactions .= '
			<div class="flex" id="display_reactions' . $reactionId . '">
			<div class="w-10 h-10 rounded-full relative flex-shrink-0">
				<img src="/' . $owner->profilepic . '" alt="" class="absolute h-full rounded-full w-full">
			</div>
			<div>
				<div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
					<p class="leading-6">' . convertHashtags(replace_links($reaction->content_text)) . ' <urna class="i uil-heart"></urna> <i
							class="uil-grin-tongue-wink"> </i> </p>
					<div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
				</div>
				<div class="text-sm flex items-center space-x-3 mt-2 ml-5">
					' . $validate_btn . '
					' . $denied_btn . '
					' . $satisfied_btn . '
					<span> ' . zungvi_time_ago($reaction->created_at) . ' </span>
				</div>
				<div class="text-sm flex items-center space-x-3 mt-2 ml-5" id="likers_' . $reaction->id . '">
				' . display_validations($reaction->id) . '
				</div>
			</div>
		</div>
		';
		}
		return $reactions;
	}
}

// Fonction pour verifier si l'ulisateur en cours est deja dans un forum
if (!function_exists('is_already_in_forum')) {
	function is_already_in_forum($forum_id, $user_id)
	{
		global $db;
		$q = $db->prepare("SELECT id FROM forum_members
						 WHERE (user_id = :user_id AND forum_id = :forum_id AND etat = :etat)");
		$q->execute([
			'user_id' => $user_id,
			'forum_id' => $forum_id,
			'etat' => 1
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);
		$q->closeCursor();

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
	}
}

// Fonction pour verifier si une invitation a joindre un forum a deja ete envoye
if (!function_exists('forum_invitation_already_sent')) {
	function forum_invitation_already_sent($forum_id, $subject_id, $type)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM notifications
				WHERE subject_id= :subject_id AND type= :type AND forum_id= :forum_id');
		$q->execute([
			'subject_id' => $subject_id,
			'type' => $type,
			'forum_id' => $forum_id
		]);
		$q->closeCursor();
		return (bool) $q->rowCount();
	}
}

// Fonction pour compter le nombre des likes d'un commentaire
if (!function_exists('get_comment_likes')) {
	function get_comment_likes($comment_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM notifications
			   	          WHERE comment_id= :comment_id');
		$q->execute(['comment_id' => $comment_id]);

		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$data = $q->rowCount();
		$q->closeCursor();
		if ($data) {
			return $data;
		} else {
			return '';
		}
	}
}

// Fonction pour verifier si une invitation a joindre un forum a deja ete envoye
if (!function_exists('is_favorite')) {
	function is_favorite($user_id, $post_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM favorite_posts
				WHERE user_id= :user_id AND post_id= :post_id');
		$q->execute([
			'user_id' => $user_id,
			'post_id' => $post_id
		]);
		$q->closeCursor();
		return (bool) $q->rowCount();
	}
}

// Fonction recuperer tous les forums ou un utilisateur defini est admin
if (!function_exists('forum_where_defined_user_is_admin')) {
	function forum_where_defined_user_is_admin($user_id)
	{
		global $db;
		$q = $db->prepare("SELECT * FROM forums
	                            WHERE creator_id = :creator_id");
		$q->execute([
			'creator_id' => $user_id
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $data;
	}
}

// Fonction pour afficher les commentaires d'un article
if (!function_exists('display_article_comments')) {
	function display_article_comments($article_id)
	{

		$comments = fetch_article_comments(10, 0, $article_id);
		$all_comments = fetch_article_comments(2000, 0, $article_id);

		$output = '<h1 class="block text-lg font-semibold mb-4"> Comments (' . count($all_comments) . ') </h1>
                     <div class="space-y-5">';
		foreach ($comments as $comment) {
			$author = find_user_by_id($comment->user_id);
			$replies = fetch_article_comments_reply(20, 0, $comment->id);

			$output .= '<div class="flex gap-x-4 relative rounded-md">
                             <img src="/' . $author->profilepic . '" alt="" class="rounded-full shadow w-12 h-12">
                             <a href="#" class="reply_btn bg-gray-100 py-1.5 px-4 rounded-full absolute right-5 top-0" data-comment_id="' . $comment->id . '">Reply</a>
                             <div>
                                 <h4 class="text-base m-0 font-semibold">' . $author->name . ' ' . $author->nom2 . '</h4>
                                 <span class="text-gray-700 text-sm">' . date('F j, Y', strtotime($comment->commented_at)) . '</span>
                                 <p class="mt-3 md:ml-0 -ml-16">
                                    ' . $comment->content . '
                                 </p>
                      
                             </div>
                         </div>
                          <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t" id="reply_box' . $comment->id . '" style="display:none;">
                                                    <input placeholder="Reply to ' . $author->name . ' comment..." class="reply_comment bg-transparent max-h-10 shadow-none px-5" data-article_id="' . $_GET['a_i'] . '" id="reply' . $comment->id . '" data-comment_id="' . $comment->id . '">
                                                    <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                                        <a href="" class="py-3 px-4 post_reply" data-article_id="' . $_GET['a_i'] . '" data-comment_id="' . $comment->id . '" style="display:none; font-size:15px;" id="rbtn' . $comment->id . '">Post</a>
                                                    </div>
                                </div>
                         ';
			if (count($replies) != 0) {
				foreach ($replies as $reply) {
					$author = find_user_by_id($reply->user_id);
					$output .= '
                             <div class="flex gap-x-4 relative rounded-md lg:ml-16">
                             <a href="timeline.php?id=' . $reply->user_id . '"><img src="/' . $author->profilepic . '" alt="" class="rounded-full shadow w-12 h-12"></a>
                                         <div>
                                             <h4 class="text-base m-0 font-semibold">' . $author->name . ' ' . $author->nom2 . '</h4>
                                             <span class="text-gray-700 text-sm"> ' . date('F j, Y', strtotime($reply->commented_at)) . ' </span>
                                             <p class="mt-3 md:ml-0 -ml-16">
                                             ' . $reply->content . '
                                             </p>
                                         </div>
                             </div>
                             ';
				}
			}
		}

		$output .= '</div>';
		return $output;
	}
}

// Fonction pour verifier si un utilisateur a lu un article
if (!function_exists('is_article_seen')) {
	function is_article_seen($article_id, $user_id)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM articles_seen
				WHERE user_id= :user_id AND article_id= :article_id');
		$q->execute([
			'user_id' => $user_id,
			'article_id' => $article_id
		]);
		return (bool) $q->rowCount();
	}
}

// Fonction pour va deja a un evenement
if (!function_exists('is_him_going')) {
	function is_him_going($event_id, $user_id, $starting_date)
	{
		global $db;
		$q = $db->prepare('SELECT id FROM event_sessions
				WHERE user_id= :user_id AND event_id= :event_id AND starting_date= :starting_date');
		$q->execute([
			'user_id' => $user_id,
			'event_id' => $event_id,
			'starting_date' => $starting_date
		]);

		return (bool) $q->rowCount();
	}
}

// Fonction pour compter le nbre des records
if (!function_exists('records_count')) {
	function records_count($table, $column1, $value1)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM ' . $table . '
				WHERE ' . $column1 . '= ' . $value1 . '');
		$q->execute();

		return $q->rowCount();
	}
}

// Fonction pour verifier si un record avec deux valeurs existe
if (!function_exists('record_check')) {
	function record_check($table, $column1, $value1, $column2, $value2)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM ' . $table . '
				WHERE ' . $column1 . '= ' . $value1 . ' AND ' . $column2 . '= ' . $value2 . ' ');
		$q->execute();

		return $q->rowCount();
	}
}

// Fonction pour recuperer les records
if (!function_exists('records_getter')) {
	function records_getter($table, $column1, $value1, $column2, $value2)
	{

		global $db;
		$q = $db->prepare('SELECT * FROM ' . $table . '
					WHERE ' . $column1 . '= ' . $value1 . ' AND ' . $column2 . '= ' . $value2 . ' ');
		$q->execute();

		return $q->fetchAll(PDO::FETCH_OBJ);
	}
}

// Fonction pour afficher les utlisateurs aime un post
if (!function_exists('display_event_likers_v2')) {
	function display_event_likers_v2($post_id, $user_id, $event_id)
	{

		$like_count = record_check("event_posts_like", "event_id", $event_id, "post_id", $post_id);
		$likers = records_getter("event_posts_like", "event_id", $event_id, "post_id", $post_id);

		$output = '<div class="flex items-center">';

		if ($like_count > 0) {
			$remaining_like_count = $like_count - 1;
			$itself_like = record_check('event_posts_like', 'user_id', $_SESSION['user_id'], 'post_id', $user_id);

			foreach ($likers as $liker) {
				$last_user = find_user_by_id($liker->user_id);
			}
			$output .= '<strong>';
			if (count($likers) == 1) {
				$output .= '<a href="timeline.php?id=' . $last_user->id . '">' . $last_user->name . ' ' . $last_user->nom2 . '</a> like</strong>';
			} elseif (count($likers) > 1) {
				$output .= '<a href="timeline.php?id=' . $last_user->id . '">' . $last_user->name . ' ' . $last_user->nom2 . '</a> <span uk-toggle="target: #liked-modal' . $micropost_id . '">and ' . $remaining_like_count . ' more</span></strong>';
			} else {
				$output .= '</strong>';
			}
			$output .= '</div>';
			return $output;
		}
	}
}

// Fonction affichent les utilisateurs qui aiment une placepost
if (!function_exists('display_placepost_likers_v2')) {
	function display_placepost_likers_v2($post_id)
	{

		$like_count = pget_like_count($post_id);
		$likers = pget_likers($post_id);

		$output = '';

		if ($like_count > 0) {
			$remaining_like_count = $like_count - 1;
			$itself_like = check_if_the_current_user_has_liked_the_placepost($post_id);
			foreach ($likers as $liker) {
				$last_user = find_user_by_id($liker->id);
			}

			$output .= '<strong>';
			if (count($likers) == 1) {
				$output .= '<a href="timeline.php?id=' . $last_user->id . '">' . $last_user->name . ' ' . $last_user->nom2 . '</a> likes</strong>';
			} elseif (count($likers) > 1) {
				$output .= '<a href="timeline.php?id=' . $last_user->id . '">' . $last_user->name . ' ' . $last_user->nom2 . '</a> <span uk-toggle="target: #liked-modal' . $post_id . '">and ' . $remaining_like_count . ' more</span></strong>';
			} else {
				$output .= '</strong>';
			}
			$output .= '</div>';
			return $output;
		}
	}
}

// Fonction pour verifier si recuperer 7 amis qui suivent une place quelconque
if (!function_exists('place_followers')) {
	function place_followers($place_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM places_followers
				WHERE place_id= ' . $place_id . '');
		$q->execute();
		$place_nbr = $q->rowCount();
		$places = $q->fetchAll(PDO::FETCH_OBJ);

		$index  = 0;
		$output = '<div class="flex items-center -space-x-2 -mt-1">';

		foreach ($places as $place) {

			if ($place->user_id != $_SESSION['user_id']) {
				$index++;
				$him = find_user_by_id($place->user_id);
				if ($index <= 3) {
					$output .= '<a href="timeline.php?id=' . $him->id . '&n=' . $him->name . '"><img alt="' . $him->name . ' profile" src="' . $him->profilepic . '" class="border-2 border-white rounded-full w-7" style="height:28px;"></a>';
					$last_one = find_user_by_id($place->user_id);
				}
			}
		}
		$output .= '</div>';

		if ($place_nbr > 3) {

			$output .= '<div class="flex-1 leading-4 text-sm">
                     <div> <a href="timeline.php?id=' . $last_one->id . '&n=' . $last_one->name . '"><strong>' . $last_one->name . '</strong></a> and ' . ($place_nbr - 3) . ' follow </div>
                </div>';
		}

		return $output;
	}
}

// Fonction pour verifier si recuperer 6 followers qui suivent une place quelconque
if (!function_exists('place_followers_2')) {
	function place_followers_2($place_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM places_followers
				WHERE place_id= ' . $place_id . '');
		$q->execute();
		$place_nbr = $q->rowCount();
		$places = $q->fetchAll(PDO::FETCH_OBJ);

		$index  = 0;
		$output = '<div class="flex items-center -space-x-4">';

		if (count($places) > 2) {
			foreach ($places as $place) {

				if ($place->user_id != $_SESSION['user_id']) {
					$index++;
					$him = find_user_by_id($place->user_id);
					if ($index <= 3) {
						$output .= ' <img src="' . $him->profilepic . '" alt="' . $him->name . ' profile picture" class="w-10 h-10 rounded-full border-2 border-white">';
						$last_one = find_user_by_id($place->user_id);
					}
				}
			}
			$output .= '<div class="w-10 h-10 rounded-full flex justify-center items-center bg-red-100 text-red-500 font-semibold"> ' . (count($places) - 1) . '+</div>';
		} else {
			$output .= '';
		}

		return $output;
	}
}

if (!function_exists('forum_state_verification_v1')) {
	function forum_state_verification_v1($user_id, $state, $forum_id)
	{
		global $db;
		$q = $db->prepare('SELECT * FROM forum_members WHERE user_id= :user_id AND etat= :etat AND forum_id= :forum_id');
		$q->execute([
			'user_id' => $user_id,
			'etat' => $state,
			'forum_id' => $forum_id
		]);
		$data = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		return $data;
	}
}

// Fonction pour compter les nombres d'amis
if (!function_exists('friends_count_v2')) {
	function friends_count_v2($user_id)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
	                            WHERE (user_id1 = :user_connected OR user_id2 = :user_connected)
	                            AND status ='1'");
		$q->execute([
			'user_connected' => $user_id
		]);

		$count = $q->rowCount();


		$q->closeCursor();

		return $count;
	}
}

// Fonction pour recuperer les amis en commun
if (!function_exists('friends_in_common')) {
	function friends_in_common($user_id1, $user_id2)
	{
		global $db;
		$q = $db->prepare("SELECT f1.user_id2 AS common_friend
				FROM friends_relationships AS f1 JOIN friends_relationships AS f2
				USING (user_id2)
				WHERE f1.user_id1= :user_id1 AND f2.user_id1= :user_id2 
				AND f1.status= :status AND f2.status= :status");

		$q->execute([
			'user_id1' => $user_id1,
			'user_id2' => $user_id2,
			'status' => 1
		]);

		$data = $q->fetchAll(PDO::FETCH_OBJ);

		return $data;
	}
}

//Pour recuperer les messages non-lus entre deux utilisateurs
if (!function_exists('unseen_message_2_vs_2')) {
	function unseen_message_2_vs_2($from_user_id, $to_user_id)
	{
		global $db;
		$query = "
             SELECT * FROM chat_message 
             WHERE from_user_id = '$from_user_id'
             AND to_user_id = '$to_user_id'
             AND status = '1'
            ";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();

		return $count;
	}
}

//Message non lu pour un utilisateur
if (!function_exists('unseen_message')) {
	function unseen_message($user_id)
	{

		global $db;
		$q = $db->prepare("SELECT id FROM chat_message
	                            WHERE to_user_id= :to_user_id AND status= :status
	                            ");
		$q->execute([
			'to_user_id' => $user_id,
			'status' => 1
		]);

		$count = $q->rowCount();

		return $count;
	}
}

if (!function_exists('fetch_is_type_status_v2')) {
	function fetch_is_type_status_v2($user_id)
	{

		global $db;
		$query = "
       SELECT is_type FROM login_details
       WHERE user_id = '" . $user_id . "'
       ORDER BY last_activity DESC
       LIMIT 1
    ";

		$user = find_user_by_id($user_id);

		$statement = $db->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '';
		foreach ($result as $row) {
			if ($row["is_type"] == 'yes') {
				$output = '<div class="message-bubble">
                                        <div class="message-bubble-inner">
                                            <div class="message-avatar"><img src="/' . $user->profilepic . '" alt=""></div>
                                            <div class="message-text">
                                                <!-- Typing Indicator -->
                                                <div class="typing-indicator">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
             </div>';
			}
		}
		return $output;
	}
}

if (!function_exists('fetch_2users_common_friends')) {
	function fetch_2users_common_friends($user_id, $user_id1)
	{
		global $db;

		$q = $db->prepare("SELECT * FROM friends_relationships
	                            WHERE (user_id1 = :user_id
								OR user_id2 = :user_id)
								AND status = :status
			   	                 ");
		$q->execute([
			'user_id' => $user_id,
			'status' => 1
		]);

		$data1 = $q->fetchAll(PDO::FETCH_OBJ);

		$q = $db->prepare("SELECT * FROM friends_relationships
	                            WHERE (user_id1 = :user_id
								OR user_id2 = :user_id)
								AND status = :status
			   	                 ");
		$q->execute([
			'user_id' => $user_id1,
			'status' => 1
		]);

		$data2 = $q->fetchAll(PDO::FETCH_OBJ);

		//$result = array_intersect($data1,$data2);

		return $data2;
	}
}

// Fonction verifier si un utilisateur a deja fait la commande d'un certain produit
if (!function_exists('already_in_cart')) {
	function already_in_cart($user_id, $object_id)
	{
		global $db;

		$q = $db->prepare('SELECT id FROM place_orders
							 WHERE user_id= ? AND object_id= ?');
		$q->execute([$user_id, $object_id]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour compter les nombres d'amis
if (!function_exists('friends_count_v2')) {
	function friends_count_v2($user_id)
	{
		global $db;
		$q = $db->prepare("SELECT status FROM friends_relationships
						 WHERE (user_id1 = :user_connected OR user_id2 = :user_connected)
						 AND status ='1'");
		$q->execute([
			'user_connected' => $user_id
		]);

		$count = $q->rowCount();
		$q->closeCursor();

		return $count;
	}
}

//Fonction pour recuperer les commentaires sur un jeu
if (!function_exists('fetch_game_comments')) {
	function fetch_game_comments($game_id)
	{
		global $db;
		$q = $db->prepare("SELECT * FROM games_comments
		WHERE game_id= :game_id");
		$q->execute([
			'game_id' => $game_id
		]);
		$comments = $q->fetchAll(PDO::FETCH_OBJ);
		$q->closeCursor();
		return $comments;
	}
}

// Fonction verifier si un appel est en cours
if (!function_exists('video_call_in_progress')) {
	function video_call_in_progress($from_user_id, $to_user_id)
	{
		global $db;
		$status = "in_progress";
		$q = $db->prepare('SELECT id FROM video_calls
						  WHERE from_user_id= ? AND to_user_id= ? AND status=?');
		$q->execute([$from_user_id, $to_user_id, $status]);

		$count = $q->rowCount();
		$q->closeCursor();

		return (bool) $count;
	}
}

// Fonction pour verifier si deux utilisateur ont deja lancé une conversation
if (!function_exists('conversation_started')) {
	function conversation_started($user_id1, $user_id2)
	{
		global $db;
		$q = $db->prepare("SELECT * FROM conversations_tb
	                       WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2) OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");
		$q->execute([
			'user_id1' => $user_id1,
			'user_id2' => $user_id2
		]);
		$data = $q->fetch(PDO::FETCH_OBJ);

		if (!empty($data)) {
			return true;
		} else {
			return false;
		}
		$q->closeCursor();
	}
}
// Function pour recuperer le dernier messager d'une discussion
if (!function_exists('latest_chat_messages')) {
	function latest_chat_messages($user_id1, $user_id2)
	{

		global $db;
		$query = "
       		SELECT * FROM chat_message WHERE (from_user_id=" . $user_id1 . " AND to_user_id=" . $user_id2 . ") OR (from_user_id=" . $user_id2 . " AND to_user_id=" . $user_id1 . ") ORDER BY id DESC LIMIT 1
    	";

		$statement = $db->prepare($query);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_OBJ);

		return $result;
	}
}
