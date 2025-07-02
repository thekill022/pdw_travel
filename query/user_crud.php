<?php

include __DIR__ . "/../db/connection.php";

    // create user
    function createUser($nama, $username, $pw) {
        global $conn;

        $check = "SELECT * FROM users WHERE username = ?";
        $check = $conn->prepare($check);
        $check->bind_param('s', $username);
        $check->execute();
        $res = $check->get_result();

        // url create user dinamis
        $referer = $_SERVER['HTTP_REFERER'];
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $path = parse_url($referer, PHP_URL_PATH);
        $cleanUrl = $scheme . "://" . $host . $path;

        echo $cleanUrl;

        if ($res->num_rows > 0) {
            header("Location: " . $cleanUrl . "?error=exist");
            exit;
        } else {
            $sql = "INSERT INTO users(nama, username, password, role) VALUES(?,?,?,'Member')";
            $stmt = $conn->prepare($sql);
            $hashPw = password_hash($pw, PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $nama, $username, $hashPw);

            if ($stmt->execute()) {
                header("Location: " . $cleanUrl . "?userc=true");
                exit;
            } else {
                header("Location: " . $cleanUrl . "?userc=false");
                exit;
            }
        }
    }

    // read user
    function getAllUser() {
        global $conn;
        $sql = "SELECT id, nama, username FROM users WHERE role = 'Member'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;        
    }

    function reloadUser() {
        global $conn;
        $sql = "SELECT id, nama, username, status FROM users WHERE role = 'Member'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode(["data" => $data]);
    }

    function getUserWithUsername($username) {
        global $conn;
        $sqlUname = "SELECT id, nama, username, status FROM users WHERE username LIKE ? AND role = 'Member'";
        $sqlName = "SELECT id, nama, username, status FROM users WHERE nama LIKE ? AND role = 'Member'";

            $search = '%' . $username . '%';
            $stmt = $conn->prepare($sqlUname);
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result;
            } else {
                $stmt = $conn->prepare($sqlName);
                $stmt->bind_param("s", $search);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    return "No Data Found";
                }
            }
        
    }

    function editUser($id, $nama, $username, $password = "") {
        global $conn;
    
        if ($password == "") {
            $query = "UPDATE users SET nama = ?, username = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $nama, $username, $id);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET nama = ?, username = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $nama, $username, $hashedPassword, $id);
        }
    
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "User berhasil diperbarui."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal memperbarui user.",
                "error" => $stmt->error
            ]);
        }
    }    

    function deleteUser($id) {
        global $conn;
    
        $search = "SELECT status FROM users WHERE id= ?";
        $stmt = $conn->prepare($search);
    
        if (!$stmt) {
            echo json_encode([
                "status" => "error",
                "error" => "Prepare failed: " . $conn->error
            ]);
            return;
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentStatus = $row["status"];
            
            $newStatus = $currentStatus == 1 ? 0 : 1;
            $updateQuery = "UPDATE users SET status = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            
            if (!$updateStmt) {
                echo json_encode([
                    "status" => "error",
                    "error" => "Prepare failed: " . $conn->error
                ]);
                return;
            }
    
            $updateStmt->bind_param("ii", $newStatus, $id);
            if ($updateStmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Status user berhasil diperbarui ke $newStatus"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "error" => "Eksekusi gagal: " . $updateStmt->error
                ]);
            }
    
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "User tidak ditemukan"
            ]);
        }
    }        

    if (isset($_POST["register"])) {
        $nama =  $_POST["nama"];
        $user =  $_POST["username"];
        $pw =  $_POST["password"];

        createUser($nama, $user, $pw);
    }

    else if (isset($_POST["srcUname"])) {
        $user = $_POST["srcUname"];
        $data = getUserWithUsername($user);

        if (is_string($data)) {
            echo json_encode(["status" => 404, "data" => $data]);
            exit;
        } else {
            $res = [];
            while($row = $data->fetch_assoc()) {
                $res[] = $row;
            }
            echo json_encode(["status" => 200, "data" => $res]);
            exit;
        }
    }

    else if (isset($_POST["loadAll"]) && $_POST["loadAll"] == "true") {
        reloadUser();
    } 
    
    else if(isset($_POST["updateUsr"]) && $_POST["updateUsr"] == true) {

        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        editUser($id, $nama, $username, $password);
    }

    else if(isset($_POST["deleteUsr"]) && $_POST["deleteUsr"] == true) {
        $id = $_POST["id"];
        deleteUser($id);
    }

?>