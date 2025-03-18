<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="header">
    <h1 class="text-3xl font-bold mb-4">Orders</h1>
    <div class="grid grid-cols-6 gap-4 mb-4">
      <button class="bg-white text-black p-2 rounded"><a href="index.php">< Back</a></button>
      <button onclick="showOrderItemsForm()" class="bg-yellow-500 text-white p-2 rounded">Manage Order Items</button>
      <button onclick="showPaymentForm()" class="bg-green-500 text-white p-2 rounded">Manage Payments</button>
      <button onclick="showDeliveryForm()" class="bg-purple-500 text-white p-2 rounded">Manage Delivery</button>
      <button onclick="displayOrders()" class="bg-blue-500 text-white p-2 rounded">Display Orders</button>
      <button onclick="showSearchOrderForm()" class="bg-green-500 text-white p-2 text-center rounded"><svg id="i-search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="auto" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="14" cy="14" r="12" /><path d="M23 23 L30 30"  /></svg></button>
      <button onclick="showAddOrderForm()" class="bg-yellow-500 text-white p-2 rounded">Add Order</button>
      <button onclick="showUpdateOrderForm()" class="bg-purple-500 text-white p-2 rounded">Update Order</button>
      <button onclick="showDeleteOrderForm()" class="bg-red-500 text-white p-2 rounded">Delete Order</button>
      <button onclick="calculateOrderStats()" class="bg-indigo-500 text-white p-2 rounded">Calculate Status</button>
      <button onclick="displayData()" class="bg-indigo-500 text-white p-2 rounded">Display Products</button>
      <button onclick="displayCustomers()" class="bg-blue-500 text-white p-2 rounded">Display Customers</button>
    </div>
  </div>
  <div class="container mx-auto">
  <svg class="w-12 h-12 text-blue-500 mr-3 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d='M3 3h18a1 1 0 011 1v16a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z'></path>
      </svg>
      <p>In this you can manage Orders.</p>
      <div id="formContainer" class="mb-4"></div>
      <div id="resultContainer"></div>
  </div>
  <script src="js/script.js"></script>
</body>
</html>

