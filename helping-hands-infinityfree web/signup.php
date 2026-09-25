<?php
require __DIR__ . "/config.php";
if (logged_in()) redirect("account.php");

$next = $_GET["next"] ?? $_POST["next"] ?? "";
$errors = [];
$old = ["firstName" => "", "lastName" => "", "email" => "", "phone" => "", "role" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verify_csrf();
    $old["firstName"] = trim($_POST["firstName"] ?? "");
    $old["lastName"]  = trim($_POST["lastName"] ?? "");
    $old["email"]     = trim($_POST["email"] ?? "");
    $old["phone"]     = trim($_POST["phone"] ?? "");
    $old["role"]      = trim($_POST["role"] ?? "");
    $password         = $_POST["password"] ?? "";
    $confirmPassword  = $_POST["confirmPassword"] ?? "";
    $terms            = isset($_POST["terms"]);

    if ($old["firstName"] === "") $errors[] = "Please enter your first name.";
    if ($old["lastName"] === "")  $errors[] = "Please enter your last name.";
    if ($old["email"] === "" || !filter_var($old["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if ($old["phone"] === "") $errors[] = "Please enter your phone number.";
    if ($old["role"] === "") $errors[] = "Please select a role.";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
    if ($password !== $confirmPassword) $errors[] = "Passwords do not match.";
    if (!$terms) $errors[] = "Please accept the Terms of Use and Privacy Policy to continue.";

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$old["email"]]);
        if ($stmt->fetch()) {
            $errors[] = "An account with that email already exists. Try logging in instead.";
        }
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            "INSERT INTO users (first_name, last_name, email, phone, role, password_hash)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$old["firstName"], $old["lastName"], $old["email"], $old["phone"], $old["role"], $hash]);

        session_regenerate_id(true);
        $_SESSION["user_id"] = (int)$pdo->lastInsertId();
        flash("success", "Welcome to Helping Hands, " . $old["firstName"] . "! Your account has been created.");
        $allowedNext = ["request" => "request.php", "volunteer" => "volunteer.php", "tasks" => "tasks.php"];
        redirect($allowedNext[$next] ?? "account.php");
    }
}

$activePage = "signup";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Sign Up</title>
<meta name="description" content="Create your Helping Hands account to request help or volunteer in your neighbourhood.">
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
      <div class="auth-side-art small" aria-hidden="true">
        <div class="heart-badge big"><i class="fa-solid fa-heart"></i></div>
      </div>
      <div class="auth-side-copy">
        <h2>Join Our Community</h2>
        <p>Create an account to request help or volunteer in your neighbourhood.</p>
        <ul class="perk-list">
          <li><i class="fa-solid fa-people-group"></i> Connect with neighbours who can help.</li>
          <li><i class="fa-solid fa-shield-heart"></i> Safe, secure and trusted platform.</li>
          <li><i class="fa-regular fa-heart"></i> Together, we build stronger communities.</li>
        </ul>
      </div>
    </div>

    <div class="auth-card wide">
      <h2>Create Your Account</h2>
      <p>Sign up to get started with Helping Hands</p>

      <form method="post" novalidate>
        <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">
        <input type="hidden" name="next" value="<?php echo h($next); ?>">
        <?php if ($errors): ?>
          <div class="form-alert show"><?php echo implode("<br>", array_map("h", $errors)); ?></div>
        <?php endif; ?>

        <div class="form-row">
          <div class="field">
            <label for="firstName">First Name</label>
            <div class="input-icon"><i class="fa-regular fa-user"></i><input id="firstName" name="firstName" required autocomplete="given-name" value="<?php echo h($old["firstName"]); ?>" placeholder="Enter first name"></div>
          </div>
          <div class="field">
            <label for="lastName">Last Name</label>
            <div class="input-icon"><i class="fa-regular fa-user"></i><input id="lastName" name="lastName" required autocomplete="family-name" value="<?php echo h($old["lastName"]); ?>" placeholder="Enter last name"></div>
          </div>
        </div>

        <div class="field">
          <label for="email">Email Address</label>
          <div class="input-icon"><i class="fa-regular fa-envelope"></i><input id="email" name="email" type="email" required autocomplete="email" value="<?php echo h($old["email"]); ?>" placeholder="Enter your email"></div>
        </div>

        <div class="field">
          <label for="phone">Phone Number</label>
          <div class="input-icon"><i class="fa-solid fa-phone"></i><input id="phone" name="phone" type="tel" required autocomplete="tel" value="<?php echo h($old["phone"]); ?>" placeholder="Enter your phone number"></div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="input-icon">
            <i class="fa-solid fa-lock"></i>
            <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" placeholder="Create a password">
            <button type="button" class="reveal-toggle" data-target="password" aria-label="Show password"><i class="fa-regular fa-eye"></i></button>
          </div>
          <span class="hint">Must be at least 8 characters</span>
        </div>

        <div class="field">
          <label for="confirmPassword">Confirm Password</label>
          <div class="input-icon">
            <i class="fa-solid fa-lock"></i>
            <input id="confirmPassword" name="confirmPassword" type="password" required autocomplete="new-password" placeholder="Confirm your password">
            <button type="button" class="reveal-toggle" data-target="confirmPassword" aria-label="Show password"><i class="fa-regular fa-eye"></i></button>
          </div>
        </div>

        <div class="field">
          <label for="role">I am a...</label>
          <select id="role" name="role" required>
            <option value="">Select your role</option>
            <option value="Requester" <?php echo $old["role"] === "Requester" ? "selected" : ""; ?>>Requester — I need help</option>
            <option value="Volunteer" <?php echo $old["role"] === "Volunteer" ? "selected" : ""; ?>>Volunteer — I want to help</option>
            <option value="Both" <?php echo $old["role"] === "Both" ? "selected" : ""; ?>>Both</option>
          </select>
        </div>

        <div class="field checkline-field">
          <input type="checkbox" id="terms" name="terms" required>
          <label for="terms">I agree to the <a href="terms.php" class="link-orange">Terms of Use</a> and <a href="privacy.php" class="link-orange">Privacy Policy</a></label>
        </div>

        <button type="submit" class="btn btn-orange full">Sign Up</button>
        <p class="switch-line">Already have an account? <a href="login.php<?php echo $next ? '?next=' . urlencode($next) : ''; ?>" class="link-orange">Log In</a></p>
      </form>
    </div>
  </section>
</main>

<?php include __DIR__ . "/partials/footer.php"; ?>
</body>
</html>
