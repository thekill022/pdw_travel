<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include '../db/connection.php';

$id = $_SESSION["id"];

// Ambil data user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="min-h-screen flex items-center justify-center px-4">
  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md border border-blue-100">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">✏️ Edit Profil</h2>

    <form action="../query/update_profile.php" method="POST" class="space-y-5">
      <div>
        <label for="nama" class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($user['nama']) ?>" required
               class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="username" class="block text-gray-700">Username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required
               class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div class="flex justify-between items-center pt-4 border-t">
        <a href="akun.php" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        <button type="submit" name="update"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
