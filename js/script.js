function displayData(sortColumn = 'product_id', sortOrder = 'ASC') {
  fetch(`actions.php?action=display&sortColumn=${sortColumn}&sortOrder=${sortOrder}`)
      .then(response => response.text())
      .then(data => {
          document.getElementById('resultContainer').innerHTML = data;
      })
      .catch(error => {
          console.error("Error fetching data:", error);
      });
}


function displayCategories(){
fetch('actions.php?action=category')
  .then(response => response.text())
  .then(data => {
    document.getElementById('resultContainer').innerHTML = data;
  });
}

function showSearchForm() {
  document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); search();">
          <input type="text" id="searchKeyword" placeholder="name, description ...." class="p-2 border rounded">
          <button type="submit" class="bg-green-500 text-white p-2 rounded">Search</button>
      </form>
  `;
}

function search() {
  const keyword = document.getElementById('searchKeyword').value;
  fetch(`actions.php?action=search&keyword=${encodeURIComponent(keyword)}`)
      .then(response => response.text())
      .then(data => {
          document.getElementById('resultContainer').innerHTML = data;
      });
}

function showAddForm() {
  document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); addRecord();">
          <input type="number" id="categoryId" placeholder="Category id" class="p-2 border rounded mb-2" required>
          <input type="text" id="productName" placeholder="Product Name" class="p-2 border rounded mb-2" required>
          <input type="text" id="description" placeholder="Description" class="p-2 border rounded mb-2" required>
          <input type="number" id="productPrice" placeholder="Price" class="p-2 border rounded mb-2" required>
          <input type="number" id="productQuantity" placeholder="Stock quantity" class="p-2 border rounded mb-2" required>
          <button type="submit" class="bg-yellow-500 text-white p-2 rounded">Add Product</button>
      </form>
  `;
}

function addRecord() {
  const category_id = document.getElementById('categoryId').value;
  const name = document.getElementById('productName').value;
  const description = document.getElementById('description').value;
  const price = document.getElementById('productPrice').value;
  const quantity = document.getElementById('productQuantity').value;
  fetch('actions.php?action=add', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `category_id=${encodeURIComponent(category_id)}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}&price=${encodeURIComponent(price)}&quantity=${encodeURIComponent(quantity)}`
  })
  .then(response => response.text())
  .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
  });
}

function showUpdateForm() {
  document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); updateRecord();">
          <input type="number" id="productId" placeholder="Product ID" class="p-2 border rounded mb-2" required>
          <input type="number" id="newCategoryID" placeholder="New Category ID" class="p-2 border rounded mb-2" required>
          <input type="text" id="newName" placeholder="New name" class="p-2 border rounded mb-2" required>
          <input type="text" id="newDescription" placeholder="New description" class="p-2 border rounded mb-2" required>
          <input type="number" id="newPrice" placeholder="New Price" class="p-2 border rounded mb-2" required>
          <input type="number" id="newQuantity" placeholder="New Quantity" class="p-2 border rounded mb-2" required>
          <button type="submit" class="bg-purple-500 text-white p-2 rounded">Update Product</button>
      </form>
  `;
}

function updateRecord() {
  const id = document.getElementById('productId').value;
  const category_id = document.getElementById('newCategoryID').value;
  const name = document.getElementById('newName').value;
  const description = document.getElementById('newDescription').value;
  const price = document.getElementById('newPrice').value;
  const quantity = document.getElementById('newQuantity').value;

  if (!id || !price || isNaN(price) || !quantity || isNaN(quantity) || !category_id || isNaN(category_id) || !name || !description) {
      document.getElementById('resultContainer').innerHTML = "Invalid input. Please provide valid Product ID and Price and Quantity.";
      return;
  }

  fetch('actions.php?action=update', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${encodeURIComponent(id)}&category_id=${encodeURIComponent(category_id)}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}&price=${encodeURIComponent(price)}&quantity=${encodeURIComponent(quantity)}`
  })
      .then(response => response.text())
      .then(data => {
          document.getElementById('resultContainer').innerHTML = data;
      })
      .catch(error => {
          document.getElementById('resultContainer').innerHTML = "An error occurred: " + error;
      });
}



