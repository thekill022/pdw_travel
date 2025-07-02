<?php

include '../db/connection.php';

    global $conn;
    if (isset($_POST["ubah"])) {

        $status = $_POST["status"];
        $id = $_POST["id"];

        $sql = 'UPDATE peserta SET status=? WHERE id_peserta=?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        
        if ($stmt->execute()) {
            header("Location: ../admin/berangkat.php");
            exit();
        } else {
            header("Location: ../admin/berangkat.php?status=gagal");
            exit();
        }

    }

?>