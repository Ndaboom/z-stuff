<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
  
  $query ="SELECT *
          FROM place_orders
          WHERE user_id= :user_id
          ORDER BY ordered_at DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
        $statement = $db->prepare($query);
    	$statement->execute([
           'user_id'=>get_session('user_id')
    	]);
    	$objects = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '
        <div class="drop_headline">

            <h4>  My Cart </h4>

            <a href="#" class="btn_action hover:bg-gray-100 mr-2 px-2 py-1 rounded-md underline checkout"> Validate </a>

        </div>
        <ul class="dropdown_cart_scrollbar" data-simplebar>
        ';
        $total = 0;
    	
    	if($total_row > 0)
    	{
            foreach($objects as $row){
            
            $unit_price = str_replace('$','',$row->object_price);  
            $total = $total+$unit_price;

            if($row->is_send){
                $remove_btn = '
                <button class="type" data-product_id="'.$row->id.'" data-product_name="'.$row->designation.'">Already sent</button>
                ';
            }else{
                $remove_btn = '
                <button class="type remove_product" data-product_id="'.$row->id.'" data-product_name="'.$row->designation.'"> Remove</button>
                ';
            }

            $output .= '
                <li id="box_product'.$row->id.'">

                    <div class="cart_avatar">

                        <img src="/'.$row->image.'" alt="'.$row->designation.' image">

                    </div>

                    <div class="cart_text">

                        <div class="font-semibold leading-4 mb-1.5 text-base line-clamp-1"> '.$row->designation.' </div>

                        <p class="text-sm text-green">Type Accessories </p>

                    </div>

                    <div class="cart_price">
                        <span> $'.$row->object_price.' </span>
                        '.$remove_btn.'
                    </div>

                </li>
            ';
            }
           
        }else{
            $output .= 'Nothing to display...';
        }

        $output .= '
        </ul>
        <div class="cart_footer">

            <p> Subtotal : $ '.$total.' </p>

            <h1> Total :  <strong> $ '.$total.'</strong> </h1>

        </div>
        ';

        echo $output;
 }