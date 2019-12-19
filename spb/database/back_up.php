<?php
$file = "spb.db";
$newfile = "back_up/spb_" . strtolower(date("D", time())) . ".db";
fopen($newfile, "w+");
copy($file, $newfile);