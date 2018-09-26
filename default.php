ß<?php
//requre init file
require 'init.php';

if(isset($_POST['vid'])) {

	$vid = ($_POST['vid'] != "" && $_POST['vid'] != null) ? $_POST['vid'] : false;

	if ( strval($vid) == strval(intval($vid)) ) {

		//get variation from database
		$variation = $db->getByid('variations', $vid)->first();

		if($variation) {

			$variations = $db->getAll('variations')->toArray();

	        foreach($variations as $v) {
	            $db->update('variations', $v['id'], [
	                'default' => 0
	            ]);
	        }

	        $db->update('variations', $vid, [
	            'default' => 1
	        ]);
		}
	}
}
