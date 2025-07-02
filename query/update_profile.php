<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include '../db/connection.php';

if (isset($_POST['update'])) {
    $id = $_SESSION['id'];
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);

    // Validasi sederhana
    if ($nama === '' || $username === '') {
        header("Location: update_profile.php?error=empty");
        exit();
    }

    // Cek duplikasi username jika berbeda
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $stmt->bind_param("si", $username, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: update_profile.php?error=exists");
        exit();
    }

    // Update data
    $update = $conn->prepare("UPDATE users SET nama = ?, username = ? WHERE id = ?");
    $update->bind_param("ssi", $nama, $username, $id);

    if ($update->execute()) {
        $_SESSION["nama"] = $nama;
        $_SESSION["username"] = $username;
        header("Location: ../member/akun.php?status=success");
        exit();
    } else {
        header("Location: ../member/update_profile.php?error=failed");
        exit();
    }
}
?>