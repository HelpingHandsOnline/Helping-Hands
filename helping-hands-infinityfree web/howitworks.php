<?php require __DIR__ . "/config.php"; $activePage = "howitworks"; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | How It Works</title>
<meta name="description" content="See how Community Assist connects neighbours who need help with volunteers who want to give their time.">
<meta property="og:type" content="website">
<meta property="og:title" content="Helping Hands | How It Works">
<meta property="og:description" content="See how Community Assist connects neighbours who need help with volunteers who want to give their time.">
<meta property="og:image" content="logo.png">
<meta property="og:site_name" content="Helping Hands Community Assist">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Helping Hands | How It Works">
<meta name="twitter:description" content="See how Community Assist connects neighbours who need help with volunteers who want to give their time.">
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="howitworks.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="section" style="padding-bottom:0">
  <div class="container section-title">
    <span class="eyebrow">SIMPLE. RESPECTFUL. LOCAL.</span>
    <h2 style="font-size:44px">How It Works</h2>
    <p style="max-width:560px;margin:0 auto">We make it simple to get help and build stronger communities by connecting neighbours and volunteers.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="icon-steps">
      <div class="icon-step">
        <span class="step-badge">1</span>
        <div class="step-icon"><i class="fa-solid fa-pen-to-square"></i></div>
        <h3>Submit a Request</h3>
        <p>Tell us what help you need.</p>
      </div>
      <div class="icon-arrow"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="icon-step">
        <span class="step-badge">2</span>
        <div class="step-icon"><i class="fa-solid fa-people-group"></i></div>
        <h3>Volunteer Accepts</h3>
        <p>A local volunteer chooses to help.</p>
      </div>
      <div class="icon-arrow"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="icon-step">
        <span class="step-badge">3</span>
        <div class="step-icon"><i class="fa-solid fa-location-dot"></i></div>
        <h3>Get Connected</h3>
        <p>Contact details and address are shared after acceptance.</p>
      </div>
      <div class="icon-arrow"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="icon-step">
        <span class="step-badge">4</span>
        <div class="step-icon"><i class="fa-solid fa-circle-check"></i></div>
        <h3>Task Completed</h3>
        <p>The task is completed and both parties can leave feedback.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">OUR PRINCIPLES</span>
      <h2>Why it matters</h2>
      <p>Every request and every task follows the same guiding principles.</p>
    </div>
    <div class="value-grid">
      <div class="value-card">
        <i class="fa-solid fa-people-roof"></i>
        <h3>Stronger Communities</h3>
        <p>Helping each other creates stronger, safer neighbourhoods.</p>
      </div>
      <div class="value-card">
        <i class="fa-solid fa-shield-heart"></i>
        <h3>Safe &amp; Trusted</h3>
        <p>All volunteers are verified and your safety is our priority.</p>
      </div>
      <div class="value-card">
        <i class="fa-solid fa-people-group"></i>
        <h3>More Connections</h3>
        <p>Build relationships and bring people together.</p>
      </div>
      <div class="value-card">
        <i class="fa-solid fa-scale-balanced"></i>
        <h3>Fair for Everyone</h3>
        <p>Clear rules keep the platform fair, whether you're asking or giving help.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">GOOD TO KNOW</span>
      <h2>The rules that keep this fair</h2>
      <p>A short summary of the guidelines behind every request and task.</p>
    </div>
    <div class="grid4">
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-user-check"></i></div>
        <h3>One Active Request</h3>
        <p>Neighbours may have one active request at a time, so nobody is left waiting behind a queue.</p>
      </div>
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-clock"></i></div>
        <h3>72-Hour Window</h3>
        <p>A request expires after 72 hours if no volunteer accepts it, and can simply be reposted.</p>
      </div>
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
        <h3>One Task at a Time</h3>
        <p>Volunteers accept one active task at a time, so every request gets proper attention.</p>
      </div>
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-lock"></i></div>
        <h3>Privacy Protected</h3>
        <p>Contact details and addresses are only shared once a volunteer formally accepts.</p>
      </div>
    </div>
  </div>
</section>

<div class="cta">
  <div class="cta-icon"><i class="fa-regular fa-heart"></i></div>
  <div class="cta-copy"><strong>Ready to make a difference?</strong><span>Join our community of volunteers and start helping neighbours today.</span></div>
  <a class="btn btn-orange" href="volunteer.php">Become a Volunteer <i class="fa-solid fa-arrow-right"></i></a>
</div>

</main>



<?php include __DIR__ . "/partials/footer.php"; ?>
</body>
</html>
