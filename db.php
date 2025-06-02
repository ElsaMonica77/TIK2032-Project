<?php
// Konfigurasi koneksi database
$host = "localhost";    // Biasanya localhost atau 127.0.0.1
$user = "root";         // Sesuaikan dengan username database kamu
$pass = "";             // Sesuaikan dengan password database kamu, kosong jika tidak ada
$db   = "portfolio_db"; // Nama database yang sudah kamu buat

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>