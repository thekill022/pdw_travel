<?php

include __DIR__ . "/../db/connection.php";

function insertJadwal($idPaket, $jadwal_awal, $jadwal_akhir) {
    global $conn;

    $sql = "INSERT INTO jadwal (idPaket, jadwal_awal, jadwal_akhir) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        return;
    }

    $stmt->bind_param("iss", $idPaket, $jadwal_awal, $jadwal_akhir);

    if ($stmt->execute()) {
        header("Location: /tugas_pdw/admin/jadwal.php");
        exit();
    } else {
        header("Location: /tugas_pdw/admin/jadwal.php?fail=true");
        exit();
    }

    $stmt->close();
}

function deleteJadwal($id) {
    global $conn;

    $query = "DELETE FROM jadwal WHERE id_jadwal = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "error" => "Prepare failed: " . $conn->error
        ]);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => 200,
            "message" => "User berhasil dihapus"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "error" => "Eksekusi gagal: " . $stmt->error
        ]);
    }
}   

if (isset($_POST["add"])) {
    $id = $_POST["id"];
    $mulai = $_POST["mulai"];
    $selesai = $_POST["selesai"];

    insertJadwal($id, $mulai, $selesai);
}
else if (isset($_POST["delete"]) && $_POST["delete"] == true) {
    $id = $_POST["id"];

    deleteJadwal($id);
}

?>