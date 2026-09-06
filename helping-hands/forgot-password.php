<?php require __DIR__ . "/config.php"; $activePage = ""; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Reset Your Password</title>
<meta name="description" content="Reset the password for your Helping Hands account.">
<meta property="og:type" content="website">
<meta property="og:title" content="Helping Hands | Reset Your Password">
<meta property="og:description" content="Reset the password for your Helping Hands account.">
<meta property="og:image" content="logo.png">
<meta property="og:site_name" content="Helping Hands Community Assist">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Helping Hands | Reset Your Password">
<meta name="twitter:description" content="Reset the password for your Helping Hands account.">
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
  <section class="auth-shell" style="grid-template-columns:1fr">
    <div class="auth-card" style="max-width:460px;margin:0 auto;padding:60px 0">
      <h2>Reset Your Password</h2>
      <p>Enter the email address on your account and we'll send you a link to reset your password.</p>

      <form id="forgotForm" novalidate>
        <div class="field">
          <label for="resetEmail">Email Address</label>
          <div class="input-icon">
            <i class="fa-regular fa-envelope"></i>
            <input id="resetEmail" type="email" required autocomplete="email" placeholder="Enter your email">
          </div>
          <span class="field-error">Please enter a valid email address.</span>
        </div>
        <div class="form-alert" id="forgotAlert"></div>
        <button type="submit" class="btn btn-dark full">Send Reset Link</button>
        <p class="switch-line">Remembered your password? <a href="login.php" class="link-orange">Log In</a></p>
      </form>
    </div>
  </section>
</main>



<?php include __DIR__ . "/partials/footer.php"; ?>
<script>
document.getElementById("forgotForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const email = document.getElementById("resetEmail");
  const alertBox = document.getElementById("forgotAlert");
  if (!email.value.includes("@")) {
    email.closest(".field").classList.add("error");
    return;
  }
  email.closest(".field").classList.remove("error");
  alertBox.textContent = "If an account exists for that email, a reset link has been sent. (This is a demo — no real email is sent.)";
  alertBox.classList.add("show", "success");
  this.reset();
});
</script>
</body>
</html>
