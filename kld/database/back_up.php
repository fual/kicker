<?php
$file = "kld.db";
$newfile = "back_up/kld_" . strtolower(date("D", time())) . ".db";
fopen($newfile, "w+");
copy($file, $newfile);