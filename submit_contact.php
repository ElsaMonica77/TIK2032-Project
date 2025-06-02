<?php
session_start();
include 'db.php';  // Pastikan file ini berisi koneksi database yang benar

// Cek apakah form disubmit
if (isset($_POST['submit'])) {

    // Ambil data dari form dengan sanitasi sederhana
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validasi sederhana: cek apakah semua field sudah diisi
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['contact_message'] = "Semua field harus diisi!";
        $_SESSION['contact_success'] = false;
        header("Location: contact.php");
        exit;
    }

    // Validasi email sederhana
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_message'] = "Format email tidak valid!";
        $_SESSION['contact_success'] = false;
        header("Location: contact.php");
        exit;
    }

    // Siapkan query insert dengan prepared statement
    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $_SESSION['contact_message'] = "Terjadi kesalahan pada server: " . $conn->error;
        $_SESSION['contact_success'] = false;
        header("Location: contact.php");
        exit;
    }

    // Bind parameter (4 string)
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Eksekusi query dan cek hasilnya
    if ($stmt->execute()) {
        $_SESSION['contact_message'] = "Terima kasih atas pesan Anda!";
        $_SESSION['contact_success'] = true;
    } else {
        $_SESSION['contact_message'] = "Gagal mengirim pesan: " . $stmt->error;
        $_SESSION['contact_success'] = false;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();

    // Redirect kembali ke halaman kontak agar pesan tampil
    header("Location: contact.php");
    exit;

} else {
    // Jika akses langsung tanpa submit form, redirect ke kontak
    header("Location: contact.php");
    exit;
}
?>