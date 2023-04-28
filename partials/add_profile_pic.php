<?php 
if (!empty($_FILES)) {
                      	
                      	$file_name = $_FILES['fichier']['name'];
                      	$file_extension=strrchr($file_name, ".");
                      	$file_tmp_name=$_FILES['fichier']['tmp_name'];
                      	$file_dest='images/'.$file_name;
                      	$extensions_autorisees= array('.jpg','.jpeg','.png');

                      	if (in_array($file_extension, $extensions_autorisees)) {
                    
                      		if (move_uploaded_file($file_tmp_name, $file_dest)) {
                                
                      			$q = $db->prepare('
                            			INSERT INTO profilePics(id, name, url) 
                            			VALUES(:id, :name, :url)
                            		'); 
                                $q1 = $db->prepare('
                                       UPDATE users SET url= :url 
                                       WHERE id = :id 
                                	');
                                $q1->execute(array(
                                        'url'=>$file_dest
                                ));

                            	if(
                            		$q->execute(array(
                            			'id'=>$_SESSION['user_id'],
                            			'name'=>$file_name,
                            			'url'=>$file_dest,
                            			
                            		))
                            	){
                            		?>
                      			<?php
                      				redirect('profile.php?id='.get_session('user_id'));
                      			
                            	}    

                      			
                            }
                      		else{
                      			echo "une erreur est survenue lors de l'envoie du fichier";
                      		}
                      	}else{
                      		echo "Format non pris en charge";
                      	}
                      }

?> 