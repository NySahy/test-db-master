<?php
require ('connection.php');

function getListDepartment() {
    $select = "SELECT * FROM departments";
    $query = mysqli_query(dbconnect(), $select);
    $result = array();
    while ($fetch = mysqli_fetch_assoc($query)) {
        $result[] = $fetch;
    }
    return $result;
}

function getManagerEnCours($dept_no) {
    $select = "SELECT employees.first_name, employees.last_name 
               FROM employees
               JOIN dept_manager ON employees.emp_no = dept_manager.emp_no
               WHERE dept_manager.dept_no = '$dept_no' 
               AND dept_manager.to_date = '9999-01-01'";
    $query = mysqli_query(dbconnect(), $select);
    return mysqli_fetch_assoc($query);
}

function getDepartment($dept_no) {
    $select = "SELECT * FROM departments WHERE dept_no = '$dept_no'";
    $query = mysqli_query(dbconnect(), $select);
    return mysqli_fetch_assoc($query);
}

function getEmployeesByDept($dept_no) {
    $select = "SELECT employees.* FROM employees
               JOIN dept_emp ON employees.emp_no = dept_emp.emp_no
               WHERE dept_emp.dept_no = '$dept_no'
               AND dept_emp.to_date = '9999-01-01'";
    $query = mysqli_query(dbconnect(), $select);
    $result = array();
    while ($fetch = mysqli_fetch_assoc($query)) {
        $result[] = $fetch;
    }
    return $result;
}

function getEmployeesByNo($emp_no) {
    $select = "SELECT * FROM employees WHERE emp_no = '$emp_no'";
    $query = mysqli_query(dbconnect(), $select);
    return mysqli_fetch_assoc($query);
}

function getSalaryHistory($emp_no) {
    $select = "SELECT * FROM salaries WHERE emp_no = '$emp_no' ORDER BY from_date DESC";
    $query = mysqli_query(dbconnect(), $select);
    $result = array();
    while ($fetch = mysqli_fetch_assoc($query)) {
        $result[] = $fetch;
    }
    return $result;
}

function getJobHistory($emp_no) {
    $select = "SELECT * FROM titles WHERE emp_no = '$emp_no' ORDER BY from_date DESC";
    $query = mysqli_query(dbconnect(), $select);
    $result = array();
    while ($fetch = mysqli_fetch_assoc($query)) {
        $result[] = $fetch;
    }
    return $result;
}

function get20Employees($dept_no, $offset, $limit) {
    $select = "SELECT employees.* FROM employees
               JOIN dept_emp ON employees.emp_no = dept_emp.emp_no
               WHERE dept_emp.dept_no = '$dept_no'
               AND dept_emp.to_date = '9999-01-01' LIMIT $offset, $limit";
    $query = mysqli_query(dbconnect(), $select);
    $result = array();
    while ($fetch = mysqli_fetch_assoc($query)) {
        $result[] = $fetch;
    }
    return $result;
}

function getRecherche($emp_name, $dept_no){
    $select = "SELECT employees.* FROM employees 
               JOIN dept_emp on dept_emp.emp_no = employees.emp_no
               WHERE employees.first_name = '$emp_name' AND dept_emp.dept_no = '$dept_no' AND dept_emp.to_date = '9999-01-01'";
    $query = mysqli_query(dbconnect(), $select);
    $resultat = array();
    while ($fetch = mysqli_fetch_assoc($query)) {
        $resultat[]= $fetch;
    }
    return $resultat;
}

function getEmployeeCountByDept($dept_no) {
    $select = "SELECT COUNT(*) as count FROM dept_emp 
               WHERE dept_no = '$dept_no' AND to_date = '9999-01-01'";
    $query = mysqli_query(dbconnect(), $select);
    return mysqli_fetch_assoc($query)['count'];
}

function getJobStats() {
    $select = "SELECT titles.title, 
               COUNT(CASE WHEN employees.gender = 'M' THEN 1 END) as hommes,
               COUNT(CASE WHEN employees.gender = 'F' THEN 1 END) as femmes,
               AVG(salaries.salary) as salaire_moyen
               FROM titles
               JOIN employees ON titles.emp_no = employees.emp_no
               JOIN salaries ON titles.emp_no = salaries.emp_no
               WHERE titles.to_date = '9999-01-01' AND salaries.to_date = '9999-01-01'
               GROUP BY titles.title";
    $query = mysqli_query(dbconnect(), $select);
    $result = array();
    while ($fetch = mysqli_fetch_assoc($query)) {
        $result[] = $fetch;
    }
    return $result;
}

function getLongestJob($emp_no) {
    $select = "SELECT title, DATEDIFF(to_date, from_date) as days 
               FROM titles WHERE emp_no = '$emp_no' 
               ORDER BY days DESC LIMIT 1";
    $query = mysqli_query(dbconnect(), $select);
    return mysqli_fetch_assoc($query);
}

function getCurrentDepartment($emp_no) {
    $sql = "SELECT departments.dept_no, departments.dept_name, dept_emp.from_date 
            FROM dept_emp
            JOIN departments ON dept_emp.dept_no = departments.dept_no
            WHERE dept_emp.emp_no = '$emp_no'
            ORDER BY dept_emp.to_date DESC LIMIT 1";
    $result = mysqli_query(dbconnect(), $sql);
    return mysqli_fetch_assoc($result);
}

function changeDepartment($emp_no, $new_dept, $start_date) {
    $update_old = "UPDATE dept_emp SET to_date = DATE_SUB('$start_date', INTERVAL 1 DAY) 
                   WHERE emp_no = '$emp_no' AND to_date = '9999-01-01'";
    mysqli_query(dbconnect(), $update_old);
    
    $insert_new = "INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date)
                   VALUES ('$emp_no', '$new_dept', '$start_date', '9999-01-01')";
    return mysqli_query(dbconnect(), $insert_new);
}

function getCurrentManager($dept_no) {
    $sql = "SELECT employees.first_name, employees.last_name, dept_manager.from_date 
            FROM dept_manager
            JOIN employees ON dept_manager.emp_no = employees.emp_no
            WHERE dept_manager.dept_no = '$dept_no'
            AND dept_manager.to_date = '9999-01-01'";
    $result = mysqli_query(dbconnect(), $sql);
    return mysqli_fetch_assoc($result);
}

function changeManager($emp_no, $dept_no, $start_date) {
    $update = "UPDATE dept_manager 
               SET to_date = DATE_SUB('$start_date', INTERVAL 1 DAY)
               WHERE dept_no = '$dept_no' AND to_date = '9999-01-01'";
    mysqli_query(dbconnect(), $update);
    
    $insert = "INSERT INTO dept_manager (emp_no, dept_no, from_date, to_date)
               VALUES ('$emp_no', '$dept_no', '$start_date', '9999-01-01')";
    return mysqli_query(dbconnect(), $insert);
}

function isManager($emp_no) {
    $sql = "SELECT 1 FROM dept_manager 
            WHERE emp_no = '$emp_no' AND to_date = '9999-01-01'";
    $result = mysqli_query(dbconnect(), $sql);
    return mysqli_num_rows($result) > 0;
}
?>



<!-- SELECT employees.* FROM employees
JOIN dept_emp on dept_emp.emp_no = employees.emp_no
JOIN departments on departments.dept_no = dept_emp.dept_no
WHERE employees.first_name = 'Leon' AND dept_emp.dept_no = 'd001'; -->