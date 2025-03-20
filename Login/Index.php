<?php
session_start();
include("../Connection.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT student_mobile, password FROM student_data WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: ../Dashboard"); // Redirect on success
            exit();
        } else {
            $error = "Invalid user_id or password!";
        }
    } else {
        $error = "Invalid user_id or password!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | My Panel</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="login-container">
        <div class="graphic">
            <h2>Welcome to Student Portal</h2>
        </div>
        <div class="login-box">
            <form action="" method="POST">
                <h2>Login</h2>
                <?php if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                } ?>
                <div class="input-group">
                    <label for="user_id">user_id</label>
                    <input type="user_id" id="user_id" name="user_id" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
                <p class="forgot-password"><a href="#">Forgot Password?</a></p>
            </form>
        </div>
    </div>
</body>

</html>