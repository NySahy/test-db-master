<?php
session_start();
require('../inc/functions.php');

$employees = getEmployeesByNo($_SESSION['emp_no']);
$current_dept = getCurrentDepartment($_SESSION['emp_no']);
$all_depts = getListDepartment();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_dept = $_POST['dept'];
    $start_date = $_POST['start_date'];
    
    if (strtotime($start_date) < strtotime($current_dept['from_date'])) {
        $error = "La date ne peut pas être antérieure au " . $current_dept['from_date'];
    } else {
        changeDepartment($employees['emp_no'], $new_dept, $start_date);
        header("Location: fiche_employees.php?emp_no=" . $employees['emp_no']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Changer de département</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Changer de département pour <?= $employees['first_name'] ?> <?= $employees['last_name'] ?></h3>
    
    <div class="alert alert-info">
        Département actuel : <strong><?= $current_dept['dept_name'] ?></strong>
        depuis le <?= $current_dept['from_date'] ?>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nouveau département :</label>
            <select name="dept" class="form-control" required>
                <?php foreach($all_depts as $dept): ?>
                    <?php if ($dept['dept_no'] != $current_dept['dept_no']): ?>
                        <option value="<?= $dept['dept_no'] ?>"><?= $dept['dept_name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Date de début :</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Valider</button>
        <a href="fiche_employees.php?emp_no=<?= $employees['emp_no'] ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>