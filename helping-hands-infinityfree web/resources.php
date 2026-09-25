<?php
require __DIR__ . "/config.php";
$activePage = "resources";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newsletterEmail"])) {
    verify_csrf();
    $email = trim($_POST["newsletterEmail"]);
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)");
        $stmt->execute([$email]);
        flash("success", "Thanks for subscribing! You'll hear from us with community updates.");
    } else {
        flash("error", "Please enter a valid email address to subscribe.");
    }
    redirect("resources.php#stay-connected");
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Resources</title>
<meta name="description" content="Guides, safety tips and local support directories from Helping Hands Community Assist — free resources for neighbours and volunteers.">
<meta property="og:type" content="website">
<meta property="og:title" content="Helping Hands | Resources">
<meta property="og:description" content="Guides, safety tips and local support directories from Helping Hands Community Assist — free resources for neighbours and volunteers.">
<meta property="og:image" content="logo.png">
<meta property="og:site_name" content="Helping Hands Community Assist">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Helping Hands | Resources">
<meta name="twitter:description" content="Guides, safety tips and local support directories from Helping Hands Community Assist — free resources for neighbours and volunteers.">
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="resources.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="page-hero hero">
  <div class="container hero-grid">
    <div class="hero-copy">
      <span class="eyebrow">HELPFUL RESOURCES</span>
      <h1>Resources<br>for <span>our community.</span></h1>
      <p>Guides, safety tips and local directories for everything from requesting help to volunteering safely. Everything here is free, kept up to date, and written in plain language.</p>
      <div class="hero-actions">
        <a class="btn btn-orange" href="#featured">Explore Resources <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-ghost" href="contact.php">Ask Us Anything</a>
      </div>
      <div class="hero-note">
        <span><i class="fa-solid fa-book-open"></i> 40+ practical guides</span>
        <span><i class="fa-solid fa-people-group"></i> Community reviewed</span>
        <span><i class="fa-solid fa-heart"></i> Always free</span>
      </div>
    </div>
    <div class="hero-image-wrap">
      <img class="hero-image" src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=1200&q=88" alt="A volunteer sitting with an older neighbour, going through a printed guide together">
      <div class="hero-float">
        <i class="fa-solid fa-heart"></i>
        <span><strong>Support that starts local</strong><small>Information for everyday needs</small></span>
      </div>
    </div>
  </div>
</section>

<div class="premium-strip">
  <div class="container strip-inner">
    <span class="strip-point"><i class="fa-solid fa-circle-check"></i> Simple information</span>
    <span class="strip-point"><i class="fa-solid fa-shield-heart"></i> Safety first</span>
    <span class="strip-point"><i class="fa-solid fa-users"></i> For neighbours &amp; volunteers</span>
    <span class="strip-point"><i class="fa-solid fa-arrow-right"></i> Always one step closer to help</span>
  </div>
</div>

