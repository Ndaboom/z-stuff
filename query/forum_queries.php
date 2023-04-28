<?php

$q= $db->prepare('SELECT id,subject,created_at,poster_id,reaction
                      FROM forum_subject
                      WHERE forum_id= :forum_id AND type = :type 
                      LIMIT 1
                      ');
        $q->execute([
           'forum_id'=>get_session('fr_i'),
           'type'=>"subject"
        ]);
        $forumsubjects = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();

$q= $db->prepare('SELECT id,subject,created_at,poster_id,reaction
                      FROM forum_subject
                      WHERE forum_id= :forum_id AND type = :type
                      ');
        $q->execute([
           'forum_id'=>get_session('fr_i'),
           'type'=>"subject"
        ]);
        $Allforumsubjects = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();

$q= $db->prepare('SELECT id,subject,created_at,poster_id,reaction,type,urlmedia1
                      FROM forum_subject
                      WHERE forum_id= :forum_id ORDER BY created_at DESC
                      ');
        $q->execute([
           'forum_id'=>get_session('fr_i')
        ]);
        $AllforumPost = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();
$notifications=forum_notifications_displayer(get_session('fr_i'));
