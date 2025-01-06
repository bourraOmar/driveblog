<?php
require_once '../classes/categorie.php';
require_once '../classes/vehicle.php';

$vehicule = new Vehicule();
$categorie = new Categorie();

session_start();
if ($_SESSION['role_id'] == 2) {
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drive & Loc - Notre Collection</title>
        <script src="https://cdn.tailwindcss.com"></script>
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
        </style>
    </head>

    <body class="bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-gradient-primary shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-white">D&L</span>
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="../index.php" class="text-white hover:text-gray-200 transition-all">Accueil</a>
                        <a href="#" class="text-white hover:text-gray-200 transition-all">Collection</a>
                        <a href="#" class="text-white hover:text-gray-200 transition-all">Services</a>
                        <div>
                            <a href="../profils/client.php"><img width="25px" class="bg-white rounded-full shadow-soft" src="../img/profile-major.svg" alt="Profile"></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Header -->
        <header class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Notre Collection</h1>
                <p class="text-lg text-gray-600">Découvrez notre sélection de véhicules de prestige</p>
            </div>
        </header>

        <!-- Filters -->
        <div class="bg-white py-6 mb-8 shadow-sm">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="categoryFilter">
                        <option value="all">Toutes les catégories</option>
                        <?php
                        $arr = $categorie->showCategorie();
                        foreach ($arr as $row) {
                            echo "<option value='" . $row['Categorie_id'] . "'>" . $row['nom'] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="search" name="searchByName" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="searchByName">
                </div>
            </div>
        </div>

        <!-- Vehicle Grid -->
        <div class="max-w-7xl mx-auto px-4 mb-12">
            <div id="container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Vehicles Card  -->
                <?php
                $rows = $vehicule->showAllVehicule();
                foreach ($rows as $row) {
                ?>
                    <div class="bg-white rounded-lg shadow-soft overflow-hidden transition-all hover:shadow-lg">
                        <img src="<?php echo $row['vehicule_image'] ?>" alt="Ferrari SF90" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <span class="text-sm text-blue-600 font-medium"><?php echo $row['nom'] ?></span>
                            <h3 class="text-xl font-bold text-gray-900 mt-1"><?php echo $row['modele'] . " " . $row['marque'] ?></h3>
                            <p class="text-gray-600">1000 CV - Hybride</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-900"><?php echo $row['prix'] . "$" ?><span class="text-sm text-gray-600">/jour</span></span>
                                <a href="../pages/reservation.php?vehiculeId=<?php echo $row['vehicule_id'] ?>&clientId=<?php echo $_SESSION['user_id'] ?>" class="bg-gradient-primary text-white px-4 py-2 rounded-lg hover:bg-gradient-primary transition-all">Réserver</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t">
            <div class="max-w-7xl mx-auto px-4 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">D&L</h3>
                        <p class="text-gray-600">L'excellence automobile à votre service.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Contact</h3>
                        <p class="text-gray-600">+33 1 23 45 67 89</p>
                        <p class="text-gray-600">contact@drive-loc.fr</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Adresse</h3>
                        <p class="text-gray-600">75008 Paris, France</p>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t text-center text-gray-600">
                    <p>&copy; 2024 Drive & Loc. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </body>
    <script src="../scripte/scripte.js"></script>

    </html>
<?php
} else {
    header('location:../index.php');
    exit();
}
?>