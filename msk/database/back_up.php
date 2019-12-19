<?php
$file = "msk.db";
$newfile = "back_up/msk_" . strtolower(date("D", time())) . ".db";
fopen($newfile, "w+");
copy($file, $newfile);