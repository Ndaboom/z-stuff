<!doctype html>
 <?php require('includes/constants.php');
       ?>
<html lang="fr">
  <head>
    <meta charset="utf-8">
	 <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="image" content="assets/css/bckg-min.jpg">
    <meta name="description" content="Hi! Need to stay in touch with your loved ones,your community👪? Zungvi is the solution to that problem">
    <meta name="author" content="Sammy Ndabo">
    <link rel="icon" href="icon/zungvi.ico">
    
    <!-- Facebook meta -->
        <!-- You can use Open Graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content="https://www.zungvi.com/mobile" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Zungvi" />
    <meta property="og:description"   content="La 3e édition du 2Gospel talent show a commencé! Venez voter les candidats de votre choix!" />
    <meta property="og:image"         content="https://www.zungvi.com/images/16175000586069179aeecff..jpg" />
    <!-- End facebook meta -->


    <title>
	<?=
	isset($title) ? $title.'-'.WEBSITE_NAME
	:WEBSITE_NAME.'-';

	?>
	</title>

	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <?php $myself = find_user_by_id($_SESSION['user_id']);
         $style = '';
         switch ($myself->theme) {
             case 'cerulean':
              $style = '<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.2/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-EmRcsPP774S9MOi4ywB+JXUWjYnBdyInMzG2XsC5siZEUpexqxOMJW358dCYEjPu" crossorigin="anonymous">
              <style>
              .card-header, .card-footer{
                background-color: white;

              }

              .text-dark{
                color:black;
              }



              </style>';
               break;

             case 'cyborg':
               $style = '<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/cyborg/bootstrap.min.css">
               <style>
               .card{
                 color:white;
               }
               .span{
                 color:white;
               }
               </style>';
               break;

             case 'sketchy':
               $style = '<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/sketchy/bootstrap.min.css">
               <style>
               .card-header, .card-footer{
                 background-color: white;
               }

               </style>';
               break;

             default:
               $style = '<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.2/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-EmRcsPP774S9MOi4ywB+JXUWjYnBdyInMzG2XsC5siZEUpexqxOMJW358dCYEjPu" crossorigin="anonymous">';
               break;
           }
    ?>

    <?= $style  ?>
    <link rel="stylesheet"  href="assets/css/emoji/emojionearea.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
 <?php include('partials/_menu.php'); ?>

  </head>
