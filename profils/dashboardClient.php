<?php
require_once '../classes/categorie.php';
require_once '../classes/vehicle.php';
require_once '../classes/reserve.php';

$vehicule = new Vehicule();
$categorie = new Categorie();
$reservation = new reservation();

session_start();
if ($_SESSION['role_id'] == 2) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Client Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      .bg-gradient-primary {
        background: linear-gradient(135deg, rgb(37, 99, 235), rgb(37, 143, 235));
      }

      .hover\:bg-gradient-primary:hover {
        background: linear-gradient(135deg, rgb(37, 143, 235), rgb(37, 99, 235));
      }

      .shadow-soft {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      .transition-all {
        transition: all 0.3s ease;
      }

      .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
      }

      .modal.active {
        display: flex;
      }
    </style>
  </head>

  <body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-gradient-primary shadow-lg">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16 items-center">
          <div class="flex items-center">
            <span class="text-2xl font-bold text-white">D&L</span>
          </div>
          <div class="flex items-center space-x-4">
            <a href="../index.php" class="px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition duration-300">Home</a>
            <a href="../profils/client.php" class="px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition duration-300">My Profile</a>
            <a href="../profils/log out.php" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all">Logout</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-24 bg-gradient-primary text-white">
      <div class="mx-auto p-4 py-20">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div class="text-center md:text-left">
            <span class="text-2xl font-bold"></span>

            <h4 class="text-2xl font-bold"><?php echo $_SESSION['nom'] . " " .  $_SESSION['prenom'] ?>'s Space</h4>
            <h4 class="text-9xl font-bold">Dashboard</h4>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6">
      <button onclick="openModal('addVehicleModal')" class="bg-gradient-primary text-white px-4 py-2 rounded-lg hover:bg-gradient-primary transition-all flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Article
      </button>
      <!-- Articals -->
      <!-- Blog Posts -->
      <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Blog Post 1 -->
          <div class="bg-white rounded-lg shadow-soft overflow-hidden transition-all hover:shadow-lg">
            <img src="https://via.placeholder.com/400x200" alt="Blog Post 1" class="w-full h-48 object-cover">
            <div class="p-6">
              <span class="text-sm text-blue-600 font-medium">Conseils</span>
              <h3 class="text-xl font-bold text-gray-900 mt-2">10 Conseils pour Entretenir Votre Voiture</h3>
              <p class="text-gray-600 mt-2">Découvrez comment garder votre voiture en parfait état avec ces conseils pratiques.</p>
              <div class="mt-4 flex items-center">
                <img src="https://via.placeholder.com/40" alt="Author" class="w-10 h-10 rounded-full">
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">Jean Dupont</p>
                  <p class="text-sm text-gray-600">15 Janvier 2024</p>
                </div>
              </div>
              <a href="../pages/article.php" class="mt-4 inline-block text-blue-600 hover:text-blue-800 transition-all">Lire la suite →</a>
            </div>
          </div>

          <!-- Blog Post 2 -->
          <div class="bg-white rounded-lg shadow-soft overflow-hidden transition-all hover:shadow-lg">
            <img src="https://via.placeholder.com/400x200" alt="Blog Post 2" class="w-full h-48 object-cover">
            <div class="p-6">
              <span class="text-sm text-blue-600 font-medium">Actualités</span>
              <h3 class="text-xl font-bold text-gray-900 mt-2">Les Tendances Automobiles en 2024</h3>
              <p class="text-gray-600 mt-2">Explorez les dernières tendances et innovations dans l'industrie automobile.</p>
              <div class="mt-4 flex items-center">
                <img src="https://via.placeholder.com/40" alt="Author" class="w-10 h-10 rounded-full">
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">Marie Curie</p>
                  <p class="text-sm text-gray-600">10 Janvier 2024</p>
                </div>
              </div>
              <a href="../pages/article.php" class="mt-4 inline-block text-blue-600 hover:text-blue-800 transition-all">Lire la suite →</a>
            </div>
          </div>

          <!-- Blog Post 3 -->
          <div class="bg-white rounded-lg shadow-soft overflow-hidden transition-all hover:shadow-lg">
            <img src="https://via.placeholder.com/400x200" alt="Blog Post 3" class="w-full h-48 object-cover">
            <div class="p-6">
              <span class="text-sm text-blue-600 font-medium">Technologie</span>
              <h3 class="text-xl font-bold text-gray-900 mt-2">Les Voitures Électriques : Le Futur de l'Automobile</h3>
              <p class="text-gray-600 mt-2">Découvrez pourquoi les voitures électriques sont l'avenir de l'industrie automobile.</p>
              <div class="mt-4 flex items-center">
                <img src="https://via.placeholder.com/40" alt="Author" class="w-10 h-10 rounded-full">
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900">Pierre Martin</p>
                  <p class="text-sm text-gray-600">5 Janvier 2024</p>
                </div>
              </div>
              <a href="../pages/article.php" class="mt-4 inline-block text-blue-600 hover:text-blue-800 transition-all">Lire la suite →</a>
            </div>
          </div>
        </div>
      </div>


      <!-- Add Article Modal -->
      <div id="addVehicleModal" class="modal">
        <div class="bg-white rounded-lg w-1/2 mx-auto my-auto p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Add New Vehicle</h3>
            <button onclick="closeModal('addVehicleModal')" class="text-gray-500 hover:text-gray-700">×</button>
          </div>
          <form class="space-y-4" method="post" enctype="multipart/form-data">
            <div class="grid grid-cols-1 gap-4">
              <!-- Article Title -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Article Title</label>
                <input type="text" name="title" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" placeholder="Enter Article Title" required>
              </div>
              <!-- Article Description -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" placeholder="Write a description..." required></textarea>
              </div>
              <!-- Article Image -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
                <input type="file" name="image" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" required>
              </div>
              <label class="block text-sm font-medium mb-1">Theme</label>
              <select class="w-full border rounded-lg p-2" name="Category">
                <?php
                $arr = $categorie->showCategorie();
                foreach ($arr as $row) {
                  echo "<option value='" . $row['Categorie_id'] . "'>" . $row['nom'] . "</option>";
                }
                ?>
              </select>
            </div>
            <!-- Theme Selection -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Select Theme</label>
              <select name="theme_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" required>
                <option value="" disabled selected>Select a theme</option>
                <?php foreach ($themes as $theme): ?>
                  <option value="<?= htmlspecialchars($theme['themeID']) ?>">
                    <?= htmlspecialchars($theme['theme_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- Tags Section -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Select Tags</label>
              <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <?php foreach ($tags as $tag): ?>
                  <div>
                    <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag['tagID']) ?>" id="tag_<?= htmlspecialchars($tag['tagID']) ?>">
                    <label for="tag_<?= htmlspecialchars($tag['tagID']) ?>" class="text-sm text-gray-700">
                      <?= htmlspecialchars($tag['tag_name']) ?>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
        </div>
        <div class="flex justify-end space-x-4">
          <button type="button" onclick="closeModal('addVehicleModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
          <button type="submit" name="Vehicle_submit" class="px-4 py-2 bg-gradient-primary text-white rounded-lg hover:bg-gradient-primary transition-all">Add Vehicle</button>
        </div>
        </form>
      </div>
    </div>




    <script>
      function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
      }

      function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
      }
    </script>
  </body>

  </html>
<?php
} else if ($_SESSION['role_id'] == 2) {
  header('location:../index.php');
  exit();
} else {
  header('location:../autentification/signUp.php');
  exit();
}
?>