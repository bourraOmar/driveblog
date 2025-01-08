<?php
require_once __DIR__ . '/../DriveBlog/classes/vehicle.php';

$vehicule = new Vehicule();

session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Location de voitures</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: rgb(37, 99, 235);
            --secondary: #FFFFFF;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary), rgb(37, 143, 235));
        }

        .hover\:bg-gradient-primary:hover {
            background: linear-gradient(135deg, rgb(37, 143, 235), var(--primary));
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
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-white">D&L</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-white hover:text-gray-200 transition-all">Accueil</a>
                    <a href="pages/menu.php" class="text-white hover:text-gray-200 transition-all">Collection</a>
                    <a href="pages/blog.php" class="text-white hover:text-gray-200 transition-all">Blog</a>
                    <button class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition-all">
                        Réserver maintenant
                    </button>
                    <?php if (isset($_SESSION["role_id"])) { ?>
                        <div>
                            <a href="../DriveBlog/profils/client.php"><img width="25px" class="bg-white rounded-full shadow-soft" src="../DriveBlog/img/profile-major.svg" alt="Profile"></a>
                        </div>
                    <?php } else { ?>
                        <div class="hidden md:flex items-center space-x-3">
                            <a href="../DriveBlog/authentification/login.php" class="text-white hover:bg-blue-700 bg-blue-600 font-medium rounded-lg text-sm px-4 py-2 transition-all">Log In</a>
                            <a href="../DriveBlog/authentification/signUp.php" class="text-blue-600 bg-white hover:text-blue-700 font-medium rounded-lg text-sm px-4 py-2 transition-all">Sign Up</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl font-bold text-gray-900">
                        Vivez l'Exception Automobile
                    </h1>
                    <p class="text-xl text-gray-600">
                        Des véhicules d'exception sélectionnés pour leur performance, leur élégance et leur caractère unique. Découvrez notre collection exclusive et réservez votre prochaine expérience de conduite.
                    </p>
                    <div class="flex gap-4">
                        <button class="bg-gradient-primary text-white px-8 py-3 rounded-lg hover:bg-gradient-primary transition-all text-lg">
                            <a href="../DriveBlog/pages/menu.php">Voir la collection</a>
                        </button>
                        <button class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-50 transition-all text-lg">
                            En savoir plus
                        </button>
                    </div>
                    <div class="pt-8 flex gap-12">
                        <div>
                            <div class="text-3xl font-bold text-gray-900">20+</div>
                            <div class="text-gray-600">Véhicules de luxe</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900">24/7</div>
                            <div class="text-gray-600">Support client</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900">100%</div>
                            <div class="text-gray-600">Satisfaction client</div>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <img src="img/car5.jpg" alt="Voiture de luxe" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Collection -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Notre Collection</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Vehicle Card 1 -->
                <?php
                $rows = $vehicule->showTop3Vehicule();
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
                                <button type="submit" class="bg-gradient-primary text-white px-4 py-2 rounded hover:bg-gradient-primary transition-all">
                                    <?php if (isset($_SESSION['role_id'])) { ?>
                                        <a href="../pages/reservation.php?vehiculeId=<?php echo $row['vehicule_id'] ?>&clientId=<?php echo $_SESSION['user_id'] ?>">Réserver</a>
                                    <?php } else { ?>
                                        <a href="../DriveBlog/authentification/login.php">Voir plus</a>
                                    <?php } ?>
                ²                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="flex justify-center m-4">
            <button class="bg-gradient-primary text-white px-4 py-2 rounded hover:bg-gradient-primary transition-all">
                <?php if (isset($_SESSION['role_id'])) { ?>
                    <a href="../DriveBlog/pages/menu.php">Voir plus</a>
                <?php } else { ?>
                    <a href="../DriveBlog/authentification/login.php">Voir plus</a>
                <?php } ?>
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <span class="text-2xl font-bold text-blue-400">D&L</span>
                    <p class="mt-2 text-gray-400">L'excellence automobile à votre service.</p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Accueil</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Collection</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Services</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>+33 1 23 45 67 89</li>
                        <li>contact@driveBlog.fr</li>
                        <li>75008 Paris, France</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                &copy; 2024 Drive & Loc. Tous droits réservés.
            </div>
        </div>
    </footer>
</body>

</html>