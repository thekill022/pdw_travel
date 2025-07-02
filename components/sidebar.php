<?php function sidebar($member = "#", $paket= "#", $jadwal = "#", $keberangkatan= "#" ) { ?>

<aside id="sidebar-multi-level-sidebar"
    class="fixed z-40 md:z-30 top-16 md:top-0 left-0 h-full min-h-screen w-64 transition-transform -translate-x-full md:translate-x-0 md:relative bg-white dark:bg-gray-800 shadow-lg overflow-y-auto"
    aria-label="Sidebar">
    <ul class="py-4 space-y-2 font-medium">

      <!-- Manajemen Data -->
      <li class="px-4">
        <button type="button"
          class="flex items-center w-full p-2 text-base text-gray-900 transition duration-300 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
          aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
            <path
              d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
            <path
              d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
          </svg>
          <span class="flex-1 ms-3 text-left whitespace-nowrap">Manajemen Data</span>
          <svg class="w-3 h-3" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 1 4 4 4-4" />
          </svg>
        </button>
        <ul id="dropdown-example" class="hidden py-2 space-y-2">
          <li><a href="<?php echo $member; ?>" class="<?php if ($member == "#") {
            echo "block p-2 pl-11 text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-700";
          } else {
            echo "block p-2 pl-11 hover:bg-gray-100 dark:hover:bg-gray-700";
          }  ?>">Manajemen Member</a></li>
          <li><a href="<?php echo $paket; ?>" class="<?php if ($paket == "#") {
            echo "block p-2 pl-11 text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-700";
          } else {
            echo "block p-2 pl-11 hover:bg-gray-100 dark:hover:bg-gray-700";
          }  ?>">Manajemen Paket Liburan</a></li>
        </ul>
      </li>

      <!-- Manajemen Booking -->
      <li class="px-4">
        <button type="button"
          class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
          aria-controls="dropdown-booking" data-collapse-toggle="dropdown-booking">
          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
            <path
              d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
          </svg>
          <span class="flex-1 ms-3 text-left whitespace-nowrap">Manajemen Booking</span>
          <svg class="w-3 h-3" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 1 4 4 4-4" />
          </svg>
        </button>
        <ul id="dropdown-booking" class="hidden py-2 space-y-2">
        <li><a href="<?php echo $jadwal; ?>" class="<?php if ($jadwal == "#") {
            echo "block p-2 pl-11 text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-700";
          } else {
            echo "block p-2 pl-11 hover:bg-gray-100 dark:hover:bg-gray-700";
          }  ?>">Jadwal Keberangkatan</a></li>
          <li><a href="<?php echo $keberangkatan; ?>" class="<?php if ($keberangkatan == "#") {
            echo "block p-2 pl-11 text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-700";
          } else {
            echo "block p-2 pl-11 hover:bg-gray-100 dark:hover:bg-gray-700";
          }  ?>">List Keberangkatan</a></li>
        </ul>
      </li>

    </ul>
  </aside>

  <?php } ?>