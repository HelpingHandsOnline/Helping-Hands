<?php require __DIR__ . "/config.php"; $activePage = "home"; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Neighbours Helping Neighbours</title>
<meta name="description" content="Community Assist connects neighbours who need help with neighbours who want to volunteer their time. Simple. Respectful. Local.">
<meta property="og:type" content="website">
<meta property="og:title" content="Helping Hands | Neighbours Helping Neighbours">
<meta property="og:description" content="Community Assist connects neighbours who need help with neighbours who want to volunteer their time. Simple. Respectful. Local.">
<meta property="og:image" content="logo.png">
<meta property="og:site_name" content="Helping Hands Community Assist">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Helping Hands | Neighbours Helping Neighbours">
<meta name="twitter:description" content="Community Assist connects neighbours who need help with neighbours who want to volunteer their time. Simple. Respectful. Local.">
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="home.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="page-hero hero">
  <div class="container hero-grid">
    <div class="hero-copy">
      <span class="eyebrow">COMMUNITY ASSIST</span>
      <h1>Neighbours Helping<br><span>Neighbours.</span></h1>
      <p>Community Assist connects neighbours who need help with neighbours who want to volunteer their time. Simple. Respectful. Local.</p>
      <div class="hero-actions">
        <a class="btn btn-orange" href="request.php"><i class="fa-solid fa-hand-holding-heart"></i> Request Help</a>
        <a class="btn btn-ghost" href="volunteer.php"><i class="fa-regular fa-heart"></i> Become a Volunteer</a>
      </div>
      <div class="hero-note">
        <span><i class="fa-solid fa-shield-heart"></i> Safe &amp; verified</span>
        <span><i class="fa-solid fa-people-group"></i> 1,200+ neighbours helped</span>
        <span><i class="fa-solid fa-location-dot"></i> Cape Town community</span>
      </div>
    </div>
    <div class="hero-image-wrap with-orbit">
      <img class="hero-image" src="https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?auto=format&fit=crop&w=1100&q=88" alt="A volunteer helping an older neighbour carry groceries to her door">
      <div class="hero-float">
        <i class="fa-solid fa-heart"></i>
        <span><strong>Small acts. Stronger communities.</strong><small>We're here for one another.</small></span>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">SIMPLE BY DESIGN</span>
      <h2>How it works</h2>
      <p>Four simple steps connect a request with the right person, safely and quickly.</p>
    </div>
    <div class="icon-steps">
      <div class="icon-step">
        <span class="step-badge">1</span>
        <div class="step-icon"><i class="fa-solid fa-pen-to-square"></i></div>
        <h3>Submit a Request</h3>
        <p>Tell us what help you need and when.</p>
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
      <span class="eyebrow">GET INVOLVED</span>
      <h2>Popular help categories</h2>
      <p>These are the requests our volunteers help with most.</p>
    </div>
    <div class="grid4">
      <a class="category" href="request.php">
        <div class="category-icon"><i class="fa-solid fa-cart-shopping"></i></div>
        <h3>Grocery Shopping</h3>
        <p>Help with buying groceries and essential items.</p>
        <span class="link">Request →</span>
      </a>
      <a class="category" href="request.php">
        <div class="category-icon"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
        <h3>Prescription Collection</h3>
        <p>Collect prescriptions from pharmacies.</p>
        <span class="link">Request →</span>
      </a>
      <a class="category" href="request.php">
        <div class="category-icon"><i class="fa-solid fa-car-side"></i></div>
        <h3>Medical Transport</h3>
        <p>Transport to and from medical appointments.</p>
        <span class="link">Request →</span>
      </a>
      <a class="category" href="request.php">
        <div class="category-icon"><i class="fa-solid fa-clipboard-list"></i></div>
        <h3>Other Tasks</h3>
        <p>Other daily tasks, errands and odd jobs.</p>
        <span class="link">Request →</span>
      </a>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="stats-band">
      <div class="stat"><strong>1,200+</strong><small>Neighbours helped</small></div>
      <div class="stat"><strong>350+</strong><small>Active volunteers</small></div>
      <div class="stat"><strong>4,800+</strong><small>Tasks completed</small></div>
      <div class="stat"><strong>4.9<span>/5</span></strong><small>Average rating</small></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">REAL STORIES</span>
      <h2>What our community says</h2>
      <p>A few words from the neighbours and volunteers who make this work.</p>
    </div>
    <div class="grid4" style="grid-template-columns:repeat(3,1fr)">
      <article class="category" style="text-align:left">
        <div style="color:var(--orange);margin-bottom:10px"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
        <p style="font-size:11px;color:var(--muted);line-height:1.7;min-height:auto">"A volunteer picked up my prescription within two hours of my request. I felt supported instead of stuck."</p>
        <h3 style="margin-top:12px">Margaret, Requester</h3>
      </article>
      <article class="category" style="text-align:left">
        <div style="color:var(--orange);margin-bottom:10px"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
        <p style="font-size:11px;color:var(--muted);line-height:1.7;min-height:auto">"Volunteering here is flexible and genuinely rewarding. I help around my own schedule, on my own street."</p>
        <h3 style="margin-top:12px">Sipho, Volunteer</h3>
      </article>
      <article class="category" style="text-align:left">
        <div style="color:var(--orange);margin-bottom:10px"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>
        <p style="font-size:11px;color:var(--muted);line-height:1.7;min-height:auto">"Requesting help was so simple, and knowing volunteers are verified put my whole family at ease."</p>
        <h3 style="margin-top:12px">Aisha, Requester</h3>
      </article>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container video-section">
    <div class="video-copy">
      <span class="eyebrow">SEE IT IN ACTION</span>
      <h2 style="font-size:32px;color:var(--teal-dark)">What being part of this community looks like.</h2>
      <p>Every request on this platform becomes a real, human moment — a shared bag of groceries, a ride to an appointment, a familiar face checking in. Watch a short look at what everyday volunteering can achieve.</p>
      <a class="btn btn-orange" href="volunteer.php">Become a Volunteer <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="video-embed">
      <iframe src="https://www.youtube.com/embed/yocyWr-wSJY" title="A look at community volunteering in action" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
</section>

<div class="cta" style="background:linear-gradient(120deg,var(--teal-dark),var(--teal))">
  <div class="cta-icon"><i class="fa-solid fa-heart"></i></div>
  <div class="cta-copy"><strong>Stronger communities. Together.</strong><span>By helping each other, we build stronger, safer and more connected neighbourhoods.</span></div>
  <a class="btn btn-orange" href="signup.php">Get Started Today <i class="fa-solid fa-arrow-right"></i></a>
</div>

</main>



<?php include __DIR__ . "/partials/footer.php"; ?>
</body>
</html>
