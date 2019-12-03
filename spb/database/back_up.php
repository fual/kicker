<?php
$file = "spb.db";
$newfile = "bu/spb_" . date("D", time()) . ".db";
fopen($newfile, "w");
copy($file, $newfile);