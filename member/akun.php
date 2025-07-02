<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include '../db/connection.php';

$id = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Akun Saya</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="min-h-screen flex items-center justify-center px-4">
  <div class="bg-white shadow-lg rounded-xl w-full max-w-3xl p-8 border border-blue-100">
    
    <div class="flex items-center justify-between border-b pb-4 mb-6">
      <h2 class="text-2xl font-bold text-blue-600">👤 Akun Saya</h2>
      <a href="update_profile.php" class="text-sm bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-150">
        ✏️ Edit Profil
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Profile Left -->
      <div class="flex flex-col items-center">
        <img src="../assets/icons/User.jpeg" alt="Foto Profil" class="w-24 h-24 rounded-full shadow mb-4">
        <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($user['nama']) ?></h3>
        <p class="text-gray-500">@<?= htmlspecialchars($user['username']) ?></p>
      </div>

      <!-- Profile Info -->
      <div class="space-y-4">
        <div>
          <p class="text-gray-600 text-sm">Nama Lengkap</p>
          <p class="text-lg font-medium text-gray-800"><?= htmlspecialchars($user['nama']) ?></p>
        </div>
        <div>
          <p class="text-gray-600 text-sm">Username</p>
          <p class="text-lg font-medium text-gray-800"><?= htmlspecialchars($user['username']) ?></p>
        </div>
        <!-- Tambahkan info lainnya jika ada -->
      </div>
    </div>

    <div class="mt-8 border-t pt-4 text-sm text-gray-500 flex justify-between">
      <a href="main.php" class="hover:text-blue-600">← Kembali ke Dashboard</a>
      <form method="post" action="../query/auth.php">
        <button name="logout" class="text-red-600 hover:text-red-800 font-semibold">Logout</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
