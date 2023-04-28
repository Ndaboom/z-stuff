
<?php $title="ZMembers";?>

	<?php 
	require "includes/functions.php";
	include('partials/_header.php');?>
	
    <body style="background-color: #e9ebee; margin-top: 90px;">
	<div id="main-content" >
      <div class="container" >
        <div class="card card">
          <div class="card-body">
              <h1>People on zungvi</h1>
        <?php foreach (array_chunk($users, 4) as  $user_set): ?> 
          <div class="row">
        <?php foreach ($user_set as $user): ?> 
            <div class="col-md-3 text-center">
            <a href="profile.php?id=<?= $user->id ?>">
              <img src= "<?= e($src =($user->profilepic != null) ? $user->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>" style="height: 150px; width: 150px; border:1.5px solid #f5f6fa;"   alt="image" class="rounded-circle" >
            </a>
            <a href="profile.php?id=<?= $user->id ?>">
              <h3 class="user-block-username"><?= e($user->name)?><br />
              <?= e($user->country)?> <?= e($user->city)?>
            </h3>
            </a>
            
          </div>
        <?php endforeach; ?>
         </div>
        <?php endforeach; ?>
        <div class="text-center">
           <div id="pagination"><?= $pagination ?></div>
        </div>

          </div>
          
        </div>
 </div>
</div>							
    </body>
   
	<?php include('partials/footer.php');?>
	

