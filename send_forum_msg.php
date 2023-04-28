<?php
<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");


if(isset($_POST['publish'])){

	if(!empty($_POST['content'])){
		extract($_POST);
        
    if (!empty($_FILES)){
	    $file_name =$_FILES['image']['name'];
		$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

		$extensions_autorisees= array('.jpg','.JPG','.jpeg','.png');
	if (in_array($file_extension, $extensions_autorisees)) {

			if (move_uploaded_file($file_tmp_name,$file_dest)) {


	/*$q =$db->prepare('INSERT INTO chat_room(forum_id,sender_name,sender_pic,msg_text,msg_media,created_at)
	                  VALUES (:forum_id,:sender_name,:sender_pic,:msg_text,:msg_media, NOW())');
	    $q->execute([
           'forum_id'=>$id,
	    ]);
	    $q->closecursor();*/
	    //set_flash('Statut added successfully');
	}
}else{
       
        $q =$db->prepare('INSERT INTO microposts(legend,user_id,created_at)
	                 VALUES (:content,:user_id,NOW())');
	    $q->execute([
           'content'=>$content,
           'user_id'=> $_SESSION['user_id']
	    ]);
	    $q->closecursor();
}
}
}
}
    redirect('fil.php?id='.get_session('user_id'));
