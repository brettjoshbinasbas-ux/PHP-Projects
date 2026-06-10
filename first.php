<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Project 1 - My First PHP Page</title>

    <style>
        body {
            background-color: #2f3945;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }

        .php-block {
            background-color: #0e1c2b;
            color: #f1c40f;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            margin: 20px auto;
        }

        .output {
            background-color: #ceb036;
            color: #0e1c2b;
            padding: 15px;
            border-radius: 8px;
            border-left: 8px solid #1359ae;
            margin: 20px auto;
        }

        a{
            color: #ceb036;
        }

        a:hover{
            color: #856d10;
        }

        a:active{
            color: #d2c79e;
        }
    </style>
</head>

<body>
    <h1 id="top">🐘 PHP Project 1: My First PHP Page</h1>
    <p>PHP runs on the <strong>server</strong>, not in your browser. The server processes the PHP code and send plain
        HTML to your browser.</p>

    <hr>

    <!-- ================ BASIC PHP ================ -->
    <h2>📦 1. Variables & Output</h2>

    <div class="php-block">
        &lt;?php<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$name = "Brett";<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$age = 20;<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$course = "BS Information Technology";<br>
        &nbsp;&nbsp;&nbsp;&nbsp;echo "Hello, my name is " . $name;<br>
        ?&gt;
    </div>

    <div class="output">
        <strong>Output:</strong>
        <br>
        <?php
        $name = 'Brett';
        $age = 20;
        $course = 'BS Information Technology';
        echo "Hello, my name is {$name}," . '<br>';
        echo "I am {$age} years old." . '<br>';
        echo "I study {$course}.";
        ?>
    </div>

    <hr>

    <!-- ================ PHP INSIDE HTML ================ -->
    <h2>🌀 2. PHP Inside HTML</h2>

    <div class="php-block">
        &lt;p&gt;Today is &lt;?php echo date('l, F j, Y'); ?&gt;.&lt;/p&gt;
    </div>

    <div class="output">
        <strong>Output:</strong>
        <br>
        <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
    </div>

    <hr>

    <!-- ================ CONDITIONALS ================ -->
    <h2>❓ 3. Conditionals (if/else)</h2>

    <?php
    $currentHour = date('H'); // 0-23
    if ($currentHour < 12) {
        $greeting = 'Good Morning! 🌅';
    } elseif ($currentHour < 18) {
        $greeting = 'Good Afternoon! ☀';
    } else {
        $greeting = 'Good Evening! 🌑';
    }
    ?>

    <div class="php-block">
        &lt;?php<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$currentHour = date('H');<br>
        &nbsp;&nbsp;&nbsp;&nbsp;if ($currentHour &lt; 12) {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$greeting = "Good morning!";<br>
        &nbsp;&nbsp;&nbsp;&nbsp;} elseif ($currentHour &lt; 18) {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$greeting = "Good afternoon!";<br>
        &nbsp;&nbsp;&nbsp;&nbsp;} else {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$greeting = "Good evening!";<br>
        &nbsp;&nbsp;&nbsp;&nbsp;}<br>
        ?&gt;<br>
        &lt;p&gt;&lt;?php echo $greeting; ?&gt;&lt;/p&gt;
    </div>

    <div class="output">
        <strong>Output:</strong>
        <br>
        <p><?php
        echo $greeting;
        ?></p>
    </div>

    <hr>

    <!-- ================ CONDITIONALS ================ -->
    <h2>♾ 4. Loops (for loop)</h2>

    <div class="php-block">
        &lt;?php<br>
        &nbsp;&nbsp;&nbsp;&nbsp;for ($i = 1; $i &lt;= 5; $i++) {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "Number: " . $i . "&lt;br&gt;";<br>
        &nbsp;&nbsp;&nbsp;&nbsp;}<br>
        ?&gt;
    </div>

    <div class="output">
        <strong>Output:</strong>
        <br>
        <p>
            <?php
            for ($i = 1; $i <= 5; $i++) {
                echo "Number {$i}." . '<br>';
            }
            ?></p>
    </div>

    <hr>

    <!-- ================ ARRAYS ================ -->
    <h2>📃 5. Arrays</h2>

    <?php
    $colors = ['Red', 'Green', 'Blue'];
    $person = [
        'name' => 'Brett',
        'age' => 20,
        'course' => 'BSIT',
    ];
    ?>

    <div class="php-block">
        &lt;?php<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$colors = ["Red", "Green", "Blue"];<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$person = [<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"name" => "Brett",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"age" => 20,<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"course" => "BSIT"<br>
        &nbsp;&nbsp;&nbsp;&nbsp;];<br>
        &nbsp;&nbsp;&nbsp;&nbsp;echo $colors[0]; // "Red"<br>
        &nbsp;&nbsp;&nbsp;&nbsp;echo $person["name"]; // "Brett"<br>
        ?&gt;
    </div>

    <div class="output">
        <strong>Output:</strong>
        <br>
        <p>First Color: <strong><?php echo $colors[0]; ?></strong>
            <br>
            Person's Name: <strong><?php echo $person['name']; ?></strong>
            <br>
            Person's Age: <strong><?php echo $person['age']; ?></strong>
            <br>
            Person's Course: <strong><?php echo $person['course']; ?></strong>
        </p>
    </div>

    <hr>

    <h3>📝 5.5. Key Takeaways</h3>
    <ul>
        <li>PHP code goes inside <code>&lt;?php ?&gt;</code> tags</li>
        <li>Variables start with <code>$</code> (e.g., <code>$name</code>)</li>
        <li>Use <code>echo</code> or <code>print</code> to output to HTML</li>
        <li>Use <code>.</code> to concatenate (join) strings, not <code>+</code></li>
        <li>PHP files end with <code>.php</code> extension</li>
        <li>The server processes PHP FIRST, then sends HTML to browser</li>
    </ul>

    <p><a href="first.php">🔄 Refresh this page</a> to see the greeting change based on time of day!</p>

    <!-- ================ PHP INFO ================ -->
    <h2>ℹ 6. PHP Info (for debugging)</h2>

    <div class="php-block">
        &lt;?php phpinfo(); ?&gt;
    </div>

    <div class="output">
        <strong>Note:</strong> <code>phpinfo()</code> shows your PHP configuration. It reveals your server configuration
        to anyone who visits. It's useful for debugging but should never be left on a live site.
    </div>

    <?php
    // phpinfo();
    ?>

    <h3>phpinfo() Image Sample</h3>
    <img src="https://kinsta.com/wp-content/uploads/2019/10/phpinfo-page-example.png" alt="phpinfo() image sample" width="600">

    <hr>
    <br>

    <a href="#top">Return to Top</a>

</body>

</html>
