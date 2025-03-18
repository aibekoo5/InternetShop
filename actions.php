<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$port = "5432";
$dbname = "OnlineShopping";
$user = "postgres";
$password = "kaibeke865";

function connectToDatabase()
{
    global $host, $port, $dbname, $user, $password;
    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$connection) {
        die("Connection failed: " . pg_last_error());
    }

    return $connection;
}

function displayTable($result)
{
    if (pg_num_rows($result) > 0) {
        $firstRow = pg_fetch_assoc($result);
        $hasOrderId = isset($firstRow['order_id']);

        echo "<table class='min-w-full bg-white border border-gray-300'>";
        echo "<thead class='bg-gray-100'><tr>";

        foreach ($firstRow as $key => $value) {
            echo "<th class='py-2 px-4 border-b'>";

            echo "<a href='actions.php?action=display&sortColumn=$key&sortOrder=ASC' class='text-blue-500'>▲</a> ";
            echo htmlspecialchars($key);
            echo " <a href='actions.php?action=display&sortColumn=$key&sortOrder=DESC' class='text-blue-500'>▼</a>";

            echo "</th>";
        }

        if ($hasOrderId) {
            echo "<th class='py-2 px-4 border-b'>Actions</th>";
        }

        echo "</tr></thead>";
        echo "<tbody>";

        pg_result_seek($result, 0);

        while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                // Check if $value is null and replace it with a default value (e.g., an empty string)
                echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
            }
            if ($hasOrderId) {
                echo "<td class='py-2 px-4 border-b'>";
                echo "<button onclick='showOrderDetails(" . htmlspecialchars($row['order_id'], ENT_QUOTES, 'UTF-8') . ")' class='bg-blue-500 text-white p-2 rounded'>View Details</button>";
                echo "</td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody></table>";
    } else {
        echo "No results found.";
    }

    echo "<button class='bg-white text-black p-2 rounded'><a href='products.php'>< Back</a></button>";
}



$action = $_GET['action'] ?? '';

