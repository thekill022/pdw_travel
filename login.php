<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-sm w-full">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
      <form id="loginForm" action="./query/auth.php" method="post">
        <div class="mb-4">
          <label for="username" class="block text-gray-700 font-semibold mb-2"
            >Username</label
          >
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Isikan Username Anda"
            required
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <div class="mb-2">
          <label for="password" class="block text-gray-700 font-semibold mb-2"
            >Password</label
          >
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Isikan Password Anda"
            required
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <div class="mb-5 text-red-500">
            <?php
              if (isset($_GET["auth"]) && $_GET["auth"] == "false") {
                echo 'Username Atau Password Salah';
              } else if (isset($_GET["account"]) && $_GET["account"] == "false") {
                echo "Akun Dinonaktifkan";
              }
            ?>
        </div>
        <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-300"
          name="login"
        >
          Login
        </button>
      </form>
      <p id="message" class="text-center mt-4 font-semibold text-sm"></p>
      <p class="text-sm text-center text-gray-600 mt-2">
        Belum punya akun?
        <a href="./register.php" class="text-blue-500 hover:underline">Daftar di sini</a>
      </p>
    </div>
  </body>
</html>