function showDeleteForm() {
  document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); deleteRecord();">
          <input type="number" id="deleteProductId" placeholder="Product ID" class="p-2 border rounded mb-2" required>
          <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete Product</button>
      </form>
  `;
}

function deleteRecord() {
  const id = document.getElementById('deleteProductId').value;
  fetch('actions.php?action=delete', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${encodeURIComponent(id)}`
  })
  .then(response => response.text())
  .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
  });
}

function calculate() {
  fetch('actions.php?action=calculate')
      .then(response => response.text())
      .then(data => {
          document.getElementById('resultContainer').innerHTML = data;
      });
}

// --------------------------- CATEGORIES ---------------------------------------

function displayCategories() {
    fetch('actions.php?action=displayCategories')
      .then(response => response.text())
      .then(data => {
        document.getElementById('resultContainer').innerHTML = data;
      });
  }
  
  function showSearchCategoryForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); searchCategory();">
        <input type="text" id="searchCategoryKeyword" placeholder="name, description...." class="p-2 border rounded">
        <button type="submit" class="bg-green-500 text-white p-2 rounded">Search</button>
      </form>
    `;
  }
  
  function searchCategory() {
    const keyword = document.getElementById('searchCategoryKeyword').value;
    fetch(`actions.php?action=searchCategory&keyword=${encodeURIComponent(keyword)}`)
      .then(response => response.text())
      .then(data => {
        document.getElementById('resultContainer').innerHTML = data;
      });
  }
  
  function showAddCategoryForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); addCategory();">
        <input type="text" id="categoryName" placeholder="Category Name" class="p-2 border rounded mb-2" required>
        <input type="text" id="categoryDescription" placeholder="Description" class="p-2 border rounded mb-2" required>
        <button type="submit" class="bg-yellow-500 text-white p-2 rounded">Add Category</button>
      </form>
    `;
  }
  
  function addCategory() {
    const name = document.getElementById('categoryName').value;
    const description = document.getElementById('categoryDescription').value;
    fetch('actions.php?action=addCategory', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}`
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
  }
  
  function showUpdateCategoryForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); updateCategory();">
        <input type="number" id="categoryId" placeholder="Category ID" class="p-2 border rounded mb-2" required>
        <input type="text" id="newCategoryName" placeholder="New Category Name" class="p-2 border rounded mb-2" required>
        <input type="text" id="newCategoryDescription" placeholder="New Description" class="p-2 border rounded mb-2" required>
        <button type="submit" class="bg-purple-500 text-white p-2 rounded">Update Category</button>
      </form>
    `;
  }
  
  function updateCategory() {
    const id = document.getElementById('categoryId').value;
    const name = document.getElementById('newCategoryName').value;
    const description = document.getElementById('newCategoryDescription').value;
  
    fetch('actions.php?action=updateCategory', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${encodeURIComponent(id)}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}`
    })
      .then(response => response.text())
      .then(data => {
        document.getElementById('resultContainer').innerHTML = data;
      })
      .catch(error => {
        document.getElementById('resultContainer').innerHTML = "An error occurred: " + error;
      });
  }
  
  function showDeleteCategoryForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); deleteCategory();">
        <input type="number" id="deleteCategoryId" placeholder="Category ID" class="p-2 border rounded mb-2" required>
        <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete Category</button>
      </form>
    `;
  }
  
  function deleteCategory() {
    const id = document.getElementById('deleteCategoryId').value;
    fetch('actions.php?action=deleteCategory', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${encodeURIComponent(id)}`
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
  }

// --------------------------- CUSTOMERS ---------------------------------------

function displayCustomers() {
    fetch('actions.php?action=displayCustomers')
      .then(response => response.text())
      .then(data => {
        document.getElementById('resultContainer').innerHTML = data;
      });
  }
  
  function showSearchCustomerForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); searchCustomer();">
        <input type="text" id="searchCustomerKeyword" placeholder="name, email, address, phone..." class="p-2 border rounded">
        <button type="submit" class="bg-green-500 text-white p-2 rounded">Search</button>
      </form>
    `;
  }
  
  function searchCustomer() {
    const keyword = document.getElementById('searchCustomerKeyword').value;
    fetch(`actions.php?action=searchCustomer&keyword=${encodeURIComponent(keyword)}`)
      .then(response => response.text())
      .then(data => {
        document.getElementById('resultContainer').innerHTML = data;
      });
  }
  
  function showAddCustomerForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); addCustomer();">
        <input type="text" id="customerName" placeholder="Customer Name" class="p-2 border rounded mb-2" required>
        <input type="email" id="customerEmail" placeholder="Email" class="p-2 border rounded mb-2" required>
        <input type="tel" id="customerPhone" placeholder="Phone" class="p-2 border rounded mb-2" required>
        <input type="text" id="customerAddress" placeholder="Address" class="p-2 border rounded mb-2" required>
        <button type="submit" class="bg-yellow-500 text-white p-2 rounded">Add Customer</button>
      </form>
    `;
  }
  
  function addCustomer() {
    const name = document.getElementById('customerName').value;
    const email = document.getElementById('customerEmail').value;
    const phone = document.getElementById('customerPhone').value;
    const address = document.getElementById('customerAddress').value;
    fetch('actions.php?action=addCustomer', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&address=${encodeURIComponent(address)}`
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
  }
  
  function showUpdateCustomerForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); updateCustomer();">
        <input type="number" id="customerId" placeholder="Customer ID" class="p-2 border rounded mb-2" required>
        <input type="text" id="newCustomerName" placeholder="New Customer Name" class="p-2 border rounded mb-2" required>
        <input type="email" id="newCustomerEmail" placeholder="New Email" class="p-2 border rounded mb-2" required>
        <input type="tel" id="newCustomerPhone" placeholder="New Phone" class="p-2 border rounded mb-2" required>
        <input type="text" id="newCustomerAddress" placeholder="New Address" class="p-2 border rounded mb-2" required>
        <button type="submit" class="bg-purple-500 text-white p-2 rounded">Update Customer</button>
      </form>
    `;
  }
  
  function updateCustomer() {
    const id = document.getElementById('customerId').value;
    const name = document.getElementById('newCustomerName').value;
    const email = document.getElementById('newCustomerEmail').value;
    const phone = document.getElementById('newCustomerPhone').value;
    const address = document.getElementById('newCustomerAddress').value;
  
    fetch('actions.php?action=updateCustomer', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${encodeURIComponent(id)}&name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&address=${encodeURIComponent(address)}`
    })
      .then(response => response.text())
      .then(data => {
        document.getElementById('resultContainer').innerHTML = data;
      })
      .catch(error => {
        document.getElementById('resultContainer').innerHTML = "An error occurred: " + error;
      });
  }
  
  function showDeleteCustomerForm() {
    document.getElementById('formContainer').innerHTML = `
      <form onsubmit="event.preventDefault(); deleteCustomer();">
        <input type="number" id="deleteCustomerId" placeholder="Customer ID" class="p-2 border rounded mb-2" required>
        <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete Customer</button>
      </form>
    `;
  }
  
  function deleteCustomer() {
    const id = document.getElementById('deleteCustomerId').value;
    fetch('actions.php?action=deleteCustomer', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${encodeURIComponent(id)}`
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
  }
  
  
// ---------------------------------ORDERS----------------------------------------------

function displayOrders() {
  fetch('actions.php?action=displayOrders')
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
}

function showSearchOrderForm() {
  document.getElementById('formContainer').innerHTML = `
    <form onsubmit="event.preventDefault(); searchOrder();">
      <input type="text" id="searchOrderKeyword" placeholder="Order ID or Customer name" class="p-2 border rounded">
      <button type="submit" class="bg-green-500 text-white p-2 rounded">Search</button>
    </form>
  `;
}

function searchOrder() {
  const keyword = document.getElementById('searchOrderKeyword').value;
  fetch(`actions.php?action=searchOrder&keyword=${encodeURIComponent(keyword)}`)
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
}

function showAddOrderForm() {
  document.getElementById('formContainer').innerHTML = `
    <form onsubmit="event.preventDefault(); addOrder();">
      <input type="number" id="customerId" placeholder="Customer ID" class="p-2 border rounded mb-2 block" required>
      <input type="number" id="productID" placeholder="Product ID" class="p-2 border rounded mb-2 block" required>
      <input type="date" id="orderDate" class="p-2 border rounded mb-2 block" required>
      <input type="number" id="totalAmount" placeholder="Total Amount" step="0.01" class="p-2 border rounded mb-2 block" required>
      <select id="orderStatus" class="p-2 border rounded mb-2 block" required>
        <option value="">Select Status</option>
        <option value="Pending">Pending</option>
        <option value="Processing">Processing</option>
        <option value="Shipped">Shipped</option>
        <option value="Delivered">Delivered</option>
      </select>
      <button type="submit" class="bg-yellow-500 text-white p-2 rounded">Add Order</button>
    </form>
  `;
}


function addOrder() {
  const customerId = document.getElementById('customerId').value;
  const productID = document.getElementById('productID').value;
  const orderDate = document.getElementById('orderDate').value;
  const totalAmount = document.getElementById('totalAmount').value;
  const orderStatus = document.getElementById('orderStatus').value;
  fetch('actions.php?action=addOrder', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `customer_id=${encodeURIComponent(customerId)}&product_id=${encodeURIComponent(productID)}&order_date=${encodeURIComponent(orderDate)}&total_amount=${encodeURIComponent(totalAmount)}&order_status=${encodeURIComponent(orderStatus)}`
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('resultContainer').innerHTML = data;
  });
}

function showUpdateOrderForm() {
  document.getElementById('formContainer').innerHTML = `
    <form onsubmit="event.preventDefault(); updateOrder();">
      <input type="number" id="orderId" placeholder="Order ID" class="p-2 border rounded mb-2" required>
      <input type="number" id="newCustomerId" placeholder="New Customer ID" class="p-2 border rounded mb-2" required>
      <input type="number" id="newProductId" placeholder="New Product ID" class="p-2 border rounded mb-2" required>
      <input type="date" id="newOrderDate" class="p-2 border rounded mb-2" required>
      <input type="number" id="newTotalAmount" placeholder="New Total Amount" step="0.01" class="p-2 border rounded mb-2" required>
      <select id="newOrderStatus" class="p-2 border rounded mb-2" required>
        <option value="">Select Status</option>
        <option value="Pending">Pending</option>
        <option value="Processing">Processing</option>
        <option value="Shipped">Shipped</option>
        <option value="Delivered">Delivered</option>
      </select>
      <button type="submit" class="bg-purple-500 text-white p-2 rounded">Update Order</button>
    </form>
  `;
}

function updateOrder() {
  const orderId = document.getElementById('orderId').value;
  const customerId = document.getElementById('newCustomerId').value;
  const productId = document.getElementById('newProductId').value;
  const orderDate = document.getElementById('newOrderDate').value;
  const totalAmount = document.getElementById('newTotalAmount').value;
  const orderStatus = document.getElementById('newOrderStatus').value;

  fetch('actions.php?action=updateOrder', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `order_id=${encodeURIComponent(orderId)}&customer_id=${encodeURIComponent(customerId)}&product_id=${encodeURIComponent(productId)}&order_date=${encodeURIComponent(orderDate)}&total_amount=${encodeURIComponent(totalAmount)}&order_status=${encodeURIComponent(orderStatus)}`
  })
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    })
    .catch(error => {
      document.getElementById('resultContainer').innerHTML = "An error occurred: " + error;
    });
}

function showDeleteOrderForm() {
  document.getElementById('formContainer').innerHTML = `
    <form onsubmit="event.preventDefault(); deleteOrder();">
      <input type="number" id="deleteOrderId" placeholder="Order ID" class="p-2 border rounded mb-2" required>
      <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete Order</button>
    </form>
  `;
}

function deleteOrder() {
  const orderId = document.getElementById('deleteOrderId').value;
  fetch('actions.php?action=deleteOrder', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `order_id=${encodeURIComponent(orderId)}`
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('resultContainer').innerHTML = data;
  });
}

function calculateOrderStats() {
  fetch('actions.php?action=calculateOrderStats')
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
}


//-------------------------order-items-------delivery----------payments----------------
function showOrderItemsForm() {
  document.getElementById('formContainer').innerHTML = `
    <form onsubmit="event.preventDefault(); updateOrderItems();">
      <input type="number" id="orderItemOrderId" placeholder="Order ID" class="p-2 border rounded mb-2" required>
      <input type="number" id="orderItemQuantity" placeholder="New Quantity" class="p-2 border rounded mb-2" required>
      <input type="number" id="orderItemPrice" placeholder="New Price" step="0.01" class="p-2 border rounded mb-2" required>
      <button type="submit" class="bg-yellow-500 text-white p-2 rounded">Update Order Items</button>
    </form>
  `;
}

function updateOrderItems() {
  const orderId = document.getElementById('orderItemOrderId').value;
  const quantity = document.getElementById('orderItemQuantity').value;
  const price = document.getElementById('orderItemPrice').value;
  
  fetch('actions.php?action=updateOrderItems', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `order_id=${encodeURIComponent(orderId)}&quantity=${encodeURIComponent(quantity)}&price=${encodeURIComponent(price)}`
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('resultContainer').innerHTML = data;
  });
}

function showPaymentForm() {
  document.getElementById('formContainer').innerHTML = `
    <form onsubmit="event.preventDefault(); updatePayment();">
      <input type="number" id="paymentOrderId" placeholder="Order ID" class="p-2 border rounded mb-2" required>
      <input type="number" id="paymentAmount" placeholder="New Amount" step="0.01" class="p-2 border rounded mb-2" required>
      <input type="date" id="paymentDate" class="p-2 border rounded mb-2" required>
      <select id="paymentMethod" class="p-2 border rounded mb-2" required>
        <option value="">Select Payment Method</option>
        <option value="Credit Card">Credit Card</option>
        <option value="PayPal">PayPal</option>
        <option value="Bank Transfer">Bank Transfer</option>
        <option value="Cash">Cash</option>
      </select>
      <button type="submit" class="bg-green-500 text-white p-2 rounded">Update Payment</button>
    </form>
  `;
}

function updatePayment() {
  const orderId = document.getElementById('paymentOrderId').value;
  const amount = document.getElementById('paymentAmount').value;
  const paymentDate = document.getElementById('paymentDate').value;
  const paymentMethod = document.getElementById('paymentMethod').value;
  
  fetch('actions.php?action=updatePayment', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `order_id=${encodeURIComponent(orderId)}&amount=${encodeURIComponent(amount)}&payment_date=${encodeURIComponent(paymentDate)}&payment_method=${encodeURIComponent(paymentMethod)}`
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('resultContainer').innerHTML = data;
  });
}

function showDeliveryForm() {
  document.getElementById('formContainer').innerHTML = `
    <form onsubmit="event.preventDefault(); updateDelivery();">
      <input type="number" id="deliveryOrderId" placeholder="Order ID" class="p-2 border rounded mb-2" required>
      <select id="deliveryMethod" class="p-2 border rounded mb-2" required>
        <option value="">Select Delivery Method</option>
        <option value="Standard">Standard</option>
        <option value="Express">Express</option>
        <option value="Overnight">Overnight</option>
      </select>
      <input type="text" id="trackingNumber" placeholder="New Tracking Number" class="p-2 border rounded mb-2" required>
      <input type="date" id="estimatedDelivery" class="p-2 border rounded mb-2" required>
      <button type="submit" class="bg-purple-500 text-white p-2 rounded">Update Delivery</button>
    </form>
  `;
}

function updateDelivery() {
  const orderId = document.getElementById('deliveryOrderId').value;
  const deliveryMethod = document.getElementById('deliveryMethod').value;
  const trackingNumber = document.getElementById('trackingNumber').value;
  const estimatedDelivery = document.getElementById('estimatedDelivery').value;
  
  fetch('actions.php?action=updateDelivery', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `order_id=${encodeURIComponent(orderId)}&delivery_method=${encodeURIComponent(deliveryMethod)}&tracking_number=${encodeURIComponent(trackingNumber)}&estimated_delivery=${encodeURIComponent(estimatedDelivery)}`
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('resultContainer').innerHTML = data;
  });
}
function showOrderDetails(orderId) {
  fetch(`actions.php?action=getOrderDetails&order_id=${orderId}`)
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
}
function getOrderSummary() {
  fetch('actions.php?action=orderSummary')
    .then(response => response.text())
    .then(data => {
      document.getElementById('resultContainer').innerHTML = data;
    });
}
function sortData(column, order) {
  fetch(`actions.php?action=display&sortColumn=${column}&sortOrder=${order}`)
      .then(response => response.text())
      .then(data => {
          document.getElementById('resultContainer').innerHTML = data;
      });
}

document.querySelectorAll('.sortable').forEach(item => {
    item.addEventListener('click', function() {
        const column = item.getAttribute('data-column');
        const order = item.getAttribute('data-order');
        sortData(column, order);
    });
});
