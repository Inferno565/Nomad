<?php
session_start(); // Start session
include("../Connection.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    // Fetch student data from database
    $query = "SELECT * FROM students WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row["password"])) {
            // Set session variables
            // $_SESSION["student_id"] = $row["id"];
            // $_SESSION["student_name"] = $row["name"];
            // $_SESSION["student_user_id"] = $row["user_id"];
            // $_SESSION["student_program"] = $row["program"];
            // $_SESSION["student_fees"] = $row["pending_fees"];
            // $_SESSION["student_attendance"] = $row["attendance"];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this user_id!";
    }
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