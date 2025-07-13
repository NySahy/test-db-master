<?php
require ('../inc/functions.php');

$emp_no = $_GET['emp_no'];
$employees = getEmployeesByNo($emp_no);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=*, initial-scale=1.0">
  <title>Fiche de l'employé</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-image: url('../assets/images/background1.png');
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <table class="table table-striped">
    <tr>
      <th>ID</th>
      <th>Date de naissance</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Genre</th>
      <th>Date d'embauche</th>
    </tr>
      <tr>
        <td><?= $employees['emp_no'] ?></td>
        <td><?= $employees['birth_date'] ?></td>
        <td><?= $employees['first_name'] ?></td>
        <td><?= $employees['last_name'] ?></td>
        <td><?= $employees['gender'] ?></td>
        <td><?= $employees['hire_date'] ?></td>
      </tr>
      <tr>
        <th>Poste le plus long</th>
        <td><?= getLongestJob($emp_no)['title'] ?></td>
        <td colspan="4"></td>
      </tr>
    </table>
    <a href="change_department.php?emp_no=<?= $employees['emp_no'] ?>" class="btn btn-secondary">Changer de département</a>
    <a href="change_manager.php?emp_no=<?= $employees['emp_no'] ?>" class="btn btn-info">Devenir Manager</a>
    <a href="aj_mod_department.php?emp_no=<?= $employees['emp_no'] ?>" class="btn btn-secondary">Ajouter ou Modifier un département</a>
    <a href="aj_mod_manager.php?emp_no=<?= $employees['emp_no'] ?>" class="btn btn-info">Ajouter ou Modifier un manager</a>
  <h3>Historique des salaires</h3>
  <table class="table">
      <?php foreach(getSalaryHistory($emp_no) as $salary): ?>
      <tr>
          <td><?= $salary['salary'] ?></td>
          <td><?= $salary['from_date'] ?> à <?= $salary['to_date'] ?></td>
      </tr>
      <?php endforeach; ?>
  </table>
  <h3>Historique des postes</h3>
  <table class="table">
      <?php foreach(getJobHistory($emp_no) as $job): ?>
      <tr>
          <td><?= $job['title'] ?></td>
          <td><?= $job['from_date'] ?> à <?= $job['to_date'] ?></td>
      </tr>
      <?php endforeach; ?>
  </table>
  <a href="liste_department.php" class="btn btn-secondary">Retour</a>
</div>
</body>
</html>