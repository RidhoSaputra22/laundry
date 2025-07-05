<?php
session_start();
include '../config/conn.php';

if ($_SESSION) {
    if ($_SESSION['role'] == 'owner') {
    } else {
        header("location:../login.php");
    }
} else {
    header('location:../login.php');
}

$conn = $conn;

if (mysqli_connect_error()) {
    echo "Koneksi ke database gagal : " . mysqli_connect_error();
}
