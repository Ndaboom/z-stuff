<?php if($title=="Home"):?>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php"><?php echo WEBSITE_NAME;?> Social Network</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="login.php"> <?= $menu['Sign in'][$_SESSION['locale']]?> </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="inscription.php"><?= $menu['Sign up'][$_SESSION['locale']]?></a>
          </li>
        </ul>

      </div>
      <?php if(isset($_SESSION['user_id']) AND isset($_SESSION['nom2'])): ?>
          <div class="pull-right">
            <a href="fil.php?id=<?= get_session('user_id') ?>" ><img src="<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>" class="rounded-circle" width="40" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" ></a>
          </div>
      <?php endif; ?>
     <ul class="navbar-nav pull-right" style="margin-right: 45px;">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['locale'] == 'fr' ? 'Langues' : 'Languages' ?></a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item <?= $_SESSION['locale'] == 'fr' ? 'active' : '' ?>" href="index.php?lang=fr"><?= $_SESSION['locale'] == 'fr' ? 'Français' : 'French' ?></a>
              <a class="dropdown-item <?= $_SESSION['locale'] == 'en' ? 'active' : '' ?>" href="index.php?lang=en"><?= $_SESSION['locale'] == 'fr' ? 'Anglais' : 'English' ?></a>
            </div>
          </li>
        </ul>
    </nav>
  <?php elseif($title=="Inscription"): ?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php"><?php echo WEBSITE_NAME;?> Social Network</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

          <li class="nav-item<?= $title=="Connection" ? 'active' : '' ?>">
            <a class="nav-link" href="login.php"><?= $menu['Sign in'][$_SESSION['locale']]?></a>
          </li>
          <li class="nav-item <?= $title=="Inscription" ? 'active' : '' ?>">
            <a class="nav-link" href="inscription.php"><?= $menu['Sign up'][$_SESSION['locale']]?></a>
          </li>
        </ul>

      </div>

       <ul class="navbar-nav pull-right" style="margin-right: 45px;">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= $_SESSION['locale'] == 'fr' ? 'Langues' : 'Languages' ?> </a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item <?= $_SESSION['locale'] == 'fr' ? 'active' : '' ?>" href="index.php?lang=fr"><?= $_SESSION['locale'] == 'fr' ? 'Français' : 'French' ?></a>
              <a class="dropdown-item <?= $_SESSION['locale'] == 'en' ? 'active' : '' ?>" href="index.php?lang=en"><?= $_SESSION['locale'] == 'fr' ? 'Anglais' : 'English' ?></a>
            </div>
          </li>
        </ul>

    </nav>
  <?php elseif($title=="Connection"): ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php"><b style="font-size:20px;"><?php echo WEBSITE_NAME;?></b></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

          <li class="nav-item <?= $title=="Connection" ? 'active' : '' ?>">
            <a class="nav-link" href="login.php"><?= $menu['Sign in'][$_SESSION['locale']]?></a>
          </li>
          <li class="nav-item <?= $title=="Inscription" ? 'active' : '' ?>">
            <a class="nav-link" href="inscription.php"><?= $menu['Sign up'][$_SESSION['locale']]?></a>
          </li>

        </ul>

      </div>

       <ul class="navbar-nav pull-right" style="margin-right: 45px;">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['locale'] == 'fr' ? 'Langues' : 'Languages' ?></a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item <?= $_SESSION['locale'] == 'fr' ? 'active' : '' ?>" href="index.php?lang=fr"><?= $_SESSION['locale'] == 'fr' ? 'Français' : 'French' ?></a>
              <a class="dropdown-item <?= $_SESSION['locale'] == 'en' ? 'active' : '' ?>" href="index.php?lang=en"><?= $_SESSION['locale'] == 'fr' ? 'Anglais' : 'English' ?></a>
            </div>
          </li>
        </ul>
    </nav>
  <?php elseif($title=="Terms & Privacy"): ?>
    <span></span>
  <?php elseif(is_logged_in()): ?>
    <style type="text/css">
    .text_box{
     font-family: 'Montserrat', sans-serif;
    }
    #searchbox{
      margin-top: 5px;
      width: 270px;
      height: 30px;
    }
    #display-results{
      position: fixed;
      width: 270px;
      background-color:white;
      color: black;
      border-left: 1px solid #dedede;
      border-right:1px solid #dedede;
      border-bottom: 1px solid #dedede;
      display: none;
    }
    .display-box{
      position: relative; background-color: #ffff; padding: 4px; border-top:1px solid #dedede;
    }


    .display-box a{
      color: #333;
      text-decoration: none;
      display: block;
    }

    .display-box:hover a{
      color: #fff;
      text-decoration: none;
    }
    .display-box:hover{
      background-color: #3b5998;
      color: #fff;
      cursor: pointer;
    }
    .mob_menu{
      display:none;
    }
    @media (min-width:800px){
         .mobile_version{
             display:none;
         }
     }
  </style>
  <?php
  $user_pic         =   selectUserProfilePic(get_session('user_id'));
  $user_name        =   get_user_name(get_session('user_id'));
  $user_second_name =   get_user_second_name(get_session('user_id'));
   ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php" style="font-style: italic;"><b style="font-size:25px;"><?php echo WEBSITE_NAME;?></b></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault" >
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="fil.php"><i class="fas fa-home"></i><span class="badge"></span> News feed</a>
          </li>

          <li class="nav-item" id="message"></li>
         <li class="nav-item"><a class="nav-link" href="notifications.php"><i class="fa fa-bell"></i> Notification<?= $notifications_count > 1 ? '' : 's' ?> <span class="badge" style="background-color: #F3BB00; width:20px;"><?= $notifications_count > 0 ? "$notifications_count" : ''; ?></span>
        </a>
        </li>
          <li class="nav-item dropdown" >
            <a class=" nav-link item dropdown-toggle" data-toggle="dropdown"> <i class="fas fa-globe-africa"></i> Explore <b class="caret"></b></a>
            <ul class="dropdown-menu" style="font-style: italic;">
              <li><a class="dropdown-item" href="zpeople.php"><i class="fas fa-users"></i> Find people</a></li>
              <li><a class="dropdown-item" href="list_forums.php?id=<?= get_session('user_id') ?>"><i class="fas fa-users"></i> Explore forums</a></li>
              <li><a class="dropdown-item" href="list_places.php?id=<?= get_session('user_id') ?>"><i class="far fa-building"></i> Explore places</a></li>
              <li><a class="dropdown-item" href="list_events.php?id=<?= get_session('user_id') ?>"><i class="far fa-calendar"></i> Explore events</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown" >
            <a class=" nav-link item dropdown-toggle" data-toggle="dropdown"> <i class="fas fa-th-large"></i> Add <b class="caret"></b></a>
            <ul class="dropdown-menu" style="font-style: italic;">
              <li><a class="dropdown-item" href="forum.php"><i class="fas fa-users"></i>A forum</a></li>
              <li><a class="dropdown-item" href="place.php"><i class="far fa-building"></i>A place</a></li>

            </ul>
          </li>
          <li>
            <input type="search" id="searchbox" placeholder="search..." class="form-control" style="font-style: italic;">
            <div id="display-results">

            </div>
          </li>
          <li>
            <i class="fas fa-spinner fa-spin" style="display: none; color: white; margin-top: 10px;" id="spinner"></i>
          </li>
        </ul>
        <ul class="navbar-nav pull-right" style="margin-right: 45px;">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src= "<?= e($src =($user_pic->profilepic != null) ? $user_pic->profilepic : 'images/default.png') ?>" style="width: 30px;height: 30px; border:1.5px solid #f5f6fa;" alt=""   alt="image" class="rounded-circle" width="26" > <?= e($user_name->name) ?> <?= e($user_second_name->nom2) ?></a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <!--<a class="dropdown-item" href="edit_user.php?id=<?= get_session('user_id') ?>"><i class="fas fa-cog"></i> Edit my profile<a>-->
              <?php if($_SESSION['user_id'] == '1'): ?>
              <a class="dropdown-item" href="story_mode.php"><i class="far fa-images"></i> Story mode</a>
              <?php endif; ?>
              <a class="dropdown-item" href="change_password.php"><i class="fas fa-key"></i> Change password</a>
              <a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i> Profile </a>
              <a class="dropdown-item" data-toggle="modal" data-target="#themeModal"><i class="fas fa-desktop"></i> Themes </a>
              <a class="divider"></a>
              <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
          </li>
        </ul>

      </div>
    </nav>
    <?php include('partials/theme_modal.php');   ?>
 <?php elseif($title=="ZMembers"): ?>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php"><?php echo WEBSITE_NAME;?> Social Network</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="inscription.php">Sign up<span class="sr-only">(current)</span></a>
          </li>
           <li class="nav-item ">
            <a class="nav-link" href="login.php"> Sign<span class="sr-only">(current)</span></a>
          </li>

        </ul>


      </div>
    </nav>
<?php endif;?>
