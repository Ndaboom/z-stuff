<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("includes/event_functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user=find_user_by_id($_SESSION['user_id']);
$event = find_event_by_id($_GET['ev_i']);
$candidates=get_candidates($_GET['ev_i']);

$title = $event->event_name;
require("views/homeevent.view.php");