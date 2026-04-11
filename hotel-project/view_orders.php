<?php
session_start();

// Protect page (must login first)
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Orders - Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Admin Panel Specific Styles */
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar Styling */
        .admin-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .admin-navbar .logo {
            color: white;
            margin: 0;
            font-size: 24px;
        }

        .admin-navbar .menu a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .admin-navbar .menu a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        /* Content Container */
        .admin-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Header Section */
        .page-header {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h2 {
            margin: 0;
            color: #333;
            font-size: 28px;
        }

        .page-header h2 span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 14px;
            margin-left: 10px;
        }

        .stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        /* Table Styling */
        .orders-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .orders-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .orders-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            color: #555;
        }

        .orders-table tr:hover {
            background: #f8f9ff;
            transition: background 0.3s ease;
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        /* Action Buttons */
        .action-btn {
            padding: 5px 10px;
            margin: 0 3px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: #2196F3;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn-view:hover, .btn-delete:hover {
            transform: translateY(-1px);
            opacity: 0.9;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: 10px;
        }

        .empty-state h3 {
            color: #666;
            margin-top: 20px;
        }

        /* Search Box */
        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }

        .search-box button {
            padding: 10px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .orders-table {
                overflow-x: scroll;
            }
            
            .page-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .admin-navbar {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<div class="admin-navbar">
    <h2 class="logo">🏨 My Hotel Admin Panel</h2>
    <div class="menu">
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

<div class="admin-container">
    <div class="page-header">
        <h2>
            📋 Customer Orders 
            <span>Admin Dashboard</span>
        </h2>
        <div class="stats">
            <?php
            $count_sql = "SELECT COUNT(*) as total FROM orders";
            $count_result = mysqli_query($conn, $count_sql);
            $count_row = mysqli_fetch_assoc($count_result);
            echo "Total Orders: " . $count_row['total'];
            ?>
        </div>
    </div>

    <!-- Search Box (Optional Feature) -->
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="🔍 Search by name, email, or phone..." onkeyup="searchOrders()">
        <button onclick="searchOrders()">Search</button>
    </div>

    <div class="orders-table">
        <table id="ordersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Menu Item</th>
                    <th>Address</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM orders ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>#{$row['id']}</td>
                            <td><strong>{$row['fullname']}</strong></td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td><span class='badge badge-success'>{$row['menu']}</span></td>
                            <td>{$row['address']}</td>
                            <td>" . date('F j, Y', strtotime($row['date'])) . "</td>
                            <td>
                                <span class='badge badge-success'>✅ Completed</span>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr>
                        <td colspan='8'>
                            <div class='empty-state'>
                                📭 No orders found
                                <h3>No customer orders yet</h3>
                                <p>When customers place orders, they will appear here.</p>
                            </div>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Search functionality
function searchOrders() {
    let input = document.getElementById('searchInput');
    let filter = input.value.toUpperCase();
    let table = document.getElementById('ordersTable');
    let tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let tdName = tr[i].getElementsByTagName('td')[1];
        let tdEmail = tr[i].getElementsByTagName('td')[2];
        let tdPhone = tr[i].getElementsByTagName('td')[3];
        
        if (tdName || tdEmail || tdPhone) {
            let nameValue = tdName ? tdName.textContent || tdName.innerText : '';
            let emailValue = tdEmail ? tdEmail.textContent || tdEmail.innerText : '';
            let phoneValue = tdPhone ? tdPhone.textContent || tdPhone.innerText : '';
            
            if (nameValue.toUpperCase().indexOf(filter) > -1 ||
                emailValue.toUpperCase().indexOf(filter) > -1 ||
                phoneValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// Auto-refresh every 30 seconds (optional)
setTimeout(function() {
    location.reload();
}, 30000);
</script>

</body>
</html>