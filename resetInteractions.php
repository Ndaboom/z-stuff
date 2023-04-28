<?php
session_start();
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");


$q=$db->prepare("SELECT f1.user_id2 AS common_friend
				FROM friends_relationships AS f1 JOIN friends_relationships AS f2
				USING (user_id2)
				WHERE f1.user_id1= :user_id1 AND f2.user_id1= :user_id2 
				AND f1.status= :status AND f2.status= :status");

		$q->execute([
			'user_id1'=>1,
			'user_id2'=>2,
			'status'=>1
		]);

		$data1 = $q->fetchAll(PDO::FETCH_OBJ);

		print_r($data1);
		exit();

$q=$db->prepare("SELECT user_id1,user_id2 FROM friends_relationships
						WHERE (user_id1 = :user_connected OR user_id2 = :user_connected)
						AND status ='1'");
$q->execute([
	'user_connected'=> 2
]);

$data2 = $q->fetchAll(PDO::FETCH_OBJ);
$common_friends = array_intersect($data1, $data2);

print_r($common_friends);
		
// $q->closeCursor();

// // if(get_session('user_id') == 1){
// //    /** Plus important ,etait utilise pour mettre a jour la nouvelle default pic des filles
// //     $q = $db->prepare('SELECT * FROM users');
// //     $q->execute();
// //     $users = $q->fetchAll(PDO::FETCH_OBJ);

// //     foreach($users as $user)
// //     {
// //         if($user->sex == "F" && $user->profilepic == "images/default.png")
// //     {
// //     $q = $db->prepare('UPDATE users
// //                        SET profilepic= :profilepic
// //                        WHERE id= :user_id');
// //     $q->execute([
// //         'profilepic'=>"images/default_girl.png",
// //         'user_id'=>$user->id
// //         ]);
// //     }else
// //     {
// //         $found = "nothing";
// //     }

// //     }
// //     **/


// // $q =$db->prepare("SELECT interactions FROM
// //                    login_details WHERE
// //                    interactions!= :interactions
// //                    AND user_id!= :user_id
// //                    AND user_id!= :user_id1
// //                    AND user_id!= :user_id2
// //                    AND user_id!= :user_id3
// // 		        ");
// // 		$q->execute([
// // 		'interactions'=>0,
// // 		'user_id'=>1,
// // 		'user_id1'=>18,
// // 		'user_id2'=>333,
// // 		'user_id3'=>299
// // 	    ]);

// // 	$data=$q->fetchAll(PDO::FETCH_OBJ);

// // 	$interactions = 0;
// // 	foreach($data as $row)
// // 	{
// // 	$interactions= $row->interactions + $interactions;
// // 	}

// // 	echo "Interactions ".$interactions."<br>";

// // 	$q=$db->prepare("SELECT status FROM friends_relationships
// // 	                            WHERE status ='1' AND created_at > '2019-12-31 23:59:59'");
// // 	           $q->execute();

// // 	           $count=$q->rowCount();

// // 	echo "<br>Request accepted ".$count;

// // 	$q=$db->prepare("SELECT status FROM friends_relationships
// // 	                            WHERE status ='2'");
// // 	           $q->execute();
// // 	           $count =$q->rowCount();

// // 	echo "<br>Request sent ".$count;

// // 	/**    Request sent this month     **/

// // 		$q=$db->prepare("SELECT status FROM friends_relationships
// // 	                            WHERE status ='2' AND created_at > '2020-07-31 23:59:21'");
// // 	           $q->execute();

// // 	           $count=$q->rowCount();

// // 	echo "<br>Request sent this month ".$count;

// // 	/**    Request accepted this month   **/

// // 		$q=$db->prepare("SELECT status FROM friends_relationships
// // 	                            WHERE status ='1' AND created_at > '2020-07-31 23:59:21'");
// // 	           $q->execute();

// // 	           $count=$q->rowCount();

// // 	echo "<br>Request accepted this month ".$count;

// // 	$q=$db->prepare("SELECT * FROM users");
// //    $q->execute();
// //    $count=$q->rowCount();

// // 	echo "<br>Total number of users ".$count;
// // 	exit();
// // 	/**
// // 	 $q =$db-> prepare("UPDATE login_details
// // 		               SET interactions= :interactions
// // 		              ");
// //     	$q->execute([
// // 		'interactions'=>0
// // 	    ]);
// // 	echo "<br> Success";
// // 	**/
// 	exit();
// 	redirect('fil.php?id='.get_session('user_id'));
// }
