<?php

    include '../db/connection.php';

    // function
    function getUserAuth($username, $password) {
        global $conn;
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                
                if ($row["status"] == 0) {
                    header("Location: /tugas_pdw/login.php?account=false");
                    exit;
                }

                session_start();
                $_SESSION["username"] = $row["username"];
                $_SESSION["nama"] = $row["nama"];
                $_SESSION["role"] = $row["role"];
                $_SESSION["id"] = $row["id"];

                if ($row["role"] == "Admin") {
                    header("Location: /tugas_pdw/admin/user.php");
                    exit;
                } else {
                    header("Location: /tugas_pdw/member/main.php");
                    exit;
                }

            }
    
        }

        header("Location: /tugas_pdw/login.php?auth=false");
        exit;
    }

    function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /tugas_pdw/login.php");
        exit;
    }

    // function execution
    if(isset($_POST["login"])) 
    {
        $user = $_POST["username"];
        $pw = $_POST["password"];
        getUserAuth($user, $pw);
    } else if(isset($_POST["logout"])) {
        logout();
    }
    
?>