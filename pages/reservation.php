<?php
session_start();
require_once '../classes/vehicle.php';

$vehicule = new Vehicule();

// Handle success and error messages
if (isset($_SESSION['success'])) {
  $message = $_SESSION['success'];
  $alertType = 'success';
  unset($_SESSION['success']);
} elseif (isset($_SESSION['date_invalide'])) {
  $message = $_SESSION['date_invalide'];
  $alertType = 'error';
  unset($_SESSION['date_invalide']);
} else {
  $message = '';
  $alertType = '';
}

// Redirect unauthorized users
if ($_SESSION['role_id'] != 2) {
  header('location: ../autentification/signup.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drive & Loc - Car Reservation</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary: rgb(37, 99, 235);
      --secondary: #FFFFFF;
    }

    .bg-primary {
      background-color: var(--primary);
    }

    .btn-primary {
      background-color: var(--primary);
    }

    .btn-primary:hover {
      background: rgb(37, 143, 235);
    }

    .floating-btn {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      z-index: 50;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="bg-gray-50">

  <!-- Success/Error Message -->
  <?php if ($message != '') { ?>
    <div class="fixed top-0 left-1/2 transform -translate-x-1/2 z-50 w-80 mt-4 px-4 py-3 rounded-lg text-center 
          <?php echo $alertType == 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'; ?>"
      x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200" x-init="setTimeout(() => show = false, 5000)">
      <span><?php echo htmlspecialchars($message); ?></span>
      <button @click="show = false" class="absolute top-1 right-1 text-xl font-bold">&times;</button>
    </div>
  <?php } ?>

  <!-- Navigation Bar -->
  <nav class="bg-gradient-to-r from-blue-800 to-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <span class="text-2xl font-bold text-white">Drive & Loc</span>
        </div>
        <div class="hidden md:flex items-center space-x-8">
          <a href="../index.php" class="text-white hover:text-gray-200 transition duration-300">Accueil</a>
          <a href="#" class="text-white hover:text-gray-200 transition duration-300">Collection</a>
          <a href="#" class="text-white hover:text-gray-200 transition duration-300">Services</a>
          <div>
            <a href="../profils/client.php"><img width="25px" class="bg-white rounded-full" src="../img/profile-major.svg" alt="Profile"></a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 py-8">
    <!-- Car Details Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition duration-300 hover:shadow-xl">
      <div class="md:flex">
        <?php
        $_SESSION['vehicule_id'] = $_GET['vehiculeId'];
        if (isset($_SESSION['vehicule_id']) || isset($_GET['vehiculeId'])) {
          $rows = $vehicule->showSpiceficAllVehicule($_SESSION['vehicule_id']);
          foreach ($rows as $row) {
        ?>
            <!-- Car Image -->
            <div class="md:w-1/2">
              <img src="<?php echo htmlspecialchars($row['vehicule_image']); ?>" alt="Car Image" class="w-full h-96 object-cover">
            </div>

            <!-- Car Information -->
            <div class="md:w-1/2 p-6">
              <div class="flex justify-between items-start mb-4">
                <div>
                  <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    <?php echo htmlspecialchars($row['status']); ?>
                  </span>
                  <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                    <?php echo htmlspecialchars($row['nom']); ?>
                  </span>
                </div>
                <span class="bg-gradient-to-r from-blue-600 to-blue-400 px-4 py-2 rounded-full text-lg text-white font-semibold">$<?php echo htmlspecialchars($row['prix']); ?>/day</span>
              </div>

              <!-- Availability Status -->
              <div class="mb-6">
                <div>
                  <h1 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($row['marque']); ?></h1>
                  <p class="text-gray-600 text-xl mt-2"><?php echo htmlspecialchars($row['modele']); ?></p>
                </div>
              </div>

              <!-- Reservation Form -->
              <form class="space-y-4" method="post" action="../classes/user.php?vehicule_Id=<?php echo $_SESSION['vehicule_id']; ?>&clientId=<?php echo $_SESSION['user_id']; ?>">
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium mb-1">Pick-up Date</label>
                    <input type="date" class="w-full border rounded-lg p-2" name="date_debut" required>
                  </div>
                  <div>
                    <label class="block text-sm font-medium mb-1">Return Date</label>
                    <input type="date" class="w-full border rounded-lg p-2" name="date_fin" required>
                  </div>
                </div>
                <input name="reservation_submit" type="submit" class="cursor-pointer text-white bg-gradient-to-r from-blue-600 to-blue-400 w-full py-3 rounded-lg text-lg font-semibold mt-6 hover:from-blue-700 hover:to-blue-500 transition duration-300" value="Reserve Now">
              </form>
            </div>
        <?php
          }
        }
        ?>
      </div>
    </div>

    <!-- Comments Section -->
    <div class="mt-12">
      <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>

      <!-- Add Comment Form -->
      <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Add Your Review</h3>
        <form class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1">Your Review</label>
            <textarea class="w-full border rounded-lg p-2" rows="4" required></textarea>
          </div>
          <button class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-blue-500 transition duration-300">Submit Review</button>
        </form>
      </div>

      <!-- Existing Comments -->
      <div class="space-y-6">
        <!-- Comment 1 -->
        <div class="bg-white rounded-lg shadow-lg p-6">
          <div class="flex justify-between items-start mb-4">
            <div>
              <h4 class="font-semibold">John Doe</h4>
            </div>
            <span class="text-gray-500">2 days ago</span>
          </div>
          <p class="text-gray-700">Great car! Very comfortable and fuel-efficient. The GPS was particularly helpful during my trip.</p>
        </div>

        <!-- Comment 2 -->
        <div class="bg-white rounded-lg shadow-lg p-6">
          <div class="flex justify-between items-start mb-4">
            <div>
              <h4 class="font-semibold">Jane Smith</h4>
            </div>
            <span class="text-gray-500">1 week ago</span>
          </div>
          <p class="text-gray-700">Clean and well-maintained vehicle. The pickup process was smooth and the staff was friendly.</p>
        </div>
      </div>
    </div>
  </main>

  <!-- Floating Action Button -->
  <button class="floating-btn bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-3 rounded-full shadow-lg hover:from-blue-700 hover:to-blue-500 transition duration-300">
    <i class="fas fa-calendar-check"></i>
  </button>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
    </div>
  </footer>

  <script src="../scripts/script.js"></script>
</body>

</html>