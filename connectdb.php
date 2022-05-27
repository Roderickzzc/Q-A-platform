<?php
$mysqli = new mysqli("localhost", "root", "1234", "pj2");
$link=mysqli_connect("localhost", "root", "1234", "pj2");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
