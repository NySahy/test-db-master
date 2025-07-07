<?php
function dbconnect() {
    static $link = null;
    if ($link === null) {
        $link = mysqli_connect('localhost', 'root', '', 'employees');
        if (!$link) {
            die('Erreur de connexion : ' . mysqli_connect_error());
        }
        mysqli_set_charset($link, "utf8mb4");
    }
    return $link;
}
?>