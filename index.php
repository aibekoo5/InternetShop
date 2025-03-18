<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto display-flex justify-items-center">
        <img src="img/How-To-Get-More-Order-768x480.png" alt="img" class="my-8"> 
        <h1 class="text-4xl font-bold text-gray-800 mb-4 my-7">Welcome to Online Store Management System</h1>
        <p class="text-xl text-gray-600 my-7">Efficiently manage your online store with our comprehensive tools</p>

        <div class="grid md:grid-cols-2 gap-8">
                <?php
                $features = [
                    'products' => [
                        'title' => 'Product Management',
                        'description' => 'Add, edit, delete, and view all your products. Manage inventory and product details with ease.',
                        'icon' => 'M20 3H4a1 1 0 00-1 1v16a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1zm-1 16H5V5h14v14z M11 7h2v2h-2V7zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2zm-4-8h2v2H7V7zm0 4h2v2H7v-2zm0 4h2v2H7v-2z'
                    ],
                    'categories' => [
                        'title' => 'Category Management',
                        'description' => 'Organize your products into categories. Create, update, and manage product categories effortlessly.',
                        'icon' => 'M4 11h6a1 1 0 001-1V4a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1zm10 0h6a1 1 0 001-1V4a1 1 0 00-1-1h-6a1 1 0 00-1 1v6a1 1 0 001 1zM4 21h6a1 1 0 001-1v-6a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1zm10 0h6a1 1 0 001-1v-6a1 1 0 00-1-1h-6a1 1 0 00-1 1v6a1 1 0 001 1z'
                    ],
                    'orders' => [
                        'title' => 'Order Processing',
                        'description' => 'View and manage customer orders. Track order status, update information, and process orders efficiently.',
                        'icon' => 'M3 3h18a1 1 0 011 1v16a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z'
                    ],
                    'customers' => [
                        'title' => 'Customer Management',
                        'description' => 'Manage customer information, view order history, and maintain strong customer relationships.',
                        'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'
                    ]
                ];

                foreach ($features as $key => $feature) {
                    echo <<<HTML
                    <div class="feature-card bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{$feature['icon']}"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-gray-800">{$feature['title']}</h2>
                        </div>
                        <p class="text-gray-600 mb-4">{$feature['description']}</p>
                        <a href="{$key}.php" class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-300">Manage {$feature['title']}</a>
                    </div>
                    HTML;
                }
                ?>
            </div>
    </div>    
    <script src="js/script.js"></script>

    <footer class="mt-12 text-center text-gray-600 my-9">
            <p> Online Store Management System. Created by Kemel Aibek and Nurtai Akzhol</p>
        </footer>
</body>
</html>

