<?php

include "connection.php";

    function paketTable() {
        global $conn;

        $sql = "CREATE TABLE IF NOT EXISTS paketLiburan(
            idPaket INT PRIMARY KEY AUTO_INCREMENT,
            nama VARCHAR(255),
            deskripsi TEXT,
            harga DOUBLE(10,2),
            path TEXT
        )";

        if ($conn->query($sql) === TRUE) {
            // echo "table created";
        } else {
            echo "tabel paket gagal dibuat :" . $conn->error();
        }
    }


    function jadwalTable() {
        global $conn;

        $sql = "CREATE TABLE IF NOT EXISTS jadwal(
            id_jadwal INT PRIMARY KEY AUTO_INCREMENT,
            idPaket INT,
            jadwal_awal DATE,
            jadwal_akhir DATE,
            CONSTRAINT fk_user FOREIGN KEY (idPaket) REFERENCES paketLiburan(idPaket)
        )";

        if ($conn->query($sql) === TRUE) {
            // echo "table created";
        } else {
            echo "tabel pesanan gagal dibuat :" . $conn->error();
        }

    }

    function pesertaTable() {
        global $conn;

        $sql = "CREATE TABLE IF NOT EXISTS peserta(
            id_peserta INT PRIMARY KEY AUTO_INCREMENT,
            nama VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            no_hp VARCHAR(13),
            id INT,
            id_jadwal INT,
            status enum('sukses', 'gagal', 'dibatalkan', '')
            CONSTRAINT fk_users FOREIGN KEY (id) REFERENCES users(id),
            CONSTRAINT fk_jadwal FOREIGN KEY (id_jadwal) REFERENCES jadwal(id_jadwal)
        )";

        if ($conn->query($sql) === TRUE) {
            // echo "table created";
        } else {
            echo "tabel pesanan gagal dibuat :" . $conn->error();
        }
    }

?>