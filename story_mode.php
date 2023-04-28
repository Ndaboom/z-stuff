<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");

// Select all people with stories

$all_stories = $_SESSION['stories'];
print_r($all_stories);

require("views/story_mode.view.php");
