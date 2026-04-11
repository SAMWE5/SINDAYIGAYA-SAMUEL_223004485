<?php
include 'connect.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: order.html");
    exit();
}

// Get form data safely
$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$email    = mysqli_real_escape_string($conn, $_POST['email']);
$phone    = mysqli_real_escape_string($conn, $_POST['phone']);
$menu     = mysqli_real_escape_string($conn, $_POST['menu']);
$address  = mysqli_real_escape_string($conn, $_POST['address']);
$date     = mysqli_real_escape_string($conn, $_POST['date']);

// Validate inputs
$errors = [];
if (empty($fullname)) $errors[] = "Full name is required";
if (empty($email)) $errors[] = "Email is required";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
if (empty($phone)) $errors[] = "Phone number is required";
if (empty($menu)) $errors[] = "Please select a menu item";
if (empty($address)) $errors[] = "Address is required";
if (empty($date)) $errors[] = "Order date is required";

// Insert into database if no errors
if (empty($errors)) {
    $sql = "INSERT INTO orders (fullname, email, phone, menu, address, date)
            VALUES ('$fullname', '$email', '$phone', '$menu', '$address', '$date')";

    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);
        $success = true;
    } else {
        $db_error = "Database error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation - My Hotel</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .confirmation-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }

        .success-header .icon {
            font-size: 80px;
            margin-bottom: 10px;
        }

        .success-header h2 {
            margin: 0;
            font-size: 28px;
        }

        .success-body {
            padding: 40px;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .order-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            border-left: 4px solid #667eea;
            padding-left: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }

        .detail-value {
            color: #333;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-primary, .btn-secondary {
            flex: 1;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-primary:hover, .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .error-container {
            background: #fee;
            color: #c33;
            padding: 20px;
            text-align: center;
        }

        .error-list {
            text-align: left;
            margin: 20px 0;
        }

        .error-list li {
            padding: 5px 0;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <?php if (isset($success) && $success): ?>
        <!-- Success Message -->
        <div class="success-header">
            <div class="icon">✅</div>
            <h2>Order Confirmed!</h2>
            <p>Thank you for ordering with us</p>
        </div>
        
        <div class="success-body">
            <div class="order-details">
                <h3>Order Summary</h3>
                <div class="detail-row">
                    <span class="detail-label">Order ID:</span>
                    <span class="detail-value">#<?php echo $order_id; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Customer:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($fullname); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Menu Item:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($menu); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Delivery Date:</span>
                    <span class="detail-value"><?php echo date('F j, Y', strtotime($date)); ?></span>
                </div>
            </div>
            
            <div class="button-group">
                <a href="index.html" class="btn-primary">🏠 Back to Home</a>
                <a href="order.html" class="btn-secondary">🛍️ Order Again</a>
            </div>
        </div>
    
    <?php elseif (!empty($errors) || isset($db_error)): ?>
        <!-- Error Message -->
        <div class="success-header" style="background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);">
            <div class="icon">❌</div>
            <h2>Order Failed</h2>
            <p>Please check the following errors</p>
        </div>
        
        <div class="success-body">
            <?php if (!empty($errors)): ?>
                <div class="error-list">
                    <ul>
                        <?php foreach($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php elseif (isset($db_error)): ?>
                <p><?php echo $db_error; ?></p>
            <?php endif; ?>
            
            <a href="order.html" class="btn-primary" style="display: block; text-align: center;">← Back to Order Form</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>