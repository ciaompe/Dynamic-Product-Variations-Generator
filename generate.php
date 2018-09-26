<?php
//requre init file
require 'init.php';

if(isset($_POST['attributes'])) {

	$attributes = ($_POST['attributes'] != "" && $_POST['attributes'] != null) ? $_POST['attributes'] : false;

	if($attributes && is_array($attributes)) {

		if(sizeof($attributes) <= 3) {

			$atttributes_with_value = [];

			//get attributes from database and create arrribute with value array
            foreach ($attributes as $attribute) {
                $this_att = $db->getByid('attributes', $attribute)->first();
                $att_values = $db->custom("SELECT `values`.`value` FROM `attributes` JOIN `values` ON `values`.`attribute_id` = `attributes`.`id` WHERE `attributes`.`id` = ?", [$attribute]);
                
                $output = [];
                foreach ($att_values as $key => $value) {
                    $output[$key] = $this_att->name."-".$value['value'];
                }

                if ($output != null) {
                    $atttributes_with_value[$this_att->name] = $output;
                }
            }

            //build attributes
            $generated_attributes = $variation::build($atttributes_with_value);

            //check if variations are already generated
            $get_variations = $db->getAll('variations')->toArray();

            $has_attribute_keys =[];

            $found_deafult = 0;

            if($get_variations) {
	            foreach ($get_variations as $variation) {
	                if ($variation['default'] == 1) {
	                    $found_deafult = 1;
	                }
	                foreach ($generated_attributes as $key => $value) {
	                    if ($value === unserialize($variation['meta'])) {
	                        $has_attribute_keys[] = $key;
	                    }
	                }
	            }
        	}

            //generate random price and quantity array ( this is only for demo)
            $price_arr = [400, 299, 199, 474.78, 699, 329, 525.67];
            $quantity_arr = [0, 45, 52, 88, 200, 70, 150, 200];

            //save generated variation in the database
            foreach ($generated_attributes as $key => $value) {
                if (!in_array($key, $has_attribute_keys)) {

                    //generate random price and quantity array ( this is only for demo)
                    $price = array_rand($price_arr);
                    $quantity = array_rand($quantity_arr);

                    $db->insert('variations', [
                        'meta' => serialize($value),
                        'price' => $price_arr[$price],
                        'quantity' => $quantity_arr[$quantity]
                    ]);
                }
            }

            if (!$found_deafult) {
                //check if attributes already generted or not
                $generate_variations = $db->getAll('variations')->toArray();
   
                $db->update('variations', $generate_variations{0}['id'], [
                    'default' => 1
                ]);
            }

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();

		}else {
			echo json_encode([
				"msg" => "You cannot generate more than 3 attributes variations",
				"status" => 400
			]);
			exit();
		}
		
	}else {
		echo json_encode([
			"msg" => "Variations generate error",
			"status" => 400
		]);
		exit();
	}

}
