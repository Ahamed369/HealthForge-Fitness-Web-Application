<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hash Generator - HEALTHFORGE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 100%;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-top: 10px;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        
        .result {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #28a745;
        }
        
        .result h3 {
            color: #28a745;
            margin-bottom: 15px;
        }
        
        .hash-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .sql-box {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin-bottom: 10px;
        }
        
        .copy-btn {
            padding: 8px 16px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        
        .copy-btn:hover {
            background: #218838;
        }
        
        .info-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .info-box h4 {
            color: #856404;
            margin-bottom: 10px;
        }
        
        .info-box ol {
            margin-left: 20px;
            color: #856404;
        }
        
        .info-box li {
            margin-bottom: 8px;
        }
        
        .highlight {
            background: #ffeb3b;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Password Hash Generator</h1>
        <p class="subtitle">Generate secure password hash for HEALTHFORGE admin account</p>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Admin Email:</label>
                <input type="text" id="email" name="email" value="admin@healthforge.com" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter password (e.g., admin123)" required>
            </div>
            
            <div class="form-group">
                <label for="name">Admin Name:</label>
                <input type="text" id="name" name="name" value="Admin" required>
            </div>
            
            <button type="submit">Generate Hash & SQL</button>
        </form>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];
            $name = htmlspecialchars($_POST['name']);
            
            // Generate password hash
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Generate SQL queries
            $insertSQL = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashedPassword', 'admin');";
            $updateSQL = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email';";
            
            echo '<div class="result">';
            echo '<h3>✅ Hash Generated Successfully!</h3>';
            
            echo '<p><strong>Original Password:</strong></p>';
            echo '<div class="hash-box">' . htmlspecialchars($password) . '</div>';
            
            echo '<p><strong>Hashed Password:</strong></p>';
            echo '<div class="hash-box">' . htmlspecialchars($hashedPassword) . '</div>';
            echo '<button class="copy-btn" onclick="copyToClipboard(\'' . htmlspecialchars($hashedPassword) . '\', this)">📋 Copy Hash</button>';
            
            echo '<hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">';
            
            echo '<p><strong>SQL to INSERT new admin (if not exists):</strong></p>';
            echo '<div class="sql-box">' . htmlspecialchars($insertSQL) . '</div>';
            echo '<button class="copy-btn" onclick="copyToClipboard(\'' . htmlspecialchars($insertSQL) . '\', this)">📋 Copy SQL</button>';
            
            echo '<p style="margin-top: 20px;"><strong>SQL to UPDATE existing admin:</strong></p>';
            echo '<div class="sql-box">' . htmlspecialchars($updateSQL) . '</div>';
            echo '<button class="copy-btn" onclick="copyToClipboard(\'' . htmlspecialchars($updateSQL) . '\', this)">📋 Copy SQL</button>';
            
            echo '</div>';
            
            echo '<div class="info-box">';
            echo '<h4>📝 How to Update in Database:</h4>';
            echo '<ol>';
            echo '<li>Open <span class="highlight">phpMyAdmin</span> (http://localhost/phpmyadmin)</li>';
            echo '<li>Select <span class="highlight">healthforge</span> database</li>';
            echo '<li>Click on <span class="highlight">SQL</span> tab at the top</li>';
            echo '<li>Paste one of the SQL queries above</li>';
            echo '<li>Click <span class="highlight">Go</span> button</li>';
            echo '<li>Done! Now login with: <span class="highlight">' . htmlspecialchars($email) . '</span> / <span class="highlight">' . htmlspecialchars($password) . '</span></li>';
            echo '</ol>';
            echo '</div>';
        }
        ?>
        
        <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
        <div class="info-box">
            <h4>ℹ️ Instructions:</h4>
            <ol>
                <li>Enter the admin email (default: admin@healthforge.com)</li>
                <li>Enter your desired password (e.g., admin123)</li>
                <li>Enter the admin name (default: Admin)</li>
                <li>Click "Generate Hash & SQL"</li>
                <li>Copy the SQL query and run it in phpMyAdmin</li>
            </ol>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        function copyToClipboard(text, button) {
            // Create temporary textarea
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            
            // Select and copy
            textarea.select();
            document.execCommand('copy');
            
            // Remove textarea
            document.body.removeChild(textarea);
            
            // Change button text
            const originalText = button.textContent;
            button.textContent = '✅ Copied!';
            button.style.background = '#28a745';
            
            // Reset after 2 seconds
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
            }, 2000);
        }
    </script>
</body>
</html>
