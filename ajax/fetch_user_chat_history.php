<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

echo fetch_user_chat_history($_SESSION['user_id'],$_POST['to_user_id'],$db);