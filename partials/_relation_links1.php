 <?php if(relation_link_to_display(e($user->id)) == CANCEL_RELATION_LINK): ?>
        	 	<a href="delete_friend.php?id=<?= $_GET['id'] ?>" class="btn btn-outline-primary btn-md"><i class="fas fa-ban"></i> Cancel the request</a>

                <?php elseif(relation_link_to_display(e($user->id)) == ACCEPT_REJECT_RELATION_LINK): ?>
             	<a href="accept_friend_request.php?id=<?= $_GET['id'] ?>" class="btn btn-outline-primary btn-md">Accept </a>
             	<a href="delete_friend.php?id=<?= $_GET['id'] ?>" class="btn btn-outline-danger btn-md"> Delete</a>

                <?php elseif(relation_link_to_display(e($user->id)) == DELETE_RELATION_LINK): ?>
             	Vous etes deja amis.
             	<a href="delete_friend.php?id=<?= $_GET['id'] ?>" class="btn btn-outline-danger">Remove</a>
                <?php elseif(relation_link_to_display(e($user->id)) == ADD_RELATION_LINK): ?>
             	<a href="add_friend.php?id=<?= $_GET['id'] ?>" class="btn btn-outline-primary btn-md "><i class="fas fa-user-plus"></i> Add to my friends</a>
             	
                <?php endif; ?>