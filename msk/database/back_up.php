<?php
$file = "msk.db";
$newfile = "bu/msk_" . date("D", time()) . ".db";
fopen($newfile, "w");
copy($file, $newfile);