try {
    $connection = connectToDatabase();

    switch ($action) {
        case 'display':
            $sortColumn = $_GET['sortColumn'] ?? 'product_id';
            $sortOrder = $_GET['sortOrder'] ?? 'ASC';

            $allowedColumns = ['product_id', 'name', 'order_id', 'price', 'quantity'];
            $allowedOrder = ['ASC', 'DESC'];

            if (!in_array($sortColumn, $allowedColumns) || !in_array($sortOrder, $allowedOrder)) {
                $sortColumn = 'product_id';
                $sortOrder = 'ASC';
            }

            $query = "SELECT * FROM products ORDER BY $sortColumn $sortOrder";
            $result = pg_query($connection, $query);

            if ($result) {
                displayTable($result);
            } else {
                echo "Error retrieving data: " . pg_last_error($connection);
            }
            break;


        case 'category':
            $result = pg_query($connection, "SELECT * FROM categories ORDER BY category_id");
            displayTable($result);
            break;

        case 'search':
            $keyword = $_GET['keyword'] ?? '';
            $result = pg_query_params(
                $connection,
                "SELECT * FROM products WHERE name ILIKE $1 OR description ILIKE $1",
                array("%$keyword%")
            );
            displayTable($result);
            break;

        case 'searchOrder':
            $keyword = $_GET['keyword'] ?? '';
            $result = pg_query_params(
                $connection,
                "SELECT o.order_id, c.name as customer_name, o.order_date, o.total_amount, o.status 
                     FROM orders o 
                     JOIN customers c ON o.customer_id = c.customer_id 
                     WHERE o.order_id::text LIKE $1 OR c.name ILIKE $1",
                array("%$keyword%")
            );
            displayTable($result);
            break;

        case 'searchCustomer':
            $keyword = $_GET['keyword'] ?? '';
            $result = pg_query_params(
                $connection,
                "SELECT * FROM customers WHERE name ILIKE $1 OR email ILIKE $1 OR phone ILIKE $1 OR address ILIKE $1",
                array("%$keyword%")
            );
            displayTable($result);
            break;

        case 'searchCategory':
            $keyword = $_GET['keyword'] ?? '';
            $result = pg_query_params(
                $connection,
                "SELECT * FROM categories WHERE name ILIKE $1 OR description ILIKE $1",
                array("%$keyword%")
            );
            displayTable($result);
            break;

        case 'add':
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $category_id = $_POST['category_id'] ?? '';

            pg_query($connection, "SELECT setval('products_product_id_seq', COALESCE((SELECT MAX(product_id) FROM products), 0) + 1, false)");

            $result = pg_query_params(
                $connection,
                "INSERT INTO products (category_id, name, description, price, quantity) VALUES ($1, $2, $3, $4, $5)",
                array($category_id, $name, $description, $price, $quantity)
            );

            if ($result) {
                echo "Product added successfully.";
            } else {
                echo "Error adding product: " . pg_last_error($connection);
            }
            break;

        case 'update':
            $id = $_POST['id'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $newPrice = $_POST['price'] ?? '';
            $newQuantity = $_POST['quantity'] ?? '';

            if (empty($id) || empty($category_id) || empty($name) || empty($description) || empty($newPrice) || empty($newQuantity) || !is_numeric($id) || !is_numeric($newPrice) || !is_numeric($newQuantity)) {
                echo "Invalid input. Please provide valid Product ID, Price, and Quantity.";
                break;
            }

            $result = pg_query_params(
                $connection,
                "UPDATE products SET category_id = $2, name = $3, description = $4, price = $5, stock_quantity = $6 WHERE product_id = $1",
                array($id, $category_id, $name, $description, $newPrice, $newQuantity)
            );

            if ($result) {
                echo "Product updated successfully.";
            } else {
                echo "Error updating product: " . pg_last_error($connection);
            }
            break;



        
            case 'delete':
                $id = $_POST['id'] ?? '';
                if (empty($id) || !is_numeric($id)) {
                    echo "Invalid product ID.";
                    break;
                }
                $result = pg_query_params($connection,
                    "DELETE FROM products WHERE product_id = $1;",
                    array($id)
                );
              
                if ($result) {
                    $affected_rows = pg_affected_rows($result);
              
                    if ($affected_rows > 0) {
                        echo "Product deleted successfully.";
                        pg_query($connection, "
                            DO $$ 
                            BEGIN
                                UPDATE products
                                SET product_id = product_id - 1
                                WHERE product_id > $id;
                                
                            END
                            $$;
                        ");
                    } else {
                        echo "No product found with the given ID.";
                    }
                } else {
                    echo "Error deleting product: " . pg_last_error($connection);
                }
                break;



        case 'calculate':
            $result = pg_query($connection, "
                SELECT c.name AS category, COUNT(*) AS product_count, AVG(p.price) AS avg_price
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                GROUP BY c.name
            ");
            displayTable($result);
            break;

        case 'displayCategories':
            $result = pg_query($connection, "SELECT * FROM categories ORDER BY category_id");
            displayTable($result);
            break;

        case 'addCategory':
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            pg_query($connection, "SELECT setval('categories_category_id_seq', COALESCE((SELECT MAX(category_id) FROM categories), 0) + 1, false)");

            $result = pg_query_params(
                $connection,
                "INSERT INTO categories (name, description) VALUES ($1, $2)",
                array($name, $description)
            );

            if ($result) {
                echo "Category added successfully.";
            } else {
                echo "Error adding category: " . pg_last_error($connection);
            }
            break;

        case 'updateCategory':
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (empty($id) || !is_numeric($id)) {
                echo "Invalid category ID.";
                break;
            }

            $result = pg_query_params(
                $connection,
                "UPDATE categories SET name = $2, description = $3 WHERE category_id = $1",
                array($id, $name, $description)
            );

            if ($result) {
                echo "Category updated successfully.";
            } else {
                echo "Error updating category: " . pg_last_error($connection);
            }
            break;

        case 'deleteCategory':
            $id = $_POST['id'] ?? '';
            if (empty($id) || !is_numeric($id)) {
                echo "Invalid category ID.";
                break;
            }
            $result = pg_query_params(
                $connection,
                "DELETE FROM categories WHERE category_id = $1",
                array($id)
            );

            if ($result) {
                $affected_rows = pg_affected_rows($result);

                if ($affected_rows > 0) {
                    echo "Category deleted successfully.";
                    pg_query($connection, "
                        DO $$ 
                        BEGIN
                            UPDATE categories
                            SET category_id = category_id - 1
                            WHERE category_id > $id;
                            
                        END
                        $$;
                    ");
                } else {
                    echo "No category found with the given ID.";
                }
            } else {
                echo "Error deleting category: " . pg_last_error($connection);
            }
            break;

        case 'displayCustomers':
            $result = pg_query($connection, "SELECT * FROM customers ORDER BY customer_id");
            displayTable($result);
            break;

        case 'addCustomer':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            pg_query($connection, "SELECT setval('customers_customer_id_seq', COALESCE((SELECT MAX(customer_id) FROM customers), 0) + 1, false)");

            $result = pg_query_params(
                $connection,
                "INSERT INTO customers (name, email, phone, address) VALUES ($1, $2, $3, $4)",
                array($name, $email, $phone, $address)
            );

            if ($result) {
                echo "Customer added successfully.";
            } else {
                echo "Error adding customer: " . pg_last_error($connection);
            }
            break;

        case 'updateCustomer':
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            if (empty($id) || !is_numeric($id)) {
                echo "Invalid customer ID.";
                break;
            }

            $result = pg_query_params(
                $connection,
                "UPDATE customers SET name = $2, email = $3, phone = $4, address = $5 WHERE customer_id = $1",
                array($id, $name, $email, $phone, $address)
            );

            if ($result) {
                echo "Customer updated successfully.";
            } else {
                echo "Error updating customer: " . pg_last_error($connection);
            }
            break;

        case 'deleteCustomer':
            $id = $_POST['id'] ?? '';
            if (empty($id) || !is_numeric($id)) {
                echo "Invalid customer ID.";
                break;
            }
            $result = pg_query_params(
                $connection,
                "DELETE FROM customers WHERE customer_id = $1",
                array($id)
            );

            if ($result) {
                $affected_rows = pg_affected_rows($result);

                if ($affected_rows > 0) {
                    echo "Customer deleted successfully.";
                    pg_query($connection, "
                            DO $$ 
                            BEGIN
                                UPDATE customers
                                SET customer_id = customer_id - 1
                                WHERE customer_id > $id;
                                
                            END
                            $$;
                        ");
                } else {
                    echo "No customer found with the given ID.";
                }
            } else {
                echo "Error deleting customer: " . pg_last_error($connection);
            }
            break;

        case 'displayOrders':
            $result = pg_query($connection, "
                    SELECT o.order_id, c.name as customer_name, o.order_date, o.total_amount, o.status 
                    FROM orders o 
                    JOIN customers c ON o.customer_id = c.customer_id 
                    ORDER BY o.order_id
                ");
            displayTable($result);
            break;

        case 'addOrder':
            $customerId = $_POST['customer_id'] ?? '';
            $productID = $_POST['product_id'] ?? '';
            $orderDate = $_POST['order_date'] ?? '';
            $totalAmount = $_POST['total_amount'] ?? '';
            $orderStatus = $_POST['order_status'] ?? '';

            pg_query($connection, "SELECT setval('orders_order_id_seq', COALESCE((SELECT MAX(order_id) FROM orders), 0) + 1, false)");

            $result = pg_query_params(
                $connection,
                "INSERT INTO orders (customer_id, product_id, order_date, total_amount, status) VALUES ($1, $2, $3, $4, $5)",
                array($customerId, $productID, $orderDate, $totalAmount, $orderStatus)
            );

            if ($result) {
                echo "Order added successfully.";
            } else {
                echo "Error adding order: " . pg_last_error($connection);
            }
            break;

        case 'updateOrder':
            $orderId = $_POST['order_id'] ?? '';
            $customerId = $_POST['customer_id'] ?? '';
            $productId = $_POST['product_id'] ?? '';
            $orderDate = $_POST['order_date'] ?? '';
            $totalAmount = $_POST['total_amount'] ?? '';
            $orderStatus = $_POST['order_status'] ?? '';

            if (empty($orderId) || !is_numeric($orderId)) {
                echo "Invalid order ID.";
                break;
            }

            $result = pg_query_params(
                $connection,
                "UPDATE orders SET customer_id = $2, product_id = $3, order_date = $4, total_amount = $5, status = $6 WHERE order_id = $1",
                array($orderId, $customerId, $productId, $orderDate, $totalAmount, $orderStatus)
            );

            if ($result) {
                echo "Order updated successfully.";
            } else {
                echo "Error updating order: " . pg_last_error($connection);
            }
            break;

        case 'deleteOrder':
            $orderId = $_POST['order_id'] ?? '';
            if (empty($orderId) || !is_numeric($orderId)) {
                echo "Invalid order ID.";
                break;
            }
            $result = pg_query_params(
                $connection,
                "DELETE FROM orders WHERE order_id = $1",
                array($orderId)
            );

            if ($result) {
                $affected_rows = pg_affected_rows($result);

                if ($affected_rows > 0) {
                    echo "Order deleted successfully.";
                    pg_query($connection, "
                        DO $$
                        BEGIN
                            UPDATE orders
                            SET order_id = order_id - 1
                            WHERE order_id > $orderId;

                        END
                        $$;
                        ");
                } else {
                    echo "No order found with the given ID.";
                }
            } else {
                echo "Error deleting order: " . pg_last_error($connection);
            }
            break;


        case 'calculateOrderStats':
            $result = pg_query($connection, "
                SELECT 
                    COUNT(*) as total_orders,
                    SUM(total_amount) as total_revenue,
                    AVG(total_amount) as average_order_value,
                    MIN(total_amount) as min_order_value,
                    MAX(total_amount) as max_order_value
                FROM orders
            ");
            displayTable($result);
            break;

        case 'updateOrderItems':
            $orderId = $_POST['order_id'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $price = $_POST['price'] ?? '';

            $result = pg_query_params(
                $connection,
                "UPDATE order_items SET quantity = $2, price = $3 WHERE order_id = $1",
                array($orderId, $quantity, $price)
            );

            if ($result) {
                echo "Order items updated successfully.";
            } else {
                echo "Error updating order items: " . pg_last_error($connection);
            }
            break;

        case 'updatePayment':
            $orderId = $_POST['order_id'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $paymentDate = $_POST['payment_date'] ?? '';
            $paymentMethod = $_POST['payment_method'] ?? '';

            $result = pg_query_params(
                $connection,
                "UPDATE payments SET amount = $2, payment_date = $3, payment_method = $4 WHERE order_id = $1",
                array($orderId, $amount, $paymentDate, $paymentMethod)
            );

            if ($result) {
                echo "Payment updated successfully.";
            } else {
                echo "Error updating payment: " . pg_last_error($connection);
            }
            break;

        case 'updateDelivery':
            $orderId = $_POST['order_id'] ?? '';
            $deliveryMethod = $_POST['delivery_method'] ?? '';
            $trackingNumber = $_POST['tracking_number'] ?? '';
            $estimatedDelivery = $_POST['estimated_delivery'] ?? '';

            $result = pg_query_params(
                $connection,
                "UPDATE delivery SET delivery_method = $2, tracking_number = $3, estimated_delivery = $4 WHERE order_id = $1",
                array($orderId, $deliveryMethod, $trackingNumber, $estimatedDelivery)
            );

            if ($result) {
                echo "Delivery information updated successfully.";
            } else {
                echo "Error updating delivery information: " . pg_last_error($connection);
            }
            break;

        case 'getOrderDetails':
            $orderId = $_GET['order_id'] ?? '';

            $result = pg_query_params(
                $connection,
                "SELECT o.order_id, c.name as customer_name, p.name as product_name, 
                                o.total_amount, o.status, d.delivery_method, d.tracking_number, 
                                d.estimated_delivery, pay.amount as paid_amount, pay.payment_date, 
                                pay.payment_method, oi.quantity, oi.price as item_price
                         FROM orders o
                         JOIN customers c ON o.customer_id = c.customer_id
                         JOIN products p ON o.product_id = p.product_id
                         LEFT JOIN delivery d ON o.order_id = d.order_id
                         LEFT JOIN payments pay ON o.order_id = pay.order_id
                         LEFT JOIN order_items oi ON o.order_id = oi.order_id
                         WHERE o.order_id = $1",
                array($orderId)
            );

            if ($result) {
                $order = pg_fetch_assoc($result);
                if ($order) {
                    echo "<h2>Order Details for Order #" . htmlspecialchars($order['order_id']) . "</h2>";
                    echo "<p><strong>Customer:</strong> " . htmlspecialchars($order['customer_name']) . "</p>";
                    echo "<p><strong>Product:</strong> " . htmlspecialchars($order['product_name']) . "</p>";
                    echo "<p><strong>Total Amount:</strong> $" . htmlspecialchars($order['total_amount']) . "</p>";
                    echo "<p><strong>Status:</strong> " . htmlspecialchars($order['status']) . "</p>";
                    echo "<h3>Order Items</h3>";
                    echo "<p><strong>Quantity:</strong> " . htmlspecialchars($order['quantity']) . "</p>";
                    echo "<p><strong>Item Price:</strong> $" . htmlspecialchars($order['item_price']) . "</p>";
                    echo "<h3>Payment</h3>";
                    echo "<p><strong>Paid Amount:</strong> $" . htmlspecialchars($order['paid_amount']) . "</p>";
                    echo "<p><strong>Payment Date:</strong> " . htmlspecialchars($order['payment_date']) . "</p>";
                    echo "<p><strong>Payment Method:</strong> " . htmlspecialchars($order['payment_method']) . "</p>";
                    echo "<h3>Delivery</h3>";
                    echo "<p><strong>Delivery Method:</strong> " . htmlspecialchars($order['delivery_method']) . "</p>";
                    echo "<p><strong>Tracking Number:</strong> " . htmlspecialchars($order['tracking_number']) . "</p>";
                    echo "<p><strong>Estimated Delivery:</strong> " . htmlspecialchars($order['estimated_delivery']) . "</p>";
                } else {
                    echo "No order found with ID " . htmlspecialchars($orderId);
                }
            } else {
                echo "Error fetching order details: " . pg_last_error($connection);
            }
            break;

            // Add this to your actions.php

        case 'orderSummary':
            $result = pg_query($connection, "
        SELECT o.order_id, c.name as customer_name, p.name as product_name, 
               o.total_amount, o.status, d.delivery_method, pay.payment_method
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN products p ON o.product_id = p.product_id
        LEFT JOIN delivery d ON o.order_id = d.order_id
        LEFT JOIN payments pay ON o.order_id = pay.order_id
        ORDER BY o.order_id 
    ");
            displayTable($result);
            break;

        default:
            echo "Invalid action.";
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
} finally {
    if (isset($connection)) {
        pg_close($connection);
    }
}
