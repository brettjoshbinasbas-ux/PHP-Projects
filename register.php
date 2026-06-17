<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Project 3 - Registration Form with Validation</title>
    <style>
        body{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #182b37;
            color: white;
        }
        .container{
            background-color: #0a151b;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2{
            color: #66a5e4;
            border-bottom: 2px solid #66a5e4;
            padding-bottom: 10px;
        }
        .form-group{
            margin-bottom: 20px;
        }
        label{
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input{
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            margin-bottom: 5px;
        }
        input.error{
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
            margin-top: 20px;
            margin-bottom: 15px;
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
    </style>
</head>

<body>
    <div class="container">
        <h2>📝 Registration Form</h2>
        <p>Fill in the form below. All fields are required.</p>

        <?php
        // ============================================
        // PHP VALIDATION LOGIC (runs when form is submitted)
        // ============================================
        
        // initialize variables (empty by default)
        $username = $email = $password = $confirm_password = '';
        
        // initialize error array
        $errors = [];
        
        // track if form was submitted
        $submitted = false;
        
        // check if form was submitted via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submitted = true;
        
            // get form data and trim whitespace
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');
        
            // ============ VALIDATION RULES ============
            // 1. Username: required, min 3 chars
            if (empty($username)) {
                $errors['username'] = 'Username is required';
            } elseif (strlen($username) < 3) {
                $errors['username'] = 'Username must be at least 3 characters';
            }
        
            // 2. Email: required, valid format
            if (empty($email)) {
                $errors['email'] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email address';
            }
        
            // 3. Password: required, min 6 chars
            if (empty($password)) {
                $errors['password'] = 'Password is required';
            } elseif (strlen($password) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            }
        
            // 4. Confirm Password: matches password
            if (empty($confirm_password)) {
                $errors['confirm_password'] = 'Please confirm your password';
            } elseif ($confirm_password !== $password) {
                $errors['confirm_password'] = 'Password does not match';
            }
        
            // ============ IF NO ERRORS, PROCESS THE DATA ============
            if (empty($errors)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
                $success = true;
            }
        }
        ?>

        <!-- ============ DISPLAY SUCCESS MESSAGE ============ -->
        <?php if(isset($success) && $success === true): ?>
        <div class="success-message">
            <strong>✅ Registration Successful!</strong><br>
            Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>!<br>
            <small>Email: <?php echo htmlspecialchars($email); ?></small>
        </div>
        <?php endif; ?>

        <!-- ============ THE FORM ============ -->
        <form action="" method="POST" novalidate>
            <!-- Username Field -->
            <div class="form-group">
                <label for="username">👤 Username</label>
                <input type="text" name="username" id="username" placeholder="e.g. John Doe"
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" class=
                    "<?php
                    if ($submitted) {
                        echo isset($errors['username']) ? 'error' : 'success';
                    }
                    ?>">

                <?php if(isset($errors['username'])): ?>
                <div class="error-message"><?php echo $errors['username']; ?></div>
                <?php endif; ?>
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">📧 Email</label>
                <input type="email" name="email" id="email" placeholder="e.g.johndoe@gmail.com"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class=
                    "<?php
                    if ($submitted) {
                        echo isset($errors['email']) ? 'error' : 'success';
                    }
                    ?>">

                <?php if(isset($errors['email'])): ?>
                <div class="error-message"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">🔒 Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password (min 6 chars)"
                    class="<?php
                    if ($submitted) {
                        echo isset($errors['password']) ? 'error' : 'success';
                    }
                    ?>">
                <?php if(isset($errors['password'])): ?>
                <div class="error-message"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <!-- Confirm Password Field -->
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    placeholder="Match the password with your chosen password here"
                    class="
                <?php
                if ($submitted) {
                    echo isset($errors['confirm_password']) ? 'error' : 'success';
                }
                ?>">
                <?php if(isset($errors['confirm_password'])): ?>
                <div class="error-message"><?php echo $errors['confirm_password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">📧 Register</button>
        </form>

        <hr style="margin: 20px 0;">

        <!-- ============ DEBUG INFO (for learning) ============ -->
        <details>
            <summary style="cursor: pointer; font-weight: bold;"> 🔧 Show Debug Info</summary>
            <div
                style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 10px; font-family: monospace; font-size: 14px; color: black;">
                <strong>Submitted:</strong><?php echo $submitted ? 'Yes' : 'No'; ?><br>
                <strong>Errors:</strong><br>
                <pre><?php print_r($errors); ?></pre>
                <strong>POST Data:</strong><br>
                <pre><?php print_r($_POST); ?></pre>
            </div>
        </details>

        <!-- ============ CODE EXAMPLE ============ -->
        <details>
            <summary style="cursor: pointer; font-weight: bold; margin-top: 15px;">📖 Show Validation Code</summary>
            <div class="code-block">
                <pre style="margin: 0; color: #f1c40f;">
// Get form data
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');

// Validate username
if (empty($username)) {
    $errors['username'] = 'Username is required';
} elseif (strlen($username) &lt; 3) {
    $errors['username'] = 'Username must be at least 3 characters';
}

// Validate email
if (empty($email)) {
    $errors['email'] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address';
}

// If no errors, process data
if (empty($errors)) {
    // Hash password and save to database
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    // redirect to success page
}
                </pre>
            </div>
        </details>

    </div>
</body>

</html>
