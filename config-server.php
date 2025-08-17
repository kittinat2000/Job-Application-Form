<?php

// connect DB --------------------------------------
$host = "127.0.0.1";
$user = "root";
$pass = "MiraclePlanet888";
$dbname = "jaf_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
// connect DB --------------------------------------

?>