<section class="section categories-wrap">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">BROWSE BY TOPIC</span>
      <h2>Resource categories</h2>
      <p>Find useful information based on what you need today.</p>
    </div>
    <div class="grid4">
      <a class="category" href="#featured" data-jump="neighbours">
        <div class="category-icon"><i class="fa-solid fa-people-roof"></i></div>
        <h3>For Neighbours</h3>
        <p>Guides and tips for people who need support.</p>
        <span class="link">Explore →</span>
      </a>
      <a class="category" href="#featured" data-jump="volunteers">
        <div class="category-icon"><i class="fa-solid fa-hands-holding-circle"></i></div>
        <h3>For Volunteers</h3>
        <p>Everything you need to make your time count.</p>
        <span class="link">Explore →</span>
      </a>
      <a class="category" href="#featured" data-jump="safety">
        <div class="category-icon"><i class="fa-solid fa-shield-heart"></i></div>
        <h3>Safety &amp; Wellbeing</h3>
        <p>Stay safe and informed with trusted advice.</p>
        <span class="link">Explore →</span>
      </a>
      <a class="category" href="#featured" data-jump="guides">
        <div class="category-icon"><i class="fa-solid fa-newspaper"></i></div>
        <h3>Community Guides</h3>
        <p>Local information and downloadable guides.</p>
        <span class="link">Explore →</span>
      </a>
      <a class="category" href="#featured" data-jump="food">
        <div class="category-icon"><i class="fa-solid fa-bowl-food"></i></div>
        <h3>Food &amp; Financial Help</h3>
        <p>Pantries, grants and emergency assistance.</p>
        <span class="link">Explore →</span>
      </a>
      <a class="category" href="#featured" data-jump="health">
        <div class="category-icon"><i class="fa-solid fa-hand-holding-medical"></i></div>
        <h3>Health &amp; Mental Wellbeing</h3>
        <p>Support lines, clinics and grounding techniques.</p>
        <span class="link">Explore →</span>
      </a>
      <a class="category" href="#featured" data-jump="volunteers">
        <div class="category-icon"><i class="fa-solid fa-clipboard-check"></i></div>
        <h3>Safety Checklists</h3>
        <p>Printable checklists for visits and check-ins.</p>
        <span class="link">Explore →</span>
      </a>
      <a class="category" href="#featured" data-jump="neighbours">
        <div class="category-icon"><i class="fa-solid fa-circle-info"></i></div>
        <h3>How Community Assist Works</h3>
        <p>What happens after you submit a request.</p>
        <span class="link">Explore →</span>
      </a>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="stats-band">
      <div class="stat"><strong><span>40</span>+</strong><small>Guides &amp; articles</small></div>
      <div class="stat"><strong>1,200+</strong><small>Neighbours helped</small></div>
      <div class="stat"><strong>350+</strong><small>Active volunteers</small></div>
      <div class="stat"><strong>24h</strong><small>Average response time</small></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">FIND SOMETHING FAST</span>
      <h2>Search our resources</h2>
      <p>Type a topic such as volunteering, safety, seniors or food support — or filter by category below.</p>
    </div>
    <div class="resource-toolbar">
      <form class="resource-search" id="resourceSearch" role="search">
        <label for="searchInput" class="sr-only" style="position:absolute;left:-9999px">Search resources</label>
        <input id="searchInput" list="resourceSuggestions" autocomplete="off" placeholder="Search resources...">
        <datalist id="resourceSuggestions">
          <option value="volunteering">
          <option value="safety checklist">
          <option value="senior care">
          <option value="food support">
          <option value="mental health">
          <option value="request help">
          <option value="local services">
        </datalist>
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
      </form>
      <div class="filter-chips" role="group" aria-label="Filter resources by category">
        <button class="chip active" data-category="all">All</button>
        <button class="chip" data-category="neighbours">For Neighbours</button>
        <button class="chip" data-category="volunteers">For Volunteers</button>
        <button class="chip" data-category="safety">Safety</button>
        <button class="chip" data-category="guides">Community Guides</button>
        <button class="chip" data-category="food">Food &amp; Financial</button>
        <button class="chip" data-category="health">Health &amp; Wellbeing</button>
      </div>
    </div>
  </div>
</section>

