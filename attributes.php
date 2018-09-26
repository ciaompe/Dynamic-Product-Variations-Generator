<?php
//requre init file
require 'init.php';

//get all attributes to the index
$attributes = $db->getAll('attributes')->toArray();

//get all generated variations
$get_variations = $db->getAll('variations')->toArray();

//unserilize the variation meta and save to new array
$variations = [];
if($get_variations){
	foreach($get_variations as $variation) {
	    $variations[] = [
	        'id' => $variation['id'],
	        'meta' => unserialize($variation['meta']),
	        'price' => $variation['price'],
	        'quantity' => $variation['quantity'],
	        'default' => $variation['default']
	    ];
	}
}

//rendering index.html template to the system
echo $twig->render('attributes.html', [
	'attributes' => $attributes,
	'variations' => $variations
]);
