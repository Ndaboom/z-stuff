<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require('includes/constants.php');

       ?>

      <?php if($page == "timeline"): ?>

     <link rel="icon" href="/<?= $user->profilepic ?>">

     <meta charset="utf-8">

     <meta name="author" content="Sammy Ndabo">

     <meta name="description" content="<?= $user->name ?> <?= $user->nom2 ?> - Profile">

     <meta name="viewport" content="width=device-width, initial-scale=1"><meta property="image" content="/<?= $user->profilepic ?>">

     <?php elseif($page == "article"): ?>

     <link rel="icon" href="<?= $article->image ?>">

     <meta charset="utf-8">

     <meta name="author" content="Sammy Ndabo">

     <meta name="description" content="<?= substr($article->body, 0, 70) ?>">

     <meta name="viewport" content="width=device-width, initial-scale=1"><meta property="image" content="/<?= $article->image ?>">

     

     <!-- Others meta-data  -->

     <meta property="og:url"           content="https://www.zungvi.com/article.php?n=<?= $article->title ?>&a_i=<?= $article->id ?>" />

     <meta property="og:type"          content="website" />

     <meta property="og:title"         content="Zungvi - <?= $article->title ?>" />

     <meta property="og:description"   content="<?= substr($article->body, 0, 70) ?>" />

     <meta property="og:image"         content="https://www.zungvi.com/<?= $article->image ?>" />

     <?php else: ?>

     <link rel="icon" href="icon/zungvi.ico">

     <meta charset="utf-8">

     <meta name="author" content="Sammy Ndabo">

     <meta name="description" content="Keeps you connected to your loved ones and friends">

     <meta name="viewport" content="width=device-width, initial-scale=1"><meta property="image" content="assets/css/bckg-min.jpg">

     <?php endif; ?>



    <!-- Basic Page Needs

        ================================================== -->

    <title>
        <?=

	isset($title) ? $title.' - '.WEBSITE_NAME

	:WEBSITE_NAME.'-';

	?>
    </title>
    <!-- CSS 
    ================================================== -->
   <link rel="stylesheet" href="assets/css/icons.css"> 
   <link rel="stylesheet" href="assets/css/tailwind.css">
   <link rel="stylesheet" href="assets/css/uikit.css">

   <?php if($title == "Settings" || $title == "Create forum" 
            || $title == "Events" || $page == "event_home" 
            || $page == "article" || $page == "explorer" 
            || $page == "pages" || $page == "games" ): ?>

   <link rel="stylesheet" href="assets/css/v2/style.css">

   <?php endif; ?>

   <link rel="stylesheet" href="assets/css/style.css">



    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <script nomodule="" src="/assets/js/ionicons.js"></script>
    <script nomodule="" src="/assets/js/icofont.min.css"></script>
    <script nomodule="" src="assets/js/ionicons.js"></script>
    <script type="module" src="/assets/js/ionicons/ionicons.esm.js"></script>
    <script src="/assets/css/feather.css"></script>
    <link rel="stylesheet"  href="assets/css/emoji/emojionearea.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        .like, .share , .single_story{

            cursor: pointer;

        }
        .rounded-circle{
            border-radius: 50% !important;
        }        
        #video_sharing_btn {
            display:none;
        }

        .footer-links{
            font-size: 12px;
        }

        .footer-links a:hover {
            font-weight: bolder;
        }

    </style>
</head>

