<?php
$file = "kld.db";
$newfile = "bu/kld_" . date("D", time()) . ".db";
fopen($newfile, "w");
copy($file, $newfile);