<?php 
require_once __DIR__ . "/inc/bootstrap.php";
// $sth = $db->prepare("select * from players");
// $sth->execute();
// $players = $sth->fetchAll();
$db->query("insert into tournaments values (NULL, 'mos_lkl', 2, 'ЛКЛ'), (NULL, 'mos_zkl', 2, 'ЗКЛ')");