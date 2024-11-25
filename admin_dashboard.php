
<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'login_register');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['product_image'])) {
    $productName = trim($_POST['product_name']);
    $productPrice = trim($_POST['product_price']);
    $productImage = $_FILES['product_image'];

    // Validate image type and size
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($productImage['type'], $allowedTypes) && $productImage['size'] < 5000000) {
        // Handle image upload
        $imageName = time() . '_' . basename($productImage['name']);
        $targetDir = __DIR__ . '/uploads/';  // Use an absolute path
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($productImage['tmp_name'], $targetFile)) {
            // Insert new product into the database
            $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $productName, $productPrice, $imageName);
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Invalid file type or size.";
    }
}

// Check for form submission for deleting a product
if (isset($_POST['delete_product'])) {
    $productId = intval($_POST['product_id']); // Ensure $productId is an integer
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your CSS styles go here */
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            background-color: #f4f7fc;
            color: #333;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            background-color: #4a90e2;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .topbar h1 {
            font-size: 22px;
            margin-left: 10px;
        }

        .toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            width: 40px;
            height: 30px;
            transition: transform 0.3s;
        }

        .toggle-btn:hover {
            transform: rotate(90deg);
        }

        .bar {
            display: block;
            width: 100%;
            height: 4px;
            background-color: white;
            border-radius: 2px;
            transition: 0.3s;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            padding-top: 80px;
            position: fixed;
            left: -250px;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
            color: #ecf0f1;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease, padding-left 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 25px;
        }

        .main {
            margin-left: 0;
            padding: 80px 20px 20px 20px;
            width: 100%;
            transition: margin-left 0.3s ease;
        }

        form {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s;
        }

        form:hover {
            transform: translateY(-5px);
        }

        form label {
            margin-top: 10px;
            display: block;
            font-weight: bold;
            color: #34495e;
        }

        form input,
        form button {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        form input:focus,
        form button:focus {
            outline: none;
            border-color: #3498db;
        }

        form button {
            background-color: #3498db;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            font-weight: bold;
        }

        form button:hover {
            background-color: #2980b9;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .product-item {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
        }

        .product-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-item h6 {
            font-size: 20px;
            margin: 10px 0;
            color: #2c3e50;
        }

        .product-item p {
            color: #7f8c8d;
            font-size: 16px;
        }

        .product-item form button {
            margin-top: 10px;
            padding: 10px 16px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-item form button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <!-- Topbar -->
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <h1>Admin Dashboard</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="#">Manage Products</a>
        <a href="orders.php">Orders</a>
        <a href="#">Settings</a>
        <a href="index.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h2>Add New Product</h2>
        <form action="admin_dashboard.php" method="post" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" required>

            <label for="product_price">Product Price:</label>
            <input type="text" name="product_price" id="product_price" required>

            <label for="product_image">Product Image:</label>
            <input type="file" name="product_image" id="product_image" required>

            <button type="submit">Add Product</button>
        </form>

        <h2>Product List</h2>
        <div class="product-grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="product-item">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <h6><?php echo htmlspecialchars($row['name']); ?></h6>
                    <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                    <form action="admin_dashboard.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_product">Delete</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // JavaScript function to toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.querySelector('.main');

            sidebar.classList.toggle('open');
            main.style.marginLeft = sidebar.classList.contains('open') ? '250px' : '0';
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
