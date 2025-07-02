<nav class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
  <div class="max-w-screen-xl mx-auto px-4 py-3 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="../assets/icons/Praktis Tanpa Repot.png" class="h-8" alt="PDW Logo">
      <span class="text-2xl font-bold text-blue-700">PDW Travel</span>
    </div>

    <!-- User Info and Logout -->
    <div class="flex items-center space-x-4">
      <!-- Avatar + Name + Role -->
      <div class="flex items-center space-x-3">
        <div class="text-right">
          <p class="text-sm font-semibold text-gray-900"><?php echo $_SESSION["nama"] ?></p>
          <p class="text-xs text-blue-700 font-medium"><?php echo ucfirst($_SESSION["role"]) ?></p>
        </div>
        <img class="w-10 h-10 rounded-full border border-blue-700" src="../assets/icons/User.jpeg" alt="User Photo">
      </div>

      <!-- Logout Button -->
      <form action="../query/auth.php" method="post">
        <button name="logout" type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md hover:bg-blue-800 transition">
          Logout
        </button>
      </form>
    </div>
  </div>
</nav>
