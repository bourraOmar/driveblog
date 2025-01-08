<?php
session_start();
if ($_SESSION['role_id'] == 2) {
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drive & Loc - Blog</title>
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
                        <a href="pages/menu.php" class="text-white hover:text-gray-200 transition-all">Collection</a>
                        <a href="blog.php" class="text-white hover:text-gray-200 transition-all">Blog</a>
                        <div>
                            <a href="../profils/client.php"><img width="25px" class="bg-white rounded-full shadow-soft" src="../img/profile-major.svg" alt="Profile"></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Blog Header -->
        <header class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Blog</h1>
                <p class="text-lg text-gray-600">Découvrez les dernières actualités et conseils sur l'automobile.</p>
            </div>
        </header>

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
<?php
} else {
    header('location:../index.php');
    exit();
}
?>