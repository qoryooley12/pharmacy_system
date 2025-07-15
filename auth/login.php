<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: http://localhost/pharmacy_system/Admin");
    exit;
}

$host = "localhost";
$dbname = "pharmacy_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("
            SELECT username, full_name, password, role, profile, status, permissions
            FROM users
            WHERE username = ?
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user["status"] !== "active") {
                $error = "Your account is inactive. Please contact the administrator.";
            } else {
                if ($user["password"] === $password) {
                    $permissions = [];

                    if (!empty($user["permissions"])) {
                        $permissions = explode(",", $user["permissions"]);
                    }

                    $_SESSION["username"] = $username;
                    $_SESSION["user"] = [
                        "username" => $user["username"],
                        "name" => $user["full_name"],
                        "role" => $user["role"],
                        "profile" => $user["profile"]
                    ];

                    $_SESSION["permissions"] = $permissions;

                    header("Location: ../Admin");
                    exit;
                } else {
                    $error = "Invalid password.";
                }
            }
        } else {
            $error = "User not found.";
        }
    } else {
        $error = "Please enter username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pharmacy Login</title>

  <!-- Bootstrap 5 CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
  />

  <style>
    body {
      background: #f2f5f9;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
      max-width: 750px;
      width: 100%;
      height: auto;
      display: flex;
      flex-direction: row;
    }
    .login-image-container {
      position: relative;
      width: 45%;
      display: none;
      background: linear-gradient(135deg, #1abc9c, #16a085);
    }
    .login-image-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.85;
    }
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: rgba(22, 160, 133, 0.6);
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      color: #fff;
      text-align: center;
      padding: 20px;
    }
    .overlay h1 {
      font-size: 28px;
      margin-bottom: 10px;
      font-weight: bold;
    }
    .overlay p {
      font-size: 15px;
      opacity: 0.9;
    }
    .login-form-container {
      padding: 40px;
      flex: 1;
    }
    .login-form-container h3 {
      color: #16a085;
      margin-bottom: 10px;
      text-align: center;
    }
    .welcome-text {
      text-align: center;
      color: #666;
      margin-bottom: 30px;
      font-size: 15px;
    }
    .form-group {
      position: relative;
      margin-bottom: 20px;
    }
    .form-group i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #16a085;
    }
    .form-control {
      padding-left: 40px;
      height: 45px;
      border-radius: 8px;
      border: 1px solid #ccc;
      transition: border-color 0.3s;
    }
    .form-control:focus {
      border-color: #16a085;
      box-shadow: none;
    }
    .login-btn {
      background: #16a085;
      border: none;
      height: 45px;
      border-radius: 8px;
      color: #fff;
      font-weight: 600;
      transition: background 0.3s;
    }
    .login-btn:hover {
      background: #138d75;
    }
    .additional-links {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }
    .additional-links a {
      color: #16a085;
      text-decoration: none;
      font-weight: 500;
    }
    .additional-links a:hover {
      text-decoration: underline;
    }
    .social-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }
    .social-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      background: #16a085;
      text-decoration: none;
      transition: background 0.3s;
    }
    .social-btn:hover {
      background: #138d75;
    }
    @media (min-width: 768px) {
      .login-image-container {
        display: block;
      }
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="login-image-container">
      <img src="../assets/img/leftImage.png" alt="Pharmacy Image" />
      <div class="overlay">
        <h1><i class="fas fa-prescription-bottle-alt me-2"></i>Village Pharmacy</h1>
        <p>Your trusted partner in health care and wellness.</p>
      </div>
    </div>

    <div class="login-form-container">
      <h3>Welcome Back!</h3>
      <p class="welcome-text">Please login to continue managing your pharmacy system.</p>

      <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group my-4">
          <i class="fas fa-user"></i>
          <input type="text" name="username" class="form-control" placeholder="Username" required />
        </div>
        <div class="form-group my-4">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="Password" required />
        </div>
        <div class="d-grid">
          <button type="submit" class="btn login-btn">
            <i class="fas fa-sign-in-alt me-2"></i> Login
          </button>
        </div>
      </form>

      <div class="additional-links mt-3">
        <span>Don't have an account? <a href="#">Register here</a></span><br/>
        <span>Or login with:</span>
      </div>
      <div class="social-buttons">
        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-google"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
