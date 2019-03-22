<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
    $sth = $db->prepare("select * from players");
    $sth->execute();
    $players = $sth->fetchAll();
    $sth = $db->prepare("
        select
        players.first_name,
        players.second_name,
        rosters.tournament_id,
        teams.team_name_short as team,
        scored,
        conceded,
        scored - conceded as difference,
        played
        from rosters
        inner join players on players.player_id = rosters.player_id
        inner join teams on teams.team_id = rosters.team_id
    ");
    $sth->execute();
    $rosters = $sth->fetchAll();
    var_dump($rosters);
?>
<body>
<main role="main" class="container">
  	<div class="starter-template text-center">
    	<table>
            <thead>
                <th>Игрок</th>
                <th>Див.</th>
                <th>Команда</th>
                <th>Партий</th>
                <th>Забито</th>
                <th>Пропущено</th>
                <th>Разница</th>
                <th>Участие в играх</th>
                <th>Рейтинг</th>
                <th>Процент участия</th>
            </thead>
            <tbody>
                <?php foreach ($rosters as $roster): ?>
                    <tr>
                        <td><?php echo $roster['first_name'] . " " . $roster['second_name']; ?></td>
                        <td><?php echo ($roster['tournament_id'] == "1" ? "П" : "В"); ?></td>
                        <td><?php echo $roster['team']; ?></td>
                        <td><?php echo $roster['scored']; ?></td>
                        <td><?php echo $roster['conceded']; ?></td>
                        <td><?php echo $roster['difference']; ?></td>
                        <td><?php echo $roster['played']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>