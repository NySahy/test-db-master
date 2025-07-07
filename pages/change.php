<?php
require('../inc/functions.php');
$list = getListDepartment();
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
            <option value="<?= $d['dept_name'] ?>"><?= $d['dept_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <p>Quand souhaiter vous entrer? :  </p>
        <input type="date" >
        <input type="submit" value = "valider">
    </form>
   
   <?php $change = changeDepartment($_POST['dept']); ?>


   

    

</body>
</html>