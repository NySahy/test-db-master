<?php
require ('../inc/functions.php');

$department = getListDepartment();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=*, initial-scale=1.0">
  <title>Liste</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-image: url('../assets/images/background1.png');
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <h2>Liste des départements</h2>
  <a href="stats_emploi.php" style="text-decoration:none">Cliquez ici pour voir les statistiques de chaque emploi</a>
  <br>
  <br>
  <table class="table table-striped">
    <tr>
      <th>Nom</th>
      <th>Manager</th>
      <th>Nombre employés</th>
    </tr>
    <?php foreach ($department as $dep) { 
      $manager = getManagerEnCours($dep['dept_no']);
    ?>
      <tr>
        <td><a href="liste_employees.php?dept_no=<?= $dep['dept_no'] ?>" style="text-decoration:none"><?= $dep['dept_name'] ?></a></td>
        <td><?= $manager['first_name'] ?> <?= $manager['last_name'] ?></td>
        <td><?= getEmployeeCountByDept($dep['dept_no']) ?></td>
      </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>