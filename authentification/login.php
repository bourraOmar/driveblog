<?php

session_start();

require_once '../connection/connect.php';
require_once '../classes/user.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();

    if ($user->authenticate($email, $password)) {
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Form</title>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left column - Login Form -->
        <div class="flex-1 flex items-center justify-center">
            <div class="max-w-md w-full p-6">
                <div class="mb-8">
                    <div class="text-4xl mb-6">👋</div>
                    <h1 class="text-2xl font-semibold mb-2">Sign in to your account</h1>
                    <p class="text-sm text-gray-600">
                        Not a member?
                        <a href="signUp.php" class="text-indigo-600 hover:text-indigo-500">Sign up</a>
                    </p>
                </div>

                <form class="space-y-4" method="post">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" require>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" require>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Sign in
                    </button>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-50 text-gray-500">Or continue with</span>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        <!-- Right column - Image -->
        <div class="hidden lg:block flex-1 bg-gray-100">
            <img
                src="../img/car1.jpg"
                alt="Workspace setup with MacBook"
                class="w-full h-[100vh] object-cover">
        </div>


    </div>
</body>

</html>