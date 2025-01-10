<?php
session_start();
require_once '../blog_class/artcile_class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Title - Drive & Loc Blog</title>
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
                        <li><a href="../blog/blog_index.php" class="text-white hover:text-gray-200 transition-all">Blog</a></li>
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

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- Article Header -->
        <?php 
        $rows = Article::getSpecifiqueVehicule($_POST['article_name']);
        foreach($rows as $row){
        ?>
        <article class="bg-white rounded-xl shadow-soft overflow-hidden mb-8 card-animation">
            <img src="<?php echo $row['article_image'] ?>" alt="Article Cover" class="w-full h-96 object-cover">
            <div class="p-8">
                <h1 class="text-4xl font-bold mb-4"><?php echo $row['title'] ?></h1>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php 
                    $tags = Article::gettagsForArticle($_POST['article_name']);
                    foreach($tags as $tag){
                    ?>
                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm"><?php echo $tag['name'] ?></span>
                    <?php } ?>
                </div>
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4"><?php echo $row['content'] ?></p>
                </div>
            </div>
        </article>
        <?php } ?>

        <!-- Comments Section -->
        <section class="bg-white rounded-xl shadow-soft p-8 card-animation">
            <h2 class="text-2xl font-bold mb-6">Comments (12)</h2>
            <!-- Add Comment Form -->
            <form class="mb-8">
                <div class="mb-4">
                    <textarea class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Add a comment..."></textarea>
                </div>
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white">Post Comment</button>
            </form>
            <!-- Comments List -->
            <div class="space-y-6">
                <!-- Single Comment -->
                <div class="border-b pb-6">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-3">
                            <img src="/api/placeholder/40/40" alt="Commenter" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold">Jane Smith</p>
                                <p class="text-gray-500 text-sm">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex space-x-2 text-sm">
                            <button class="text-blue-500 hover:text-blue-700">Edit</button>
                            <button class="text-red-500 hover:text-red-700">Delete</button>
                        </div>
                    </div>
                    <p class="text-gray-600">Great article! I've been to destination #3 and it's exactly as described. Would love to visit the others as well.</p>
                </div>
            </div>
            <!-- Pagination for comments -->
            <div class="flex justify-center space-x-2 mt-8">
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">Previous</button>
                <button class="px-4 py-2 rounded-lg border bg-primary text-white">1</button>
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">2</button>
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">3</button>
                <button class="px-4 py-2 rounded-lg border hover:bg-gray-100">Next</button>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-primary text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Drive & Loc. Tous droits réservés.</p>
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