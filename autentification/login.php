<?php
require_once '../classes/user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $user->logIn($email, $password);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Login</title>
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

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-secondary {
            background-color: var(--secondary);
        }

        .bg-accent {
            background-color: var(--accent);
        }

        .text-primary {
            color: var(--primary);
        }

        .text-secondary {
            color: var(--secondary);
        }

        .text-accent {
            color: var(--accent);
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="../index.php" class="text-2xl font-bold w-8 mr-24">
                        <span class="text-2xl font-bold text-white">D&L</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="../autentification/login.php" class="text-white hover:text-accent">Login</a>
                    <a href="../autentification/signup.php" class="bg-accent px-6 py-2 rounded-lg hover:bg-yellow-500 text-white">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-primary">Welcome Back</h2>
                <p class="mt-2 text-gray-600">Please login to your account</p>
            </div>

            <form class="mt-8 space-y-6 bg-white p-8 rounded-lg shadow" method="POST">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <?php
                if (isset($_GET['error'])) {
                    echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>

                <button type="submit" class="w-full bg-primary py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white btn-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Sign In
                </button>

                <div class="text-center text-sm text-gray-600">
                    Not registered yet?
                    <a href="../autentification/signup.php" class="font-medium text-primary hover:text-secondary">Create an account</a>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>