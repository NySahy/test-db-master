<?php
require('../inc/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dept_no = $_POST['dept_no'];
    $dept_name = $_POST['dept_name'];
    
    if (isset($_POST['edit'])) {
        $sql = "UPDATE departments SET dept_name = '$dept_name' WHERE dept_no = '$dept_no'";
    } else {
        $sql = "INSERT INTO departments (dept_no, dept_name) VALUES ('$dept_no', '$dept_name')";
    }
    mysqli_query(dbconnect(), $sql);
    header("Location: liste_department.php");
    exit;
}

$dept = ['dept_no' => '', 'dept_name' => ''];
if (isset($_GET['edit'])) {
    $dept = getDepartment($_GET['edit']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gérer département</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-image: url('../assets/images/background.png');
    }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2><?= isset($_GET['edit']) ? 'Modifier' : 'Ajouter' ?> un département</h2>
    
    <form method="post">
        <div class="form-group">
            <label>Code département :</label>
            <input type="text" name="dept_no" class="form-control" value="<?= $dept['dept_no'] ?>" required>
        </div>
        
        <div class="form-group">
            <label>Nom département :</label>
            <input type="text" name="dept_name" class="form-control" value="<?= $dept['dept_name'] ?>" required>
        </div>
        
        <?php if (isset($_GET['edit'])): ?>
            <input type="hidden" name="edit" value="1">
        <?php endif; ?>
        
        <button type="submit" class="btn btn-primary">Valider</button>
        <a href="liste_department.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>