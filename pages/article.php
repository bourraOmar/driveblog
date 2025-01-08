<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - 10 Conseils pour Entretenir Votre Voiture</title>
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
                    <a href="blog.php" class="text-white hover:text-gray-200 transition-all">Blog</a>
                    <div>
                        <a href="../profils/client.php"><img width="25px" class="bg-white rounded-full shadow-soft" src="../img/profile-major.svg" alt="Profile"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Article Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-soft overflow-hidden">
            <!-- Article Image -->
            <img src="https://via.placeholder.com/800x400" alt="10 Conseils pour Entretenir Votre Voiture" class="w-full h-96 object-cover">

            <!-- Article Details -->
            <div class="p-6">
                <span class="text-sm text-blue-600 font-medium">Conseils</span>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">10 Conseils pour Entretenir Votre Voiture</h1>
                <div class="mt-4 flex items-center">
                    <img src="https://via.placeholder.com/40" alt="Author" class="w-10 h-10 rounded-full">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Jean Dupont</p>
                        <p class="text-sm text-gray-600">15 Janvier 2024</p>
                    </div>
                </div>
                <div class="mt-6 prose max-w-none">
                    <p class="text-gray-700">
                        Découvrez comment garder votre voiture en parfait état avec ces conseils pratiques. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p class="text-gray-700 mt-4">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>
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

</html>