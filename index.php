<?php
session_start();

if ($_SESSION['role_id'] == 2) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drive & Loc - Car Rental</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #2563eb;
                /* Blue */
                --secondary: #1e40af;
                /* Darker Blue */
                --accent: #FFD700;
                /* Gold */
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
            }

            .hover\:bg-gradient-primary:hover {
                background: linear-gradient(135deg, var(--secondary), var(--primary));
            }

            .shadow-soft {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .transition-all {
                transition: all 0.3s ease;
            }

            .btn-primary {
                background-color: var(--primary);
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                background-color: var(--secondary);
            }

            .card-animation {
                transition: transform 0.3s ease;
            }

            .card-animation:hover {
                transform: translateY(-5px);
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <!-- Navigation Bar -->
        <nav class="bg-gradient-primary shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-white">D&L</span>
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="../index.php" class="text-white hover:text-gray-200 transition-all">Accueil</a>
                        <a href="../Drive-loc2.0/pages/vehicles.php" class="text-white hover:text-gray-200 transition-all">Collection</a>
                        <a href="../Drive-loc2.0/blog/blog_index.php" class="text-white hover:text-gray-200 transition-all">Blog</a>
                        <button class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition-all">
                            Réserver maintenant
                        </button>
                        <?php if (isset($_SESSION["role_id"])) { ?>
                            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                                <button type="button" class="flex text-sm rounded-full md:me-0" id="user-menu-button" aria-expanded="false">
                                    <span class="sr-only">Open user menu</span>
                                    <img width="40px" src="imgs/profilephoto.png" alt="user photo">
                                </button>
                                <!-- Dropdown menu -->
                                <div class="z-50 hidden absolute top-10 right-40 z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow" id="user-dropdown">
                                    <div class="px-4 py-3">
                                        <span class="block text-sm text-gray-900"><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom'] ?></span>
                                        <span class="block text-sm text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="../pages/reservation_hestorie.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Reservations</a>
                                        </li>
                                        <li>
                                            <a href="../blog/create_article.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Article</a>
                                        </li>
                                        <li>
                                            <a href="../classes/user.php?signout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                                        </li>
                                    </ul>
                                </div>
                                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-user" aria-expanded="false">
                                    <span class="sr-only">Open main menu</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                                    </svg>
                                </button>
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
        <section class="hero-section py-20">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-6">Discover Our Vehicle Fleet</h1>
                <p class="text-xl mb-8">Quick and easy rentals for all your travels</p>
                <a href="#vehicles" class="inline-block bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                    View Our Vehicles
                </a>
            </div>
        </section>

        <!-- Vehicles Section -->
        <section class="py-16 bg-white" id="vehicles">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Available Vehicles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="rounded-lg shadow-lg overflow-hidden card-hover bg-white">
                        <img src="../Drive-Loc/img/car7.jpg" alt="City Car" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-xl mb-2">Comfort City Car</h3>
                            <p class="text-gray-600 mb-4">Perfect for city driving</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">$45/day</span>
                                <button class="btn-primary px-6 py-2 rounded-lg">Book Now</button>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg shadow-lg overflow-hidden card-hover bg-white">
                        <img src="../Drive-Loc/img/car6.jpg" alt="SUV" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-xl mb-2">Family SUV</h3>
                            <p class="text-gray-600 mb-4">Ideal for travel</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">$75/day</span>
                                <button class="btn-primary px-6 py-2 rounded-lg">Book Now</button>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg shadow-lg overflow-hidden card-hover bg-white">
                        <img src="../Drive-Loc/img/car5.jpg" alt="Premium" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-xl mb-2">Premium Sedan</h3>
                            <p class="text-gray-600 mb-4">Luxury within reach</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">$95/day</span>
                                <button class="btn-primary px-6 py-2 rounded-lg">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Footer -->
        <footer class="footer py-8">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
                <div class="mt-4 flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white">Terms of Service</a>
                </div>
            </div>
        </footer>

        <script src="../Drive-Loc/scripts/script.js"></script>
    </body>

    </html>
<?php
} else {
    header('location: ../Drive-Loc/autentification/signup.php');
    exit();
}
?>