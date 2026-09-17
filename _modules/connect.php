<?php
    $conn = mysqli_connect("localhost","root","","appus_lite");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>