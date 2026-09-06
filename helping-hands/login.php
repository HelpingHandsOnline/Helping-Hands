<?php
require __DIR__ . "/config.php";
if (logged_in()) redirect("account.php");

$next = $_GET["next"] ?? $_POST["next"] ?? "";
$errors = [];
$oldEmail = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verify_csrf();
    $oldEmail = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($oldEmail === "" || $password === "") {
        $errors[] = "Please enter both your email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$oldEmail]);
        $u = $stmt->fetch();

        if (!$u || !password_verify($password, $u["password_hash"])) {
            $errors[] = "Those details don't match an account. Check your email and password, or sign up.";
        } else {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $u["id"];
            flash("success", "Welcome back, " . $u["first_name"] . "!");
            $allowedNext = ["request" => "request.php", "volunteer" => "volunteer.php", "tasks" => "tasks.php"];
            redirect($allowedNext[$next] ?? "account.php");
        }
    }
}

$activePage = "login";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Log In</title>
<meta name="description" content="Log in to your Helping Hands account.">
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="auth-pages.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">
  <section class="auth-shell">
    <div class="auth-side">
      <div class="auth-side-art" aria-hidden="true">
        <i class="fa-solid fa-house-chimney house-icon"></i>
        <i class="fa-solid fa-tree tree-icon"></i>
        <div class="heart-badge"><i class="fa-solid fa-heart"></i></div>
      </div>
      <div class="auth-side-copy">
        <h2>Together, we build stronger communities.</h2>
        <p>Connecting neighbours. Building stronger communities. One helping hand at a time.</p>
      </div>
    </div>

    <div class="auth-card">
      <h2>Welcome Back</h2>
      <p>Log in to your Helping Hands account</p>

      <form method="post" novalidate>
        <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">
        <input type="hidden" name="next" value="<?php echo h($next); ?>">
        <?php if ($next === "request"): ?>
          <div class="form-alert show" style="background:#eef7f6;color:#0e5f5c">Please log in to submit a help request.</div>
        <?php elseif ($next === "volunteer"): ?>
          <div class="form-alert show" style="background:#eef7f6;color:#0e5f5c">Please log in to complete your volunteer application.</div>
        <?php elseif ($next === "tasks"): ?>
          <div class="form-alert show" style="background:#eef7f6;color:#0e5f5c">Please log in to open the Task Centre.</div>
        <?php endif; ?>
        <?php if ($errors): ?>
          <div class="form-alert show"><?php echo implode("<br>", array_map("h", $errors)); ?></div>
        <?php endif; ?>

        <div class="field">
          <label for="email">Email Address</label>
          <div class="input-icon">
            <i class="fa-regular fa-envelope"></i>
            <input id="email" name="email" type="email" required autocomplete="email" value="<?php echo h($oldEmail); ?>" placeholder="Enter your email">
          </div>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <div class="input-icon">
            <i class="fa-solid fa-lock"></i>
            <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Enter your password">
            <button type="button" class="reveal-toggle" data-target="password" aria-label="Show password"><i class="fa-regular fa-eye"></i></button>
          </div>
        </div>
        <div class="row-between">
          <label class="checkline"><input type="checkbox" id="rememberMe" name="rememberMe"> Remember me</label>
          <a href="forgot-password.php" class="link-orange">Forgot Password?</a>
        </div>
        <button type="submit" class="btn btn-dark full">Log In</button>
        <div class="divider"><span>or</span></div>
        <button type="button" class="btn btn-ghost full" id="googleBtn"><i class="fa-brands fa-google"></i> Continue with Google</button>
        <p class="switch-line">Don't have an account? <a href="signup.php<?php echo $next ? '?next=' . urlencode($next) : ''; ?>" class="link-orange">Sign Up</a></p>
      </form>
    </div>
  </section>
</main>

<?php include __DIR__ . "/partials/footer.php"; ?>
<script>
document.getElementById("googleBtn").addEventListener("click", function () {
  alert("Google sign-in isn't connected in this demo yet — please log in with your email and password instead.");
});
</script>
</body>
</html>
