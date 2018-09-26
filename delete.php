ß<?php
//requre init file
require 'init.php';

if(isset($_POST['vid'])) {

	$vid = ($_POST['vid'] != "" && $_POST['vid'] != null) ? $_POST['vid'] : false;

	if ( strval($vid) == strval(intval($vid)) ) {

		//get variation from database
		$variation = $db->getByid('variations', $vid)->first();

		if($variation) {

			$default = $variation->default;

			$db->delete('variations', $variation->id);

			$variations = $db->getAll('variations')->toArray();

		    if($variations && $default == 1) {
		        $db->update('variations', $variations{0}['id'], [
		            'default' => 1
		        ]);
		    }
		}
	}
}
