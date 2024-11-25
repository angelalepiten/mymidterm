<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new Connection();
    $userCRUD = new UserCRUD();
    $user = $userCRUD->login($email, $password);

    if ($user) {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->username;
        $_SESSION['user_type'] = $user->user_type;
        if ($user->user_type == 'admin') {
            header("Location: admin.php");
        } else {

            header("Location: index.php");
        }
        exit;
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
    <style>
        /* Vintage Theme Styling */
        body {
            font-family: 'Georgia', serif; /* Vintage font */
            background-color: #f7f1e1; /* Soft parchment background */
            color: #6f4f37; /* Warm brown text color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff; /* White background for the container */
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
            background-color: #f9f3e3; /* Soft vintage background */
        }

        h2 {
            color: #6f4f37; /* Warm brown for the heading */
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: bold;
        }

        label {
            font-size: 1rem;
            color: #6f4f37;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            background-color: #fff;
            color: #6f4f37;
            font-size: 1rem;
        }

        input:focus {
            outline: none;
            border-color: #e9c5d2; /* Soft pink border on focus */
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #e9c5d2; /* Soft pink background */
            color: #6f4f37;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #f0a7c2; /* Darker pink on hover */
        }

        .error-message {
            color: #d9534f; /* Red color for error messages */
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }

        p {
            font-size: 1rem;
            color: #6f4f37;
        }

        a {
            color: #e9c5d2;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error_message)) : ?>
        <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="login-button">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up here</a>.</p>
    </div>
</body>

</html>
