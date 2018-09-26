<?php
//requre init file
require 'init.php';

//get attributes and variations from database
$get_variations = $db->getAll('variations')->toArray();

$variations = [];
$attributes = [];

//generate attribute and generate variation combination
if($get_variations){
	$variations = $variation::generate_combinations($get_variations);
	$attributes = $variation::generate_attributes($variations);
}

//rendering index.html template to the system
echo $twig->render('index.html', [
	'attributes' => $attributes,
	'variations' => $variations
]);
