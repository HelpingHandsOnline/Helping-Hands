<?php
require __DIR__ . "/config.php";
$activePage = "volunteer";

$existing = null;
if (logged_in()) {
    $me = user();
    $stmt = $pdo->prepare("SELECT * FROM volunteers WHERE user_id = ?");
    $stmt->execute([$me["id"]]);
    $existing = $stmt->fetch();
}

$errors = [];
$old = [
    "areas" => $existing["areas"] ?? "",
    "availability" => $existing["availability"] ?? "",
    "skills" => $existing["skills"] ?? "",
    "emergencyName" => $existing["emergency_contact_name"] ?? "",
    "emergencyPhone" => $existing["emergency_contact_phone"] ?? "",
    "motivation" => $existing["motivation"] ?? "",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_login("volunteer");
    verify_csrf();
    $me = user();
    $old["areas"]          = trim($_POST["areas"] ?? "");
    $old["availability"]   = trim($_POST["availability"] ?? "");
    $old["skills"]         = trim($_POST["skills"] ?? "");
    $old["emergencyName"]  = trim($_POST["emergencyName"] ?? "");
    $old["emergencyPhone"] = trim($_POST["emergencyPhone"] ?? "");
    $old["motivation"]     = trim($_POST["motivation"] ?? "");
    $agree                 = isset($_POST["agreeRules"]);

    if ($old["areas"] === "") $errors[] = "Please tell us which areas you can help in.";
    if ($old["availability"] === "") $errors[] = "Please select your availability.";
    if ($old["emergencyName"] === "") $errors[] = "Please give an emergency contact name.";
    if ($old["emergencyPhone"] === "") $errors[] = "Please give an emergency contact phone number.";
    if (!$agree) $errors[] = "Please confirm you understand the volunteer guidelines before submitting.";

    if (!$errors) {
        if ($existing) {
            $stmt = $pdo->prepare(
                "UPDATE volunteers SET areas=?, availability=?, skills=?, emergency_contact_name=?, emergency_contact_phone=?, motivation=? WHERE user_id=?"
            );
            $stmt->execute([$old["areas"], $old["availability"], $old["skills"], $old["emergencyName"], $old["emergencyPhone"], $old["motivation"], $me["id"]]);
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO volunteers (user_id, areas, availability, skills, emergency_contact_name, emergency_contact_phone, motivation, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 'Active')"
            );
            $stmt->execute([$me["id"], $old["areas"], $old["availability"], $old["skills"], $old["emergencyName"], $old["emergencyPhone"], $old["motivation"]]);
        }
        flash("success", $existing ? "Your volunteer profile has been updated." : "Thanks for applying — you're now a Helping Hands volunteer!");
        redirect("account.php");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Become a Volunteer</title>
<meta name="description" content="Join our community of kind-hearted volunteers and help make a positive impact in your neighbourhood.">
<meta property="og:type" content="website">
<meta property="og:title" content="Helping Hands | Become a Volunteer">
<meta property="og:description" content="Join our community of kind-hearted volunteers and help make a positive impact in your neighbourhood.">
<meta property="og:image" content="logo.png">
<meta property="og:site_name" content="Helping Hands Community Assist">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Helping Hands | Become a Volunteer">
<meta name="twitter:description" content="Join our community of kind-hearted volunteers and help make a positive impact in your neighbourhood.">
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="volunteer.css">
<link rel="stylesheet" href="request.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="page-hero hero">
  <div class="container hero-grid">
    <div class="hero-copy">
      <span class="eyebrow">JOIN THE MOVEMENT</span>
      <h1>Make a Difference.<br><span>Become a Volunteer.</span></h1>
      <p>Join our community of kind-hearted people and help make a positive impact in your neighbourhood — on your own schedule, in your own way.</p>
      <div class="hero-actions">
        <a class="btn btn-orange" href="<?php echo logged_in() ? '#apply' : 'signup.php?next=volunteer'; ?>"><i class="fa-regular fa-heart"></i> <?php echo $existing ? "Update Your Application" : "Sign Up to Volunteer"; ?></a>
        <a class="btn btn-ghost" href="#why">Learn More</a>
      </div>
      <div class="hero-note">
        <span><i class="fa-solid fa-clock"></i> Flexible hours</span>
        <span><i class="fa-solid fa-shield-heart"></i> Fully supported</span>
        <span><i class="fa-solid fa-people-group"></i> 350+ volunteers</span>
      </div>
    </div>
    <div class="hero-image-wrap with-orbit">
      <img class="hero-image" src="https://images.unsplash.com/photo-1593113646773-028c64a8f1b8?auto=format&fit=crop&w=1100&q=88" alt="A volunteer helping an older woman carry a bag of groceries and smiling together">
    </div>
  </div>
</section>

<section class="section" id="why">
  <div class="container">
    <div class="section-title">
      <span class="eyebrow">WHAT YOU'LL GAIN</span>
      <h2>Why volunteer with us?</h2>
      <p>Volunteering with Helping Hands is flexible, safe and genuinely rewarding.</p>
    </div>
    <div class="value-grid">
      <div class="value-card">
        <i class="fa-solid fa-heart"></i>
        <h3>Help Others</h3>
        <p>Make a real difference in someone's life.</p>
      </div>
      <div class="value-card">
        <i class="fa-solid fa-people-group"></i>
        <h3>Flexible Time</h3>
        <p>Choose when and how you want to help.</p>
      </div>
      <div class="value-card">
        <i class="fa-solid fa-shield-heart"></i>
        <h3>Safe &amp; Supported</h3>
        <p>We ensure a safe and supportive environment.</p>
      </div>
      <div class="value-card">
        <i class="fa-solid fa-star"></i>
        <h3>Build Community</h3>
        <p>Connect with amazing people in your area.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title">
      <span class="eyebrow">GETTING STARTED</span>
      <h2>How it works</h2>
      <p>Four simple steps to start volunteering.</p>
    </div>
    <div class="icon-steps">
      <div class="icon-step">
        <span class="step-badge">1</span>
        <div class="step-icon"><i class="fa-solid fa-user-plus"></i></div>
        <h3>Sign Up</h3>
        <p>Create your volunteer account.</p>
      </div>
      <div class="icon-arrow"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="icon-step">
        <span class="step-badge">2</span>
        <div class="step-icon"><i class="fa-solid fa-id-card"></i></div>
        <h3>Complete Profile</h3>
        <p>Add your details and preferences.</p>
      </div>
      <div class="icon-arrow"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="icon-step">
        <span class="step-badge">3</span>
        <div class="step-icon"><i class="fa-regular fa-handshake"></i></div>
        <h3>Get Matched</h3>
        <p>We match you with opportunities.</p>
      </div>
      <div class="icon-arrow"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="icon-step">
        <span class="step-badge">4</span>
        <div class="step-icon"><i class="fa-solid fa-hands-holding-circle"></i></div>
        <h3>Start Helping</h3>
        <p>Begin making a positive impact.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title">
      <span class="eyebrow">A FEW GROUND RULES</span>
      <h2>What to expect as a volunteer</h2>
      <p>Fair, simple guidelines that protect you and the neighbours you help.</p>
    </div>
    <div class="grid4">
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-list-check"></i></div>
        <h3>One Task at a Time</h3>
        <p>Accept one active task at a time so you can focus and do it well.</p>
      </div>
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-battery-half"></i></div>
        <h3>Max Three a Day</h3>
        <p>A daily limit of three completed tasks keeps things fair and sustainable.</p>
      </div>
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
        <h3>Two-Hour Grace Period</h3>
        <p>Change of plans? Cancel penalty-free within two hours of accepting.</p>
      </div>
      <div class="category">
        <div class="category-icon"><i class="fa-solid fa-clipboard-check"></i></div>
        <h3>Mark Tasks Complete</h3>
        <p>Confirm completion within 24 hours so requesters know the job is done.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title">
      <span class="eyebrow">FROM OUR VOLUNTEERS</span>
      <h2>What volunteering feels like</h2>
      <p>A few words from people already giving their time.</p>
    </div>
    <div class="grid4" style="grid-template-columns:repeat(3,1fr)">
      <article class="category" style="text-align:left">
        <div style="color:var(--orange);margin-bottom:10px"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
        <p style="font-size:11px;color:var(--muted);line-height:1.7;min-height:auto">"I volunteer twice a month around my work schedule. It's a small time commitment that makes a real difference to someone nearby."</p>
        <h3 style="margin-top:12px">Priya, Volunteer since 2024</h3>
      </article>
      <article class="category" style="text-align:left">
        <div style="color:var(--orange);margin-bottom:10px"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
        <p style="font-size:11px;color:var(--muted);line-height:1.7;min-height:auto">"The sign-up process took ten minutes and I was matched with my first task the same week. Genuinely well organised."</p>
        <h3 style="margin-top:12px">Thabo, Volunteer since 2025</h3>
      </article>
      <article class="category" style="text-align:left">
        <div style="color:var(--orange);margin-bottom:10px"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>
        <p style="font-size:11px;color:var(--muted);line-height:1.7;min-height:auto">"I like that I can accept or skip tasks depending on my week. No pressure, just help when I'm able to give it."</p>
        <h3 style="margin-top:12px">Emma, Volunteer since 2024</h3>
      </article>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container video-section">
    <div class="video-embed">
      <iframe src="https://www.youtube.com/embed/H1mYYIHbbCo" title="Volunteers describe what it's like to give their time" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="video-copy">
      <span class="eyebrow">HEAR IT FROM VOLUNTEERS</span>
      <h2 style="font-size:32px;color:var(--teal-dark)">What makes a Helping Hands volunteer?</h2>
      <p>Volunteers come from every walk of life and give their time in every way imaginable — a lift to an appointment, a chat over tea, a hand with the shopping. Hear directly from people already doing it.</p>
      <a class="btn btn-orange" href="signup.php">Sign Up to Volunteer <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<section class="section" id="apply" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow"><?php echo logged_in() ? ($existing ? "UPDATE YOUR PROFILE" : "ALMOST THERE") : "ONE LAST STEP"; ?></span>
      <h2><?php echo $existing ? "Update Your Volunteer Application" : "Complete Your Volunteer Application"; ?></h2>
      <p style="max-width:560px;margin:0 auto">
        <?php if (!logged_in()): ?>
          Create a free account first, then come straight back here to finish your application.
        <?php else: ?>
          Tell us how, where and when you'd like to help. Saved straight to your account.
        <?php endif; ?>
      </p>
    </div>

    <?php if (!logged_in()): ?>
      <div style="max-width:480px;margin:0 auto;text-align:center">
        <a class="btn btn-orange" href="signup.php?next=volunteer">Create an Account <i class="fa-solid fa-arrow-right"></i></a>
        <p style="margin-top:14px;font-size:12px;color:var(--muted)">Already have one? <a href="login.php?next=volunteer" style="color:var(--orange);font-weight:800">Log in</a> to apply.</p>
      </div>
    <?php else: ?>

    <?php if ($errors): ?>
      <div class="form-alert show" style="max-width:700px;margin:0 auto 20px">
        <?php echo implode("<br>", array_map("h", $errors)); ?>
      </div>
    <?php endif; ?>

    <div class="request-layout" style="grid-template-columns:1.4fr 1fr;max-width:1000px;margin:0 auto">
      <form class="request-card" method="post" action="volunteer.php#apply" novalidate>
        <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">

        <h3>Your Details</h3>
        <div class="form-row">
          <div class="field">
            <label>Full Name</label>
            <input value="<?php echo h($me["first_name"] . " " . $me["last_name"]); ?>" disabled style="background:#f1ece1;color:var(--muted)">
          </div>
          <div class="field">
            <label>Email</label>
            <input value="<?php echo h($me["email"]); ?>" disabled style="background:#f1ece1;color:var(--muted)">
          </div>
        </div>
        <p class="hint" style="margin:-10px 0 20px">Pulled from your account — update these on your account settings, not here.</p>

        <h3>How You'd Like to Help</h3>
        <div class="field">
          <label for="areas">Areas you can help in <span style="color:#e0553f">*</span></label>
          <input id="areas" name="areas" required autocomplete="off" list="areaOptions" value="<?php echo h($old["areas"]); ?>" placeholder="e.g. Observatory, Woodstock, Rondebosch">
          <datalist id="areaOptions">
            <option value="Observatory, Cape Town"><option value="Woodstock, Cape Town"><option value="Rondebosch, Cape Town">
            <option value="Claremont, Cape Town"><option value="Mowbray, Cape Town"><option value="Sea Point, Cape Town">
          </datalist>
          <span class="hint">You can list more than one area, separated by commas</span>
        </div>

        <div class="field">
          <label for="availability">Availability <span style="color:#e0553f">*</span></label>
          <select id="availability" name="availability" required>
            <option value="">Select your availability</option>
            <?php foreach (["Weekday mornings", "Weekday afternoons", "Weekday evenings", "Weekends", "Flexible / anytime"] as $opt): ?>
              <option <?php echo $old["availability"] === $opt ? "selected" : ""; ?>><?php echo h($opt); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="skills">Skills or interests <span class="hint">Optional</span></label>
          <textarea id="skills" name="skills" placeholder="e.g. Driving, first aid, gardening, a listening ear."><?php echo h($old["skills"]); ?></textarea>
        </div>

        <h3 style="margin-top:6px">Emergency Contact</h3>
        <p class="hint" style="margin:-8px 0 16px">Kept private — only used if we're ever unable to reach you during a task.</p>
        <div class="form-row">
          <div class="field">
            <label for="emergencyName">Contact name <span style="color:#e0553f">*</span></label>
            <input id="emergencyName" name="emergencyName" required value="<?php echo h($old["emergencyName"]); ?>" placeholder="Full name">
          </div>
          <div class="field">
            <label for="emergencyPhone">Contact phone <span style="color:#e0553f">*</span></label>
            <input id="emergencyPhone" name="emergencyPhone" type="tel" required value="<?php echo h($old["emergencyPhone"]); ?>" placeholder="Phone number">
          </div>
        </div>

        <div class="field">
          <label for="motivation">Why would you like to volunteer? <span class="hint">Optional</span></label>
          <textarea id="motivation" name="motivation" placeholder="A sentence or two is plenty."><?php echo h($old["motivation"]); ?></textarea>
        </div>

        <div class="field" style="display:flex;align-items:flex-start;gap:9px">
          <input id="agreeRules" name="agreeRules" type="checkbox" required style="width:auto;margin-top:3px" <?php echo $existing ? "checked" : ""; ?>>
          <label for="agreeRules" style="margin:0;font-weight:500">I understand I may accept one active task at a time, with a fair-use guideline of up to three tasks a day, and I can cancel penalty-free within two hours of accepting.</label>
        </div>

        <div class="step-actions">
          <a href="account.php" class="btn btn-ghost">Cancel</a>
          <button type="submit" class="btn btn-orange"><?php echo $existing ? "Save Changes" : "Submit Application"; ?> <i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <p class="form-note">Saved to the <code>volunteers</code> table in MySQL, linked to your account.</p>
      </form>

      <aside class="request-side">
        <div class="side-card">
          <h4>Why Volunteer With Us?</h4>
          <ol class="mini-steps">
            <li><span>1</span><div><strong>Help Others</strong><small>Make a real difference in someone's life.</small></div></li>
            <li><span>2</span><div><strong>Flexible Time</strong><small>Choose when and how you want to help.</small></div></li>
            <li><span>3</span><div><strong>Safe &amp; Supported</strong><small>We ensure a safe, supportive environment.</small></div></li>
          </ol>
        </div>
        <div class="side-card highlight">
          <h4>Need Help?</h4>
          <p>Contact us if you have any questions about volunteering.</p>
          <a class="btn btn-ghost" href="contact.php" style="width:100%"><i class="fa-solid fa-headset"></i> Contact Support</a>
        </div>
      </aside>
    </div>
    <?php endif; ?>
  </div>
</section>

<div class="cta">
  <div class="cta-icon"><i class="fa-regular fa-heart"></i></div>
  <div class="cta-copy"><strong>Ready to start your journey?</strong><span>Join hundreds of volunteers helping neighbours every day.</span></div>
  <a class="btn btn-orange" href="<?php echo logged_in() ? '#apply' : 'signup.php?next=volunteer'; ?>"><?php echo $existing ? "Update Your Application" : "Sign Up to Volunteer"; ?> <i class="fa-solid fa-arrow-right"></i></a>
</div>

</main>



<?php include __DIR__ . "/partials/footer.php"; ?>
</body>
</html>
