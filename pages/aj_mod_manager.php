<?php
require('../inc/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp = [
        'emp_no' => $_POST['emp_no'],
        'birth_date' => $_POST['birth_date'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'hire_date' => $_POST['hire_date'],
        'dept_no' => $_POST['dept_no'],
        'is_manager' => isset($_POST['is_manager'])
    ];
    
    if (isset($_POST['edit'])) {
        $sql = "UPDATE employees SET 
                birth_date = '{$emp['birth_date']}',
                first_name = '{$emp['first_name']}',
                last_name = '{$emp['last_name']}',
                gender = '{$emp['gender']}',
                hire_date = '{$emp['hire_date']}'
                WHERE emp_no = '{$emp['emp_no']}'";
        mysqli_query(dbconnect(), $sql);
        
        changeDepartment($emp['dept_no'], $emp['emp_no'], date('Y-m-d'));
        
        if ($emp['is_manager']) {
            changeManager($emp['emp_no'], $emp['dept_no'], date('Y-m-d'));
        }
    }
    header("Location: liste_employees.php?dept_no={$emp['dept_no']}");
    exit;
}

$employee = ['emp_no' => '', 'first_name' => '', 'last_name' => '', 'birth_date' => '', 
             'gender' => 'M', 'hire_date' => '', 'dept_no' => ''];
$is_manager = false;

if (isset($_GET['edit'])) {
    $employee = getEmployeesByNo($_GET['edit']);
    $current_dept = getCurrentDepartment($_GET['edit']);
    $employee['dept_no'] = $current_dept['dept_no'];
    $is_manager = isManager($_GET['edit']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gérer employé</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-image: url('../assets/images/background.png');
    }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2><?= isset($_GET['edit']) ? 'Modifier' : 'Ajouter' ?> un employé</h2>    
    <form method="post">
        <div class="form-group">
            <label>Prénom :</label>
            <input type="text" name="first_name" class="form-control" value="<?= $employee['first_name'] ?>" required>
        </div>
        
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="last_name" class="form-control" value="<?= $employee['last_name'] ?>" required>
        </div>
        <div class="form-group">
            <label>Date de naissance :</label>
            <input type="date" name="birth_date" class="form-control" value="<?= $employee['birth_date'] ?>" required>
        </div>
        <div class="form-group">
            <label>Genre :</label>
            <select name="gender" class="form-control">
                <option value="M" <?= $employee ['gender'] == 'M' ? 'selected' : '' ?>>Masculin</option>
                <option value="F" <?= $employee ['gender'] == 'F' ? 'selected' : '' ?>>Féminin</option>
            </select>
        </div>
        <div class="form-group">
            <label>Date d'embauche :</label>
            <input type="date" name="hire_date" class="form-control" value="<?= $employee['hire_date'] ?>" required>
        </div>
        <div class="form-group">
            <label>Département :</label>
            <select name="dept_no" class="form-control" required>
                <?php foreach(getListDepartment() as $dept): ?>
                    <option value="<?= $dept['dept_no'] ?>" <?= $dept['dept_no'] == $employee['dept_no'] ? 'selected' : '' ?>>
                        <?= $dept['dept_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-check mb-3">
            <input type="checkbox" name="is_manager" class="form-check-input" id="manager" <?= $is_manager ? 'checked' : '' ?>>
            <label class="form-check-label" for="manager">Manager de ce département</label>
        </div>
        
        <?php if (isset($_GET['edit'])): ?>
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="emp_no" value="<?= $employee['emp_no'] ?>">
        <?php endif; ?>
        
        <button type="submit" class="btn btn-primary">Valider</button>
        <a href="liste_employees.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>