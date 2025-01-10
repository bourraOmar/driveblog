<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - My Articles</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
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

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-gradient-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="../index.php" class="text-2xl font-bold w-8 mr-24">
                        <span class="text-2xl font-bold text-white">D&L</span>
                    </a>
                </div>

                <div class="flex gap-8">
                    <div class="hidden w-full md:block md:w-auto">
                        <ul class="flex space-x-8">
                            <li><a href="../index.php" class="text-white hover:text-gray-200 transition-all">Home</a></li>
                            <li><a href="../pages/vehicles.php" class="text-white hover:text-gray-200 transition-all">Cars</a></li>
                            <li><a href="../blog/blog_index.php" class="text-white hover:text-gray-200 transition-all">Blog</a></li>
                            <li><a href="../blog/myarticles.php" class="text-white hover:text-gray-200 transition-all border-b-2 border-white">My Articles</a></li>
                        </ul>
                    </div>
                    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                        <button type="button" class="flex text-sm rounded-full md:me-0" id="user-menu-button" aria-expanded="false">
                            <span class="sr-only">Open user menu</span>
                            <img width="40px" src="../imgs/profilephoto.png" alt="user photo">
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <div class="bg-gradient-primary py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">My Articles</h1>
                    <p class="text-gray-200 mt-2">Manage and track your contributions to the Drive & Loc community</p>
                </div>
                <div class="flex space-x-4">
                    <button class="bg-white px-4 py-2 rounded-lg hover:bg-gray-100">Draft Articles (2)</button>
                    <button class="btn-primary text-white px-4 py-2 rounded-lg">Published Articles (5)</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow-soft">
                <h3 class="text-gray-500">Total Views</h3>
                <p class="text-2xl font-bold">1,234</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-soft">
                <h3 class="text-gray-500">Total Likes</h3>
                <p class="text-2xl font-bold">256</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-soft">
                <h3 class="text-gray-500">Comments</h3>
                <p class="text-2xl font-bold">89</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-soft">
                <h3 class="text-gray-500">Featured Articles</h3>
                <p class="text-2xl font-bold">2</p>
            </div>
        </div>

        <!-- Articles List -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Published Articles</h2>
                <div class="flex items-center space-x-4">
                    <select class="border rounded px-2 py-1">
                        <option>Most Recent</option>
                        <option>Most Viewed</option>
                        <option>Most Liked</option>
                    </select>
                </div>
            </div>

            <!-- Article Items -->
            <div class="space-y-6">
                <!-- Article Item -->
                <div class="border-b pb-6">
                    <div class="flex justify-between items-start">
                        <div class="flex space-x-4">
                            <img src="/api/placeholder/200/120" alt="Article thumbnail" class="w-48 h-28 object-cover rounded">
                            <div>
                                <h3 class="text-xl font-bold mb-2">The Ultimate Guide to Mountain Driving</h3>
                                <p class="text-gray-600 mb-2">Essential tips and techniques for safely navigating mountain roads...</p>
                                <div class="flex space-x-2">
                                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">#DrivingTips</span>
                                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">#Safety</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="text-gray-500">Published: Jan 3, 2024</span>
                            <div class="flex space-x-4">
                                <span>👁️ 423</span>
                                <span>❤️ 45</span>
                                <span>💬 12</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-blue-500 hover:text-blue-700">Edit</button>
                                <button class="text-red-500 hover:text-red-700">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Article Item -->
                <div class="border-b pb-6">
                    <div class="flex justify-between items-start">
                        <div class="flex space-x-4">
                            <img src="/api/placeholder/200/120" alt="Article thumbnail" class="w-48 h-28 object-cover rounded">
                            <div>
                                <h3 class="text-xl font-bold mb-2">5 Essential Car Maintenance Tips for Winter</h3>
                                <p class="text-gray-600 mb-2">Keep your vehicle running smoothly during the cold months...</p>
                                <div class="flex space-x-2">
                                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">#Maintenance</span>
                                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">#Winter</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="text-gray-500">Published: Dec 28, 2023</span>
                            <div class="flex space-x-4">
                                <span>👁️ 312</span>
                                <span>❤️ 28</span>
                                <span>💬 8</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-blue-500 hover:text-blue-700">Edit</button>
                                <button class="text-red-500 hover:text-red-700">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center space-x-2 mt-8">
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">Previous</button>
                <button class="px-4 py-2 rounded-lg border bg-primary text-white">1</button>
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">2</button>
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">Next</button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-primary text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Drive & Loc Blog</h3>
                    <p class="text-gray-200">Share your driving experiences and automotive passion.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Popular Themes</h4>
                    <ul class="space-y-2 text-gray-200">
                        <li><a href="#" class="hover:text-white">Car Reviews</a></li>
                        <li><a href="#" class="hover:text-white">Travel Stories</a></li>
                        <li><a href="#" class="hover:text-white">Maintenance Tips</a></li>
                        <li><a href="#" class="hover:text-white">Driving Guides</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-200">
                        <li><a href="#" class="hover:text-white">Write Article</a></li>
                        <li><a href="#" class="hover:text-white">My Favorites</a></li>
                        <li><a href="#" class="hover:text-white">Community Guidelines</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-200 hover:text-white">Twitter</a>
                        <a href="#" class="text-gray-200 hover:text-white">Facebook</a>
                        <a href="#" class="text-gray-200 hover:text-white">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-200">
                <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        let isModalOpen = false;
        document.getElementById('user-menu-button').addEventListener('click', function() {
            let dropdown = document.getElementById('user-dropdown');
            if (isModalOpen) {
                dropdown.classList.add('hidden');
                isModalOpen = false;
            } else {
                dropdown.classList.remove('hidden');
                isModalOpen = true;
            }
        });
    </script>
</body>

</html>