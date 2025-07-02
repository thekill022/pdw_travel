<?php

include __DIR__ . "/../db/connection.php";

function createPaket($nama, $harga, $foto, $deskripsi) {

        global $conn;
        $sql = "INSERT INTO paketliburan(nama, harga, path, deskripsi) VALUES (?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $harga, $foto, $deskripsi);
        
        if (!$stmt->execute()) {
            echo "Gagal menambah data";
        }
}

function updatePaket($id, $nama, $harga, $deskripsi, $foto) {

    global $conn;

    if ($foto == "") {
        $sql = "UPDATE paketliburan SET nama = ?, harga= ?, deskripsi=? WHERE idpaket = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama, $harga, $deskripsi, $id);
    } else {
        $sql = "UPDATE paketliburan SET nama = ?, harga= ?, deskripsi=?, path=? WHERE idpaket=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $harga, $deskripsi, $foto, $id);
    }

    if ($stmt->execute()) {
        echo json_encode([
            "status" => 200,
            "message" => "User berhasil diperbarui."
        ]);
    }
    else {
        echo json_encode([
            "status" => 500,
            "message" => "Gagal memperbarui user.",
            "error" => $stmt->error
        ]);
    }

}


function deletePaket($id) {
    global $conn;
    $path = "";

    $find = "SELECT path FROM paketliburan WHERE idPaket = ?";

    $stmt = $conn->prepare($find);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $path = "../" . $row['path'];
    }

    $query = "DELETE FROM paketliburan WHERE idPaket = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "error" => "Prepare failed: " . $conn->error
        ]);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        unlink($path);
        echo json_encode([
            "status" => 200,
            "message" => "paket berhasil dihapus"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "error" => "Eksekusi gagal: " . $stmt->error
        ]);
    }
}   

if (isset($_POST["add"])) {
    $nama = $_POST["nama"];
    $harga = $_POST["harga"];
    $foto = $_POST["foto"];
    $deskripsi = $_POST["deskripsi"];

    $targetDir = "../assets/img/destination/";
    $fileName = basename($_FILES["foto"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    $allowedTypes = ['jpg', 'jpeg', 'png'];
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
            $fotoPath = "assets/img/destination/" . $fileName;
            createPaket($nama, $harga, $fotoPath, $deskripsi);

            header("Location: /tugas_pdw/admin/paket.php");
            exit();

        } else {
            header("Location: /tugas_pdw/admin/paket.php?fail=true");
            exit();
        }
    } else {
        header("Location: /tugas_pdw/admin/paket.php?type=false");
            exit();
    }

} else if (isset($_POST["edit"]) && $_POST["edit"] == true) {

    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $harga = $_POST["harga"];
    $deskripsi = $_POST["deskripsi"];
    $foto = "";

    if (isset($_FILES["foto"]) && $_FILES["foto"]["name"] !== "") {
        $targetDir = "../assets/img/destination/";
        $fileName = basename($_FILES["foto"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png'];
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
                $foto = "assets/img/destination/" . $fileName;
            } else {
                echo json_encode(["status" => 500, "message" => "Gagal upload file"]);
                exit();
            }
        } else {
            echo json_encode(["status" => 400, "message" => "Format gambar tidak didukung"]);
            exit();
        }
    }

    updatePaket($id, $nama, $harga, $deskripsi, $foto);
} 

else if(isset($_POST["delete"]) && $_POST["delete"] == true) {
    $id = $_POST["id"];

    deletePaket($id);
}

?>