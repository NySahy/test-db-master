<?php
require ('../inc/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistiques par emploi</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Statistiques par emploi</h2>
    <table class="table table-striped">
        <tr>
            <th>Emploi</th>
            <th>Hommes</th>
            <th>Femmes</th>
            <th>Salaire moyen</th>
        </tr>
        <?php foreach(getJobStats() as $stat): ?>
        <tr>
            <td><?= $stat['title'] ?></td>
            <td><?= $stat['hommes'] ?></td>
            <td><?= $stat['femmes'] ?></td>
            <td><?= round($stat['salaire_moyen'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="liste_department.php" class="btn btn-secondary">Retour</a>
</div>
</body>
</html>