<section class="section" id="featured" style="padding-top:0">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">LEARN &amp; GROW</span>
      <h2>Featured resources</h2>
      <p>Simple information designed to help you take the next step.</p>
    </div>
    <div class="resources-grid" id="resourceGrid">

      <article class="resource-card" data-category="neighbours" data-search="request help guide neighbours support">
        <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=700&q=88" alt="Person filling out a request form at a desk">
        <div class="resource-body">
          <span class="tag">GUIDE</span>
          <h3>How to Request Help</h3>
          <p>A simple step-by-step guide to getting the support you need, with no paperwork or fees.</p>
          <button class="card-btn" onclick="showResource('How to Request Help','GUIDE')">Read More</button>
        </div>
      </article>

      <article class="resource-card" data-category="volunteers" data-search="volunteer volunteers best practices community">
        <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=700&q=88" alt="A small group of volunteers packing boxes together">
        <div class="resource-body">
          <span class="tag">VOLUNTEERING</span>
          <h3>Volunteer Best Practices</h3>
          <p>Practical tips for making a positive difference safely and respectfully.</p>
          <button class="card-btn orange" onclick="showResource('Volunteer Best Practices','VOLUNTEERING','6GAnfNVQtbQ')">Watch Video</button>
        </div>
      </article>

      <article class="resource-card" data-category="health" data-search="senior care older person wellbeing safety health">
        <img src="https://images.unsplash.com/photo-1559234938-b60fff04894d?auto=format&fit=crop&w=700&q=88" alt="An older person smiling while using a tablet">
        <div class="resource-body">
          <span class="tag">WELLBEING</span>
          <h3>Senior Care Guide</h3>
          <p>Helpful, dignity-first ideas for supporting older neighbours day to day.</p>
          <button class="card-btn" onclick="showResource('Senior Care Guide','WELLBEING')">Download PDF</button>
        </div>
      </article>

      <article class="resource-card" data-category="guides" data-search="local support services community cape town directory">
        <img src="https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=700&q=88" alt="A quiet residential street in a Cape Town neighbourhood">
        <div class="resource-body">
          <span class="tag">LOCAL</span>
          <h3>Local Support Services</h3>
          <p>A directory of clinics, shelters and legal aid organisations near you.</p>
          <button class="card-btn orange" onclick="showResource('Local Support Services','LOCAL')">View List</button>
        </div>
      </article>

      <article class="resource-card" data-category="safety" data-search="volunteer safety checklist visits check-in">
        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=700&q=88" alt="A checklist and pen on a clipboard">
        <div class="resource-body">
          <span class="tag">SAFETY</span>
          <h3>Volunteer Safety Checklist</h3>
          <p>A printable checklist to run through before every home visit or check-in.</p>
          <button class="card-btn" onclick="showResource('Volunteer Safety Checklist','SAFETY')">Download PDF</button>
        </div>
      </article>

      <article class="resource-card" data-category="neighbours" data-search="understanding community assist how it works process">
        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=700&q=88" alt="Two people having a friendly conversation outdoors">
        <div class="resource-body">
          <span class="tag">GUIDE</span>
          <h3>Understanding Community Assist</h3>
          <p>How requests are verified, matched with a volunteer, and followed up.</p>
          <button class="card-btn orange" onclick="showResource('Understanding Community Assist','GUIDE')">Read More</button>
        </div>
      </article>

      <article class="resource-card" data-category="food" data-search="food grocery support pantry vouchers emergency">
        <img src="https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=700&q=88" alt="Crates of fresh produce ready for distribution">
        <div class="resource-body">
          <span class="tag">FOOD &amp; FINANCIAL</span>
          <h3>Food &amp; Grocery Support</h3>
          <p>Where to find pantries, meal deliveries and emergency food parcels.</p>
          <button class="card-btn" onclick="showResource('Food & Grocery Support','FOOD & FINANCIAL')">View List</button>
        </div>
      </article>

      <article class="resource-card" data-category="health" data-search="mental health wellbeing counselling support lines">
        <img src="https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=700&q=88" alt="A calm, quiet park bench under trees">
        <div class="resource-body">
          <span class="tag">WELLBEING</span>
          <h3>Mental Health &amp; Wellbeing</h3>
          <p>Free counselling lines, peer groups and simple grounding techniques.</p>
          <button class="card-btn orange" onclick="showResource('Mental Health & Wellbeing','WELLBEING')">Read More</button>
        </div>
      </article>

    </div>
    <div class="filter-empty" id="filterEmpty">No matching resources yet. <a href="contact.php" style="color:#ff7900;font-weight:800">Contact us</a> and we'll help you find the right information.</div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="image-story">
      <div class="story-main">
        <img src="https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?auto=format&fit=crop&w=1200&q=88" alt="Volunteers working together outdoors on a community project">
        <div class="story-overlay">
          <span>COMMUNITY IN ACTION</span>
          <h3>Small acts can create a stronger neighbourhood.</h3>
          <p>Resources are most powerful when they lead to real support and connection.</p>
        </div>
      </div>
      <div class="story-stack">
        <div class="story-small">
          <img src="https://images.unsplash.com/photo-1556484687-30636164638b?auto=format&fit=crop&w=800&q=88" alt="Two volunteers helping carry supplies">
          <div class="story-overlay"><span>FOR VOLUNTEERS</span><h3>Give your time with confidence.</h3></div>
        </div>
        <div class="story-small">
          <img src="https://images.unsplash.com/photo-1516307365426-bea591f05011?auto=format&fit=crop&w=800&q=88" alt="Neighbours chatting warmly on a doorstep">
          <div class="story-overlay"><span>FOR NEIGHBOURS</span><h3>Find the support you need.</h3></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" style="background:#fff8ee">
  <div class="container">
    <div class="section-title reveal">
      <span class="eyebrow">COMMON QUESTIONS</span>
      <h2>Resources FAQ</h2>
      <p>Quick answers about how our resources work.</p>
    </div>
    <div class="faq-list">
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">Are these resources really free? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Yes. Every guide, checklist and directory on this page is free to read, download and share — there is no sign-up required to view them.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">How often are guides updated? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Our volunteer coordinators review each resource at least every three months, and sooner whenever a local service or contact number changes.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">Can I suggest a resource or correction? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Absolutely — <a href="contact.php" style="color:#ff7900;font-weight:800">contact us</a> with the subject "Feedback" and let us know what's missing or out of date.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">I can't find what I need — what now? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Use the search bar above, or send us a message. A real person will point you to the right guide, service or next step within one working day.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q" aria-expanded="false">Are the guides available in other languages? <i class="fa-solid fa-plus"></i></button>
        <div class="faq-a"><p>Our core safety and request guides are available in English and Afrikaans, with isiXhosa translations being added. Ask our team if you need another language.</p></div>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0" id="stay-connected">
  <div class="container">
    <div class="newsletter">
      <div class="newsletter-copy">
        <span>STAY CONNECTED</span>
        <h3>Useful resources, straight to you.</h3>
        <p>Get occasional community tips, new guides and helpful updates. No spam, unsubscribe anytime.</p>
      </div>
      <form class="newsletter-form" method="post" action="resources.php#stay-connected">
        <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">
        <label for="newsletterEmail" class="sr-only" style="position:absolute;left:-9999px">Email address</label>
        <input id="newsletterEmail" name="newsletterEmail" type="email" required placeholder="Your email address">
        <button type="submit">Subscribe</button>
      </form>
    </div>
  </div>
</section>

<div class="cta">
  <div class="cta-icon"><i class="fa-regular fa-envelope"></i></div>
  <div class="cta-copy"><strong>Can't find what you need?</strong><span>Contact us and we'll help you find the right resource or next step.</span></div>
  <a class="btn btn-orange" href="contact.php">Contact Us <i class="fa-solid fa-arrow-right"></i></a>
</div>

</main>



<?php include __DIR__ . "/partials/footer.php"; ?>

<div class="modal-backdrop" id="resourceModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal-card" id="modalCard">
    <button class="modal-close" id="modalClose" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    <span class="tag" id="modalTag">RESOURCE</span>
    <h3 id="modalTitle">Resource title</h3>
    <div class="video-embed" id="modalVideoWrap" style="display:none;margin-bottom:16px">
      <iframe id="modalVideo" src="" title="Resource video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <p id="modalBody">Details go here.</p>
    <a class="btn btn-orange" href="contact.php">Ask a question about this <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</div>

<script src="resources.js"></script>
</body>
</html>
