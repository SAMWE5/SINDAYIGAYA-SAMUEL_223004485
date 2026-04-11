<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - My Hotel</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Login Page Specific Styles */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 450px;
            max-width: 90%;
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

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .login-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .login-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-message::before {
            content: "⚠️";
            font-size: 18px;
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .back-home a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-home a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .input-icon {
            position: relative;
        }

        .input-icon input {
            padding-left: 40px;
        }

        .input-icon::before {
            content: "👤";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            z-index: 1;
        }

        .input-icon.password::before {
            content: "🔒";
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-body {
                padding: 30px;
            }
            
            .login-header {
                padding: 30px;
            }
            
            .login-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <h2>Welcome Back!</h2>
        <p>Please login to access admin panel</p>
    </div>
    
    <div class="login-body">
        <?php
        if (isset($_POST['login'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            
            // Simple authentication
            if ($user === "admin" && $pass === "1234") {
                $_SESSION['user'] = $user;
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'view_orders.php';
                    }, 500);
                </script>";
                echo "<div class='error-message' style='background:#e8f5e9; color:#2e7d32; border-left-color:#2e7d32;'>
                        ✅ Login successful! Redirecting...
                      </div>";
                exit();
            } else {
                echo "<div class='error-message'>
                        Invalid username or password. Please try again.
                      </div>";
            }
        }
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <div class="input-icon">
                    <input type="text" name="username" placeholder="Enter your username" required autocomplete="off">
                </div>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="input-icon password">
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>
            
            <button type="submit" name="login" class="login-btn">Login to Dashboard</button>
        </form>
        
        <div class="back-home">
            <a href="index.html">← Back to Homepage</a>
        </div>
        
        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px; font-size: 12px; color: #666; text-align: center;">
            <strong>Demo Credentials:</strong><br>
            Username: admin | Password: 1234
        </div>
    </div>
</div>

</body>
</html>