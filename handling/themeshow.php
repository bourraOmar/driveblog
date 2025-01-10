<?php
session_start();
require_once '../blog_class/artcile_class.php';
require_once '../blog_class/Theme_class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Blog</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb; /* Blue */
            --secondary: #1e40af; /* Darker Blue */
            --accent: #FFD700; /* Gold */
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
                <div class="hidden w-full md:block md:w-auto">
                    <ul class="flex space-x-8">
                        <li><a href="../index.php" class="text-white hover:text-gray-200 transition-all">Home</a></li>
                        <li><a href="../pages/vehicles.php" class="text-white hover:text-gray-200 transition-all">Cars</a></li>
                        <li><a href="../blog/blog_index.php" class="text-white hover:text-gray-200 transition-all border-b-2 border-white">Blog</a></li>
                        <li><a href="../blog/myarticles.php" class="text-white hover:text-gray-200 transition-all">My Articles</a></li>
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search and Filter Section -->
    <div class="bg-gradient-primary py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col items-center space-y-6">
                <?php 
                if(isset($_POST['themeId'])){ 
                $rows = Theme::getThemeNmme($_POST['themeId']);
                ?>
                <h1 class="text-4xl font-bold text-center text-white"><?php echo $rows['name'] ?></h1>
                <?php  } ?>
                <div class="flex flex-wrap gap-2 justify-center">
                    <span class="bg-white px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-gray-100"></span>
                    <span class="bg-white px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-gray-100"></span>
                    <span class="bg-white px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-gray-100"></span>
                    <span class="bg-white px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-gray-100"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <!-- Featured Articles -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Theme Articles</h2>
                <div class="flex items-center space-x-2">
                    <label>Show:</label>
                    <select class="border rounded px-2 py-1">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                    </select>
                </div>
            </div>
            
            <!-- Article Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php 
                $rows = Article::getArticlesByTheme($_POST['themeId']);
                foreach($rows as $row){
                    $tags = Article::gettagsForArticle($row['article_id']);
                ?>
                <div class="bg-white rounded-lg shadow-soft overflow-hidden card-animation">
                    <img src="<?php echo $row['article_image'] ?>" alt="Article" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-end mb-4">
                            <span class="text-sm text-gray-500"><?php echo $row['date_creation'] ?></span>
                        </div>
                        <h3 class="text-xl font-bold mb-2"><?php echo $row['title'] ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo $row['content'] ?></p>
                        <div class="flex items-center justify-between">
                            <div class="flex space-x-2">
                                <?php foreach ($tags as $tag) { ?>
                                    <span class="text-sm bg-gray-100 px-2 py-1 rounded"><?php echo $tag['name'] ?></span>
                                <?php } ?>
                            </div>
                            <!-- See Article Details Form -->
                            <form action="../blog/article.php" method="POST">
                                <div class="flex items-center space-x-4">
                                    <input type="submit" value="See Article" class="cursor-pointer btn-primary text-white px-4 py-2 rounded-lg">
                                    <input type="hidden" value="<?php echo $row['article_id'] ?>" name="article_name">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center space-x-2 mt-8">
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">Previous</button>
                <button class="px-4 py-2 rounded-lg border bg-primary text-white">1</button>
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">2</button>
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">3</button>
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
        document.getElementById('user-menu-button').addEventListener('click', function () {
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