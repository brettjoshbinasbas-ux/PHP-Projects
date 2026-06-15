<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Project 2 - Form Handling</title>
</head>
<style>
    body {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #2c3e50;
        color: white;
    }

    .container {
        background-color: #162029;
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0);
        margin-bottom: 2%;
    }

    code,
    .code-block {
        color: #47d128;
    }

    h2 {
        color: #cdea3b;
        border-bottom: 2px solid #cdea3b;
        padding-bottom: 10px;
    }

    label {
        display: block;
        margin-top: 15px;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input,
    select {
        border-radius: 4px;
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }

    button {
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #3498db;
        border-radius: 10px;
        font-weight: bold;
        border: none;
        cursor: pointer;
    }

    button:hover {
        color: #162029;
        background-color: #2980b9;
    }

    button:active {
        color: white;
        background-color: #7eb7f1;
    }

    .result {
        background-color: #0a2f3b;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        border-left: 4px solid #3498db;
    }

    .code-block {
        background-color: #2c3e50;
        color: #f1c40f;
        padding: 15px;
        border-radius: 8px;
        font-family: monospace;
        overflow-x: auto;
        margin: 15px 0;
    }

    .method-get {
        border-left-color: #27ae60;
    }

    .method-post {
        border-left-color: #e74c3c;
    }

    a{
        color: #40bce5;
    }

    a:hover{
        color: #a5dcee;
    }

</style>

<body>
    <h1>🐘 PHP Project 2 - Form Handling (GET vs POST)</h1>
    <p>PHP can receive data from HTML forms using <code>$_GET</code> (visible in URL) or <code>$_POST</code> (hidden).
    </p>

    <!-- =============== GET METHOD EXAMPLE =============== -->
    <div class="container">
        <h2>METHOD 1: GET (Data visible in URL)</h2>
        <p>Use GET for search forms, bookmarks, or when you want users to share the URL with results.</p>

        <div class="code-block">
            &lt;form method="GET" action=""&gt;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;input type="text" name="search"&gt;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;button type="submit"&gt;Search&lt;/button&gt;<br>
            &lt;/form&gt;
        </div>

        <form action="" method="GET">
            <label for="search">🔍 Search something:</label>
            <input type="search" name="search" id="search" placeholder="search something..."
                value="<?php
                echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                ?>">

            <label for="category">📁 Category:</label>
            <select name="category" id="category">
                <option value="">All</option>

                <option value="php" <?php
                echo isset($_GET['category']) && $_GET['category'] == 'php' ? 'selected' : '';
                ?>>PHP</option>

                <option value="javascript" <?php
                echo isset($_GET['category']) && $_GET['category'] == 'javascript' ? 'selected' : '';
                ?>>Javascript</option>

                <option value="html" <?php
                echo isset($_GET['category']) && $_GET['category'] == 'html' ? 'selected' : '';
                ?>>HTML/CSS</option>
            </select>

            <button type="submit">🔍Search with GET</button>
        </form>

        <?php if(isset($_GET['search']) && $_GET['search'] !== ''): ?>
        <div class="result method-get">
            <strong>📊 GET Results:</strong><br>
            You searched for: <strong><?php echo htmlspecialchars($_GET['search']); ?></strong><br>
            Category: <strong><?php echo isset($_GET['category']) && $_GET['category'] !== '' ? htmlspecialchars($_GET['category']) : 'All'; ?></strong><br>
            <br>
            <em>💡 Notice the URL above shows:
                <code>?search=<?php echo urlencode($_GET['search']); ?>&category=<?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category']) : ''; ?></code></em>
        </div>
        <?php endif; ?>
    </div>

    <!-- =============== POST METHOD EXAMPLE =============== -->
    <div class="container">
        <h2>METHOD 2: POST (Data hidden, not in URL)</h2>
        <p>Use POST for login forms, registration, or any sensitive data (passwords, personal info).</p>

        <div class="code-block">
            &lt;form method="POST" action=""&gt;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;input type="text" name="username"&gt;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;input type="password" name="password"&gt;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;button type="submit"&gt;Login&lt;/button&gt;<br>
            &lt;/form&gt;
        </div>

        <form action="" method="POST">
            <label for="username">👤 Username:</label>
            <input type="text" name="username" id="username" placeholder="e.g. John Doe"
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">

            <label for="email">📧 Email:</label>
            <input type="email" name="email" id="email" placeholder="e.g. johndoe@gmail.com"
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

            <label for="message">💬 Message:</label>
            <input type="text" name="message" id="message" placeholder="Your message" value="<?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?>">

            <button type="submit">📨 Send with POST</button>
        </form>

        <?php 
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && $_POST['username'] !== ''):  
        ?>
        <div class="result method-post">
            <strong>📬 POST Data Received:</strong><br>
            Username: <strong><?php echo htmlspecialchars($_POST['username']); ?></strong><br>
            Email: <strong><?php echo htmlspecialchars($_POST['email']); ?></strong><br>
            Message: <strong><?php echo htmlspecialchars($_POST['message']); ?></strong><br>
            <br>
            <em>💡 Notice the URL did not change - POST data is hidden!</em>
        </div>
        <?php endif; ?>
    </div>

    <!-- =============== COMPARISON TABLE =============== -->

    <div class="container">
        <h2>📊 GET vs POST Comparison</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #2c3e50; color: white;">
                    <th style="padding: 10px; text-align: left;">Feature</th>
                    <th style="padding: 10px; text-align: left;">GET</th>
                    <th style="padding: 10px; text-align: left;">POST</th>
                </tr>
            </thead>

            <tbody>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">Data visibility</td>
                    <td style="padding: 10px;">Visible in URL</td>
                    <td style="padding: 10px;">Hidden in request body</td>
                </tr>

                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">Bookmarkable</td>
                    <td style="padding: 10px;">✅ YES</td>
                    <td style="padding: 10px;">❌No</td>
                </tr>

                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">Data size limit</td>
                    <td style="padding: 10px;">~2000 characters</td>
                    <td style="padding: 10px;">Much larger (MBs)</td>
                </tr>

                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">Security</td>
                    <td style="padding: 10px;"><code>$_GET['name']</code></td>
                    <td style="padding: 10px;"><code>$_POST['name']</code></td>
                </tr>
            </tbody>
        </table>
    </div>

    <h3>📝 Key Takeaways</h3>
    <ul>
        <li><code>$_GET</code> — data from URL query string (visible, bookmarkable)</li>
        <li><code>$_POST</code> — data from form body (hidden, not bookmarkable)</li>
        <li><code>htmlspecialchars()</code> — prevents XSS attacks (ALWAYS use when displaying user input)</li>
        <li><code>isset()</code> — checks if a variable exists before using it</li>
        <li><code>$_SERVER['REQUEST_METHOD']</code> — tells you if request was GET or POST</li>
    </ul>

    <p><a href="form-handler.php">🔄 Reset/Clear all form data</a></p>



</body>

</html>
