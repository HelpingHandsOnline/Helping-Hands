<?php
require __DIR__ . "/config.php";
$activePage = "contact";
$old = ["name" => "", "email" => "", "subject" => "", "messageText" => ""];
$errors = [];

if (logged_in()) {
    $me = user();
    $old["name"] = $me["first_name"] . " " . $me["last_name"];
    $old["email"] = $me["email"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verify_csrf();
    $old["name"]        = trim($_POST["name"] ?? "");
    $old["email"]       = trim($_POST["email"] ?? "");
    $old["subject"]     = trim($_POST["subject"] ?? "");
    $old["messageText"] = trim($_POST["messageText"] ?? "");
    $consent            = isset($_POST["consent"]);

    if ($old["name"] === "") $errors[] = "Please enter your name.";
    if ($old["email"] === "" || !filter_var($old["email"], FILTER_VALIDATE_EMAIL)) $errors[] = "Please enter a valid email address.";
    if ($old["subject"] === "") $errors[] = "Please choose a subject.";
    if (strlen($old["messageText"]) < 10) $errors[] = "Please write at least 10 characters.";
    if (!$consent) $errors[] = "Please confirm before sending.";

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([logged_in() ? user()["id"] : null, $old["name"], $old["email"], $old["subject"], $old["messageText"]]);
        flash("success", "Thanks — your message has been saved. We'll be in touch within 24 hours.");
        redirect("contact.php");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Contact Us</title>
<meta name="description" content="Reach out to the Helping Hands Community Assist team with any questions, feedback, or suggestions. We're here to help.">
<meta property="og:type" content="website">
<meta property="og:title" content="Helping Hands | Contact Us">
<meta property="og:description" content="Reach out to the Helping Hands Community Assist team with any questions, feedback, or suggestions. We're here to help.">
<meta property="og:image" content="logo.png">
<meta property="og:site_name" content="Helping Hands Community Assist">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Helping Hands | Contact Us">
<meta name="twitter:description" content="Reach out to the Helping Hands Community Assist team with any questions, feedback, or suggestions. We're here to help.">
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="contact.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="page-hero contact-hero">
  <div class="container hero-grid">
    <div class="hero-copy">
      <span class="eyebrow">GET IN TOUCH</span>
      <h1>Contact <span>Us.</span></h1>
      <p>We'd love to hear from you! Reach out with any questions, feedback, or suggestions — we're here to help.</p>
      <div class="hero-note">
        <span><i class="fa-solid fa-clock"></i> We reply within 24 hours</span>
        <span><i class="fa-solid fa-lock"></i> Your details stay private</span>
      </div>
    </div>
    <div class="hero-image-wrap with-orbit">
      <img class="hero-image" src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?auto=format&fit=crop&w=1100&q=88" alt="A phone, envelope and location pin icons on a desk representing ways to get in touch">
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="urgent-banner">
      <i class="fa-solid fa-headset"></i>
      <div>
        <strong>Need immediate help?</strong>
        <span>For urgent assistance, please call our helpline directly rather than using the form below.</span>
      </div>
      <a class="btn btn-orange" href="tel:+27123456790">Call Now <i class="fa-solid fa-phone"></i></a>
    </div>

    <div class="contact-grid">
      <div class="info-card">
        <h2>Get in Touch</h2>

        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
          <div>
            <small>Phone</small>
            <strong>(012) 345 6790</strong>
            <span>Mon – Fri, 9:00 AM – 5:00 PM</span>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-regular fa-envelope"></i></div>
          <div>
            <small>Email</small>
            <strong>info@helpinghands.org</strong>
            <span>We reply within 24 hours</span>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <small>Address</small>
            <strong>123 Community Way</strong>
            <span>Yourtown, ST 12345</span>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-regular fa-clock"></i></div>
          <div>
            <small>Office Hours</small>
            <strong>Monday – Friday</strong>
            <span>9:00 AM – 5:00 PM</span>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-brands fa-whatsapp"></i></div>
          <div>
            <small>WhatsApp</small>
            <strong>(012) 345 6790</strong>
            <span>Quick questions, 7 days a week</span>
          </div>
        </div>

        <div class="socials">
          <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook (opens in a new tab)"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram (opens in a new tab)"><i class="fa-brands fa-instagram"></i></a>
          <a href="https://twitter.com/" target="_blank" rel="noopener" aria-label="Twitter (opens in a new tab)"><i class="fa-brands fa-twitter"></i></a>
          <a href="https://www.youtube.com/" target="_blank" rel="noopener" aria-label="YouTube (opens in a new tab)"><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>

      <div class="form-card">
        <h2>Send Us a Message</h2>
        <p>Fill in the form below and a real person from our team will get back to you.</p>
        <form method="post" action="contact.php" novalidate>
          <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">
          <?php if ($errors): ?>
            <div class="form-alert show"><?php echo implode("<br>", array_map("h", $errors)); ?></div>
          <?php endif; ?>
          <div class="form-row">
            <div class="field">
              <label for="name">Your Name <span>*</span></label>
              <input id="name" name="name" type="text" required autocomplete="name" value="<?php echo h($old["name"]); ?>" placeholder="Enter your name">
              <span class="field-error">Please enter your name.</span>
            </div>
            <div class="field">
              <label for="email">Email Address <span>*</span></label>
              <input id="email" name="email" type="email" required autocomplete="email" value="<?php echo h($old["email"]); ?>" placeholder="Enter your email">
              <span class="field-error">Please enter a valid email address.</span>
            </div>
          </div>
          <div class="field">
            <label for="subject">Subject <span>*</span></label>
            <select id="subject" name="subject" required>
              <option value="">Select a subject</option>
              <?php foreach (["General Enquiry", "Requesting Help", "Volunteering", "Account & Login Issue", "Feedback or Suggestion", "Report a Concern"] as $opt): ?>
                <option <?php echo $old["subject"] === $opt ? "selected" : ""; ?>><?php echo h($opt); ?></option>
              <?php endforeach; ?>
            </select>
            <span class="field-error">Please choose a subject.</span>
          </div>
          <div class="field">
            <label for="messageText">Message <span>*</span> <span class="hint">Minimum 10 characters</span></label>
            <textarea id="messageText" name="messageText" required minlength="10" placeholder="Type your message here..."><?php echo h($old["messageText"]); ?></textarea>
            <span class="field-error">Please write at least 10 characters.</span>
          </div>
          <div class="field" style="display:flex;align-items:flex-start;gap:9px">
            <input id="consent" name="consent" type="checkbox" required style="width:auto;margin-top:3px">
            <label for="consent" style="margin:0;font-weight:500">I agree that Helping Hands may contact me about this message.</label>
            <span class="field-error">Please confirm before sending.</span>
          </div>
          <button type="submit" class="btn btn-orange" style="width:100%;padding:13px;font-size:12px">Send Message <i class="fa-solid fa-paper-plane"></i></button>
          <p class="form-note">Saved to the <code>contact_messages</code> table in MySQL — no real email is sent in this demo.</p>
        </form>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">WHO TO CONTACT</span>
      <h2>Reach the right team</h2>
      <p>Some enquiries are best sent directly to the team that handles them.</p>
    </div>
    <div class="dept-grid">
      <div class="dept-card">
        <i class="fa-solid fa-comments"></i>
        <h3>General Enquiries</h3>
        <p>Questions about the platform or how it works.</p>
        <a href="mailto:hello@helpinghands.org">hello@helpinghands.org</a>
      </div>
      <div class="dept-card">
        <i class="fa-solid fa-hands-holding-circle"></i>
        <h3>Volunteering</h3>
        <p>Questions about signing up or managing tasks.</p>
        <a href="mailto:volunteer@helpinghands.org">volunteer@helpinghands.org</a>
      </div>
      <div class="dept-card">
        <i class="fa-solid fa-shield-halved"></i>
        <h3>Safeguarding &amp; Trust</h3>
        <p>Report a safety concern about a request or task.</p>
        <a href="mailto:trust@helpinghands.org">trust@helpinghands.org</a>
      </div>
      <div class="dept-card">
        <i class="fa-solid fa-newspaper"></i>
        <h3>Media &amp; Partnerships</h3>
        <p>Press enquiries and community partnerships.</p>
        <a href="mailto:media@helpinghands.org">media@helpinghands.org</a>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">QUICK HELP</span>
      <h2>Find quick answers to common questions</h2>
    </div>
    <div class="grid4">
      <a class="category" href="request.php">
        <div class="category-icon"><i class="fa-regular fa-circle-question"></i></div>
        <h3>How to Request Help</h3>
        <p>Step-by-step guidance on submitting a request.</p>
        <span class="link">Learn more →</span>
      </a>
      <a class="category" href="volunteer.php">
        <div class="category-icon"><i class="fa-regular fa-heart"></i></div>
        <h3>How to Volunteer</h3>
        <p>Everything to get started as a volunteer.</p>
        <span class="link">Learn more →</span>
      </a>
      <a class="category" href="login.php">
        <div class="category-icon"><i class="fa-regular fa-user"></i></div>
        <h3>Account &amp; Login Help</h3>
        <p>Trouble signing in or creating an account.</p>
        <span class="link">Learn more →</span>
      </a>
      <a class="category" href="resources.php">
        <div class="category-icon"><i class="fa-regular fa-comment-dots"></i></div>
        <h3>General Questions</h3>
        <p>Browse our full resource library.</p>
        <span class="link">Learn more →</span>
      </a>
    </div>
  </div>
</section>

<section class="section map-section" style="padding-top:0">
  <div class="container map-grid">
    <div class="find-copy">
      <span class="eyebrow">VISIT US</span>
      <h2>Find us</h2>
      <p>Our community office is open to walk-ins during office hours — come say hello, ask a question, or drop off a donation.</p>
      <div class="find-list">
        <div class="find-item">
          <div class="find-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div><strong>123 Community Way</strong><span>Yourtown, ST 12345</span></div>
        </div>
        <div class="find-item">
          <div class="find-icon"><i class="fa-regular fa-clock"></i></div>
          <div><strong>Monday – Friday</strong><span>9:00 AM – 5:00 PM</span></div>
        </div>
        <div class="find-item">
          <div class="find-icon"><i class="fa-solid fa-car"></i></div>
          <div><strong>Parking on-site</strong><span>Free visitor parking available</span></div>
        </div>
      </div>
    </div>
    <div class="map-card">
      <div class="map-label"><strong>Helping Hands HQ</strong><span>123 Community Way</span></div>
      <iframe title="Map showing Helping Hands office location" loading="lazy" src="https://www.google.com/maps?q=Cape+Town&output=embed"></iframe>
      <div class="map-actions">
        <a class="btn btn-orange" href="https://www.google.com/maps?q=Cape+Town" target="_blank" rel="noopener">Get Directions <i class="fa-solid fa-diamond-turn-right"></i></a>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container" style="max-width:1000px">
    <div class="section-title reveal">
      <span class="eyebrow">AFTER YOU SEND A MESSAGE</span>
      <h2>What happens next</h2>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div>
        <h3>We receive your message</h3>
        <p>Your message reaches the right department automatically, based on the subject you choose.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <h3>A real person reviews it</h3>
        <p>One of our community coordinators reads and responds — no bots, no auto-replies.</p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <h3>You hear back within 24 hours</h3>
        <p>We reply by email, with next steps or an answer to your question.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" style="background:#fff8ee">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">STILL UNSURE?</span>
      <h2>Contact FAQ</h2>
    </div>
    <div class="faq-list">
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">How quickly will I get a reply? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Most messages are answered within 24 hours on working days. Urgent safety concerns are prioritised — please call the helpline for anything time-sensitive.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">Can I visit in person without an appointment? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Yes, our office welcomes walk-ins during office hours. For longer discussions, emailing ahead helps us make sure the right person is available.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">I want to report a safety concern — what do I do? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Email trust@helpinghands.org directly or select "Report a Concern" in the form above. Safeguarding messages are reviewed as a priority.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">Do you offer support in languages other than English? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Yes — our team can assist in English and Afrikaans, with isiXhosa support available on request.</p></div>
      </div>
    </div>
  </div>
</section>

</main>



<?php include __DIR__ . "/partials/footer.php"; ?>
</body>
</html>
