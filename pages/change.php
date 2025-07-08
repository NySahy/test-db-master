<?php
session_start();
require('../inc/functions.php');
$list = getListDepartment(); 
$current_dept = getDepartment($_SESSION['dept_no']);
$emp_num = getEmployeesByNo($_SESSION['emp_no']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="change.php" method="post">
        <p>Selectionner votre departement : </p>
        <select name="dept" class="form-control mb-2">
        <option value="">Tous départements</option>
        <?php foreach($list as $d): ?>
            <option value="<?= $d['dept_no'] ?>"><?= $d['dept_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <p>Quand souhaiter vous entrer? :  </p>
        <input type="date" >
        <input type="submit" value = "valider">
    </form>

    <?php if(isset($_POST['dept']) && $_POST['dept'] != $current_dept['dept_name']){ ?>
        <?php echo($_POST['dept']) ?>
        <?php echo($emp_num['emp_no']) ?>
        <?php changeDepartment($_POST['dept'],$emp_num['emp_no']); ?>
        
    <?php } ?>

</body>
</html>