<?php
session_start();
  require ('../inc/functions.php');

  if (!isset($_GET['nom']) || !isset($_GET['dept'])) { 
    $dept_no = $_GET['dept_no'];
    $department = getDepartment($dept_no);
    $page = 1;
    $limit = 20;

  if(isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  
  $offset = ($page - 1) * $limit;
  $employees = get20Employees($dept_no, $offset, $limit);
  

  // if (isset($_GET['age_min']) && isset($_GET['age_max'])) {
  //   $min_age = $_GET['age_min'];
  //   $max_age = $_GET['age_max'];
  //   // $employees = filterEmployeesByAge($employees, $min_age, $max_age);
  // }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=*, initial-scale=1.0">
  <title>Fiche</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-image: url('../assets/images/background1.png');
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <?php if (!isset($_GET['nom']) || !isset($_GET['dept'])) { ?>
    <h2>Employés du département <?= $department['dept_name'] ?></h2>
    <form method="get" class="mb-4">
      <input type="text" name="nom" placeholder="Nom employé" class="form-control mb-2">
      <select name="dept" class="form-control mb-2">
        <option value="">Tous départements</option>
        <?php foreach(getListDepartment() as $d): ?>
          <option value="<?= $d['dept_no'] ?>"><?= $d['dept_name'] ?></option>
          <?php endforeach; ?>
    </select>
    <input type="number" name="age_min" placeholder="Âge min" class="form-control mb-2">
    <input type="number" name="age_max" placeholder="Âge max" class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Rechercher</button>
  </form>
  <?php } ?>

  <?php if (isset($_GET['nom']) || isset($_GET['dept'])) { ?>
  <?php $emp_name = getRecherche($_GET['nom'], $_GET['dept']); ?>
  <?php echo $_GET['nom'] ?>
  <?php echo $_GET['dept'] ?>
<table class="table table-striped">
  <tr>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Genre</th>
      <th>Date d'embauche</th>
  </tr>
  <?php  foreach ($emp_name as $emp_n) { ?>
    <tr>
      <td><?= $emp_n['birth_date'];?></td>
      <td><?= $emp_n['first_name'];?></td>
      <td><?= $emp_n['last_name'];?></td>
      <td><?= $emp_n['gender'];?></td>
      <td><?= $emp_n['hire_date'];?></td>
      <?php } ?>
    </tr>
      <?php } ?>
</table>

  <?php if (!isset($_GET['nom']) || !isset($_GET['dept'])) { ?>
    
    <table class="table table-striped">
      <tr>
      <th>Prénom</th>
      <th>Nom</th>
      <th>Date d'embauche</th>
    </tr>
    <?php foreach ($employees as $emp) { ?>
      <tr>
        <td><a href="fiche_employees.php?emp_no=<?= $emp['emp_no'] ?>" style="text-decoration: none"><?= $emp['first_name'] ?></a></td>
        <td><?= $emp['last_name'] ?></td>
        <td><?= $emp['hire_date'] ?></td>
      </tr>
      <?php } ?>
    </table>
    <button class="btn btn-secondary" onclick="window.location.href='?dept_no=<?= $dept_no ?>&page=<?= $page - 1 ?>'"
        <?php if ($page <= 1)
          echo 'disabled';
        ?>>
          < Précédent
    </button>
    <span>Page <?= $page ?></span>
    <button class="btn btn-secondary" onclick="window.location.href='?dept_no=<?= $dept_no ?>&page=<?= $page + 1 ?>'"
        <?php if ($page >= 7)
          echo 'disabled';
        ?>>
          Suivant > 
    </button>
  <?php } ?>
  <a href="liste_department.php" class="btn btn-secondary">Retour</a>
  <?php 
  $_SESSION['dept_no'] = $dept_no;
  ?>
</div>
</body>
</html>