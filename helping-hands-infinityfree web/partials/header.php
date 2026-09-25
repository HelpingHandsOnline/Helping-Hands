<?php
/**
 * partials/header.php
 * -----------------------------------------------------------------
 * Shared header for every page on the site. Every page includes
 * config.php first (for the database + session), then this file —
 * so the logged-in state shown here is accurate everywhere,
 * including the homepage.
 *
 * Expects $activePage to be set by the including page (e.g. "login"),
 * used to underline the matching nav link.
 * -----------------------------------------------------------------
 */
$activePage = $activePage ?? "";
$__me = logged_in() ? user() : null;
$__initial = $__me ? strtoupper(($__me["first_name"][0] ?? "") . ($__me["last_name"][0] ?? "")) : "";

function navActive($page, $active) {
    return $page === $active ? ' class="active" aria-current="page"' : "";
}
?>
<header class="site-header">
  <a class="logo" href="index.php">
    <img src="logo.png" alt="Helping Hands Community Assist logo">
    <span class="logo-text"><strong>HELPING HANDS</strong><span>COMMUNITY ASSIST</span></span>
  </a>
  <button class="menu" id="menuBtn" aria-label="Open menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
  <nav class="nav" id="nav">
    <a href="index.php"<?php echo navActive("home", $activePage); ?>>Home</a>
    <a href="howitworks.php"<?php echo navActive("howitworks", $activePage); ?>>How It Works</a>
    <a href="request.php"<?php echo navActive("request", $activePage); ?>>Request Help</a>
    <a href="volunteer.php"<?php echo navActive("volunteer", $activePage); ?>>Volunteer</a>
    <?php if ($__me): ?><a href="tasks.php"<?php echo navActive("tasks", $activePage); ?>>Task Centre</a><?php endif; ?>
    <a href="about.php"<?php echo navActive("about", $activePage); ?>>About Us</a>
    <a href="resources.php"<?php echo navActive("resources", $activePage); ?>>Resources</a>
    <a href="contact.php"<?php echo navActive("contact", $activePage); ?>>Contact Us</a>
  </nav>
  <div class="actions">
    <?php if ($__me): ?>
      <div class="user-chip">
        <div class="avatar"><?php echo h($__initial ?: "🙂"); ?></div>
        <span class="hello">Hi, <?php echo h($__me["first_name"]); ?><small>My Account</small></span>
      </div>
      <a class="btn btn-outline" href="account.php">My Account</a>
      <a class="btn btn-orange" href="logout.php">Log Out</a>
    <?php else: ?>
      <a class="btn btn-outline<?php echo $activePage === "login" ? " active" : ""; ?>" href="login.php">Log In</a>
      <a class="btn btn-orange<?php echo $activePage === "signup" ? " active" : ""; ?>" href="signup.php">Sign Up</a>
    <?php endif; ?>
  </div>
</header>
<?php $__flash = get_flash(); if ($__flash): ?>
  <div class="flash-banner flash-<?php echo h($__flash["type"]); ?>">
    <div class="container">
      <i class="fa-solid <?php echo $__flash["type"] === "success" ? "fa-circle-check" : "fa-triangle-exclamation"; ?>"></i>
      <span><?php echo h($__flash["message"]); ?></span>
    </div>
  </div>
<?php endif; ?>
