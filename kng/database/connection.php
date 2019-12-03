<?php
	try {
	    $db = new PDO('sqlite:'.__DIR__.'/kng.db');
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	} catch (\Exception $e) {
	    echo 'Error connecting to the Database: ' . $e->getMessage();
	    exit;
	}