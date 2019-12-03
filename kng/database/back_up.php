<?php
$file = "kng.db";
$newfile = "bu/kng_" . date("D", time()) . ".db";
fopen($newfile, "w");
copy($file, $newfile);