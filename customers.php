<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customers</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="header">
    <h1 class="text-3xl font-bold mb-4">Customers</h1>
    <div class="grid grid-cols-6 gap-4 mb-4">
      <button class="bg-white text-black p-2 rounded"><a href="index.php">< Back</a></button>
      <button onclick="displayCustomers()" class="bg-blue-500 text-white p-2 rounded">Display Customers</button>
      <button onclick="showAddCustomerForm()" class="bg-yellow-500 text-white p-2 rounded">Add Customer</button>
      <button onclick="showUpdateCustomerForm()" class="bg-purple-500 text-white p-2 rounded">Update Customer</button>
      <button onclick="showDeleteCustomerForm()" class="bg-red-500 text-white p-2 rounded">Delete Customer</button>
      <button onclick="showSearchCustomerForm()" class="bg-green-500 text-white p-2 text-center rounded"><svg id="i-search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="auto" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="14" cy="14" r="12" /><path d="M23 23 L30 30"  /></svg></button>
    </div>
  </div>
  <div class="container mx-auto">
      <svg class="w-12 h-12 text-blue-500 mr-3 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d='M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'></path>
      </svg>
      <p>In this you can manage Customers.</p>
      <div id="formContainer" class="mb-4"></div>
      <div id="resultContainer"></div>
  </div>
  <script src="js/script.js"></script>
</body>
</html>
