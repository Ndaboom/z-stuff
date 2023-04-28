<?php 

if (isset ($_SESSION['notification']['message'])):?>

	<div class="bg-blue-500 border p-4 relative rounded-md uk-alert" uk-alert="">
		<button class="uk-alert-close absolute bg-gray-100 bg-opacity-20 m-5 p-0.5 pb-0 right-0 rounded text-gray-200 text-xl top-0">
			<i class="icon-feather-x"></i>
		</button>
		<h3 class="text-lg font-semibold text-white">Notice</h3>
		<p class="text-white text-opacity-75"><?=$_SESSION['notification']['message'] ?></p>
	</div>

     <?php $_SESSION['notification']=[]; ?>

 <?php endif;