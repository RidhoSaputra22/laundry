<?php

$conn = mysqli_connect("localhost", "root", "", "syntechm_laundry");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function convertToIndoPhoneFormat($phone)
{
    // Hilangkan spasi, strip, dan karakter non-digit
    $phone = preg_replace('/[^0-9]/', '', $phone);

    // Cek jika dimulai dengan "0"
    if (substr($phone, 0, 1) === '0') {
        return '62' . substr($phone, 1);
    }

    // Jika sudah dalam format internasional, biarkan
    return $phone;
}
