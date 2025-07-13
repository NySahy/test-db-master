<?php
session_start();
require('../inc/functions.php');

$employees = getEmployeesByNo($_GET['emp_no']);
$current_dept = getCurrentDepartment($_GET['emp_no']);
$current_manager = getCurrentManager($current_dept['dept_no']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    
    if (strtotime($start_date) < strtotime($current_manager['from_date'])) {
        $error = "La date ne peut pas être antérieure au " . $current_manager['from_date'];
    } else {
        changeManager($employees['emp_no'], $current_dept['dept_no'], $start_date);
        header("Location: fiche_employees.php?emp_no=" . $employees['emp_no']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Devenir Manager</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-image: url('../assets/images/background.png');
    }
    </style>
</head>
<body>
<div class="container mt-4">
    <h3>Nommer <?= $employees['first_name'] ?> <?= $employees['last_name'] ?> comme manager</h3>
    
    <div class="alert alert-info">
        Manager actuel : <strong><?= $current_manager['first_name'] ?> <?= $current_manager['last_name'] ?></strong>
        depuis le <?= $current_manager['from_date'] ?>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Date de début :</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Confirmer</button>
        <a href="fiche_employees.php?emp_no=<?= $employees['emp_no'] ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>