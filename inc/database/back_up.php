<?php
$file = "2019.db";
$newfile = "bu/2019_" . date("D", time()) . ".db";
fopen($newfile, "w");
copy($file, $newfile);