<?php
// ============================================
// CONFIGURATION: Database Settings
// ============================================
$host = 'localhost'; // Where the database lives locally in your device
$dbname = 'user_registration'; // Database name
$username_db = 'root'; // MySQL username (default for XAMPP)
$password_db = ''; // MySQL password (default for XAMPP is empty)

// ============================================
// ESTABLISH DATABASE CONNECTION
// ============================================
try {
    // PDO (PHP Data Objects) - modern way to connect to databases
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username_db, $password_db);

    // Set PDO to throw exceptions on errors (good for debugging)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $connection_success = true;
} catch (PDOException $e) {
    // If connection fails, show error
    $connection_success = false;
    $connection_error = 'Connection failed: ' . $e->getMessage();
}

// ============================================
// FORM VALIDATION & INSERT LOGIC
// ============================================
$errors = [];
$success = false;
$submitted = false;
$username = $email = $password = $confirm_password = '';

// Only process if connection is successful
if ($connection_success && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;

    // Get and sanitize input
    // Using NULL COALESCE
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Using TERNARY ALTERNATIVE
    // $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    // $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    // $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    // $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // --- Validation ---
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Username must be at least 3 characters';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Please confirm your password';
    } elseif ($confirm_password !== $password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // --- If no errors, insert into database ---
    if (empty($errors)) {
        try {
            // Hash the password (NEVER store plain text passwords!)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare SQL statement (prevents SQL injection)
            $sql = 'INSERT INTO users(username, email, password) VALUES (?, ?, ?)';
            $stmt = $pdo->prepare($sql);

            // Execute with the values
            $stmt->execute([$username, $email, $hashed_password]);

            $success = true;

            // Clear form data after success
            $username = $email = $password = $confirm_password = '';
        } catch (PDOException $e) {
            // Check if username or email already exists
            if ($e->getCode() == 23000) {
                // Duplicate entry error code
                $errors['database'] = 'Username or email already exists. Please choose different ones.';
            } else {
                $errors['database'] = 'Database error: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project 4 - Database Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #182b37;
            color: white;
        }

        .container {
            background-color: #0a151b;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #66a5e4;
            border-bottom: 2px solid #66a5e4;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        input.error {
            border-color: #e74c3c;
            background-color: #fff5f5;
        }

        input.success {
            border-color: #27ae60;
            background-color: #f0fff4;
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .success-message {
            background-color: #d5f5e3;
            color: #1a7a4a;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #27ae60;
            margin: 20px 0;
        }

        .error-message-box {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
            margin: 20px 0;
        }

        .connection-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
            margin: 20px 0;
        }

        .code-block {
            background-color: #2c3e50;
            color: #f1c40f;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            overflow-x: auto;
            margin: 15px 0;
            font-size: 14px;
        }

        .db-status {
            background-color: #d5f5e3;
            color: #1a7a4a;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🗄️ Register with Database</h2>
        <p>Your data will be stored permanently in MySQL.</p>

        <!-- Database Connection Status -->
        <?php if($connection_success): ?>
        <div class="db-status">✅ Connected to database successfully!</div>
        <?php else: ?>
        <div class="connection-error">
            <strong>❌ Database Connection Failed</strong>
            <?php echo $connection_error; ?>
            <small>Make sure XAMPP is running and the database exists.</small>
        </div>
        <?php endif; ?>

        <!-- Display Success Message -->
        <?php if($success): ?>
        <div class="success-message">
            <strong>✅ Registration Successful!</strong>
            User <strong><?php echo htmlspecialchars($username); ?></strong> has been saved to the database!
        </div>
        <?php endif; ?>

        <!-- Display Database Error -->
        <?php if(isset($errors['database'])): ?>
        <div class="error-message">
            <strong>❌ <?php echo $errors['database']; ?></strong>
        </div>
        <?php endif; ?>

        <!-- Display Form -->
        <form action="" method="POST" novalidate>
            <!-- Username -->
            <div class="form-group">
                <label for="username">👤 Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>"
                    class="
                <?php
                if (isset($submitted)) {
                    echo isset($errors['username']) ? 'error' : 'success';
                }
                ?>">

                <?php if(isset($errors['username'])): ?>
                <div class="error-message">
                    <?php echo $errors['username']; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">📧 Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>"
                    class="
                <?php if (isset($submitted)) {
                    echo isset($errors['email']) ? 'error' : 'success';
                } ?>">

                <?php if(isset($errors['email'])): ?>
                <div class="error-message">
                    <?php echo $errors['email']; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">🔒 Password</label>
                <input type="password" name="password" id="password"
                    class="
                <?php if (isset($submitted)) {
                    echo isset($errors['password']) ? 'error' : 'success';
                } ?>
                ">

                <?php if(isset($errors['password'])): ?>
                <div class="error-message">
                    <?php echo $errors['password']; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirm_password">🔒 Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    class="
                <?php if ($submitted) {
                    echo isset($errors['confirm_password']) ? 'error' : 'success';
                } ?>
                ">

                <?php if(isset($errors['confirm_password'])): ?>
                <div class="error-message">
                    <?php echo $errors['confirm_password']; ?>
                </div>
                <?php endif; ?>
            </div>

            <button type="submit">📨 Register</button>
        </form>

        <hr style="margin: 20px 0;">

        <!-- ============ VIEW RECORDS ============ -->
        <details>
            <summary>📋 View Registered Users</summary>
            <?php 
            if($connection_success){
                try{
                    $sql = "SELECT id, username, email, created_at FROM users ORDER BY id DESC";
                    $stmt = $pdo->query($sql);
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
            <div
                style="background-color: #1a2a35; padding: 15px; border-radius: 8px; margin-top: 10px; overflow-x: auto;">
                <table>
                    <thead>
                        <tr style="border-bottom: 1px solid #3498db;">
                            <th style="text-align: left; padding: 8px;">ID</th>
                            <th style="text-align: left; padding: 8px;">Username</th>
                            <th style="text-align: left; padding: 8px;">Email</th>
                            <th style="text-align: left; padding: 8px;">Registered</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                        <tr style="border-bottom: 1px solid #2a3a45;">
                            <td style="padding: 8px;"><?php echo $user['id']; ?></td>
                            <td style="padding: 8px;"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td style="padding: 8px;"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td style="padding: 8px; font-size: 12px;"><?php echo $user['created_at']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" style="padding: 8px; text-align: center; color: #7c8a95;">
                                No users registered yet.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p style="color: #7c8a95; font-size: 12px; margin-top: 10px;">
                    Total users: <?php echo count($users); ?>
                </p>
            </div>
            <?php 
                    } catch(PDOException $e){
                        echo '<div class="error-message-box">Error reading users: ' . $e->getMessage() . '</div>';
                    }
                }
            ?>
        </details>

        <!-- ============ CODE EXAMPLE ============ -->
        <details>
            <summary style="cursor: pointer; font-weight: bold; margin-top: 15px;">📖 Show Database Code</summary>
            <div class="code-block">
                <pre style="margin: 0; color: #f1c40f;">
// 1. Database connection
$pdo = new PDO("mysql:host=localhost;dbname=user_registration", "root", "");

// 2. Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 3. Prepare and execute SQL
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $email, $hashed_password]);

// 4. Fetch users
$sql = "SELECT * FROM users ORDER BY id DESC";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                </pre>
            </div>
        </details>


    </div>
</body>

</html>
