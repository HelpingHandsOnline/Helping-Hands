<?php
require __DIR__ . "/config.php";
require_login("request");
$me = user();

$errors = [];
$old = ["category" => "", "location" => "", "prefDate" => "", "prefTime" => "", "notes" => "", "contactMethod" => "Phone call"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verify_csrf();
    $old["category"]      = trim($_POST["category"] ?? "");
    $old["location"]      = trim($_POST["location"] ?? "");
    $old["prefDate"]      = trim($_POST["prefDate"] ?? "");
    $old["prefTime"]      = trim($_POST["prefTime"] ?? "");
    $old["notes"]         = trim($_POST["notes"] ?? "");
    $old["contactMethod"] = trim($_POST["contactMethod"] ?? "Phone call");
    $agree                = isset($_POST["agreeRules"]);

    if ($old["category"] === "") $errors[] = "Please choose a category.";
    if ($old["location"] === "") $errors[] = "Please tell us where help is needed.";
    if ($old["prefDate"] === "") $errors[] = "Please choose a preferred date.";
    if ($old["prefTime"] === "") $errors[] = "Please choose a preferred time.";
    if (!$agree) $errors[] = "Please confirm you understand the request rules before submitting.";

    if (!$errors) {
        $stmt = $pdo->prepare(
            "INSERT INTO requests (user_id, category, location, preferred_date, preferred_time, notes, contact_method, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')"
        );
        $stmt->execute([$me["id"], $old["category"], $old["location"], $old["prefDate"], $old["prefTime"], $old["notes"], $old["contactMethod"]]);
        flash("success", "Your request has been submitted! A local volunteer will be notified.");
        redirect("account.php");
    }
}

$activePage = "request";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Request Help</title>
<meta name="description" content="Tell us what you need and when — we'll connect you with a trusted local volunteer.">
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="request.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="section" style="padding-bottom:0">
  <div class="container section-title">
    <h2 style="font-size:38px">Request Help</h2>
    <p style="max-width:520px;margin:0 auto">Tell us what you need and when. We'll connect you with a trusted volunteer — saved straight to your account.</p>
  </div>
</section>

<section class="section">
  <div class="container">

    <?php if ($errors): ?>
      <div class="form-alert show" style="max-width:900px;margin:0 auto 20px">
        <?php echo implode("<br>", array_map("h", $errors)); ?>
      </div>
    <?php endif; ?>

    <div class="stepper" role="list" aria-label="Request progress">
      <div class="step-node active" data-step="1" role="listitem"><span class="dot">1</span><small>Request Details</small></div>
      <div class="step-line"></div>
      <div class="step-node" data-step="2" role="listitem"><span class="dot">2</span><small>Additional Info</small></div>
      <div class="step-line"></div>
      <div class="step-node" data-step="3" role="listitem"><span class="dot">3</span><small>Review &amp; Submit</small></div>
    </div>

    <div class="request-layout">
      <form class="request-card" id="requestForm" method="post" novalidate>
        <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">
        <input type="hidden" name="category" id="categoryInput" value="<?php echo h($old["category"]); ?>">

        <!-- STEP 1 -->
        <div class="request-step active" data-step="1">
          <h3>What kind of help do you need? <span style="color:#e0553f">*</span></h3>
          <div class="option-grid" id="categoryGrid" role="group" aria-label="Choose a help category">
            <?php
            $categories = [
                "Grocery Shopping" => "fa-cart-shopping", "Prescription Pickup" => "fa-prescription-bottle-medical",
                "Medical Transport" => "fa-car-side", "Household Tasks" => "fa-broom",
                "Companionship" => "fa-people-arrows", "Other" => "fa-ellipsis",
            ];
            foreach ($categories as $label => $icon):
                $selected = $old["category"] === $label ? " selected" : "";
            ?>
              <button type="button" class="option-tile<?php echo $selected; ?>" data-value="<?php echo h($label); ?>"><i class="fa-solid <?php echo $icon; ?>"></i><span><?php echo h($label); ?></span></button>
            <?php endforeach; ?>
          </div>
          <span class="field-error" id="categoryError">Please choose a category.</span>

          <div class="field" style="margin-top:22px">
            <label for="location">Location <span style="color:#e0553f">*</span></label>
            <input id="location" name="location" required autocomplete="off" list="areaOptions" value="<?php echo h($old["location"]); ?>" placeholder="Enter your address or area, e.g. Observatory, Cape Town">
            <datalist id="areaOptions">
              <option value="Observatory, Cape Town"><option value="Woodstock, Cape Town"><option value="Rondebosch, Cape Town">
              <option value="Claremont, Cape Town"><option value="Mowbray, Cape Town"><option value="Sea Point, Cape Town">
              <option value="Gardens, Cape Town"><option value="Salt River, Cape Town">
            </datalist>
            <span class="field-error">Please tell us where help is needed.</span>
          </div>

          <div class="step-actions">
            <a href="account.php" class="btn btn-ghost">Cancel</a>
            <button type="button" class="btn btn-orange next-step">Next Step <i class="fa-solid fa-arrow-right"></i></button>
          </div>
        </div>

        <!-- STEP 2 -->
        <div class="request-step" data-step="2">
          <div class="form-row">
            <div class="field">
              <label for="prefDate">Preferred Date <span style="color:#e0553f">*</span></label>
              <input id="prefDate" name="prefDate" type="date" required value="<?php echo h($old["prefDate"]); ?>">
              <span class="field-error">Please choose a date.</span>
            </div>
            <div class="field">
              <label for="prefTime">Preferred Time <span style="color:#e0553f">*</span></label>
              <input id="prefTime" name="prefTime" type="time" required value="<?php echo h($old["prefTime"]); ?>">
              <span class="field-error">Please choose a time.</span>
            </div>
          </div>
          <div class="field">
            <label for="notes">Additional Notes <span class="hint">Optional</span></label>
            <textarea id="notes" name="notes" placeholder="Please add any extra details about your request..."><?php echo h($old["notes"]); ?></textarea>
          </div>
          <div class="field">
            <label for="contactMethod">Preferred contact method</label>
            <select id="contactMethod" name="contactMethod">
              <option <?php echo $old["contactMethod"] === "Phone call" ? "selected" : ""; ?>>Phone call</option>
              <option <?php echo $old["contactMethod"] === "SMS / WhatsApp" ? "selected" : ""; ?>>SMS / WhatsApp</option>
              <option <?php echo $old["contactMethod"] === "Email" ? "selected" : ""; ?>>Email</option>
            </select>
          </div>
          <div class="step-actions">
            <button type="button" class="btn btn-ghost prev-step">Back</button>
            <button type="button" class="btn btn-orange next-step">Next Step <i class="fa-solid fa-arrow-right"></i></button>
          </div>
        </div>

        <!-- STEP 3 -->
        <div class="request-step" data-step="3">
          <h3>Review your request</h3>
          <div class="review-list" id="reviewList"></div>
          <div class="field" style="display:flex;align-items:flex-start;gap:9px;margin-top:18px">
            <input id="agreeRules" name="agreeRules" type="checkbox" required style="width:auto;margin-top:3px">
            <label for="agreeRules" style="margin:0;font-weight:500">I understand I may have only one active request at a time, and that my contact details will only be shared once a volunteer accepts.</label>
          </div>
          <span class="field-error" id="agreeError">Please confirm before submitting.</span>
          <div class="step-actions">
            <button type="button" class="btn btn-ghost prev-step">Back</button>
            <button type="submit" class="btn btn-orange">Submit Request <i class="fa-solid fa-paper-plane"></i></button>
          </div>
          <p class="form-note">Saved to the <code>requests</code> table in MySQL, linked to your account.</p>
        </div>

      </form>

      <aside class="request-side">
        <div class="side-card">
          <h4>How It Works</h4>
          <ol class="mini-steps">
            <li><span>1</span><div><strong>Submit a Request</strong><small>Tell us what help you need.</small></div></li>
            <li><span>2</span><div><strong>Volunteer Accepts</strong><small>A local volunteer chooses to help.</small></div></li>
            <li><span>3</span><div><strong>Get Connected</strong><small>We share contact details.</small></div></li>
            <li><span>4</span><div><strong>Task Completed</strong><small>Leave feedback after completion.</small></div></li>
          </ol>
        </div>
        <div class="side-card highlight">
          <h4>Need Help?</h4>
          <p>Contact us if you have any questions or need assistance filling out this form.</p>
          <a class="btn btn-ghost" href="contact.php" style="width:100%"><i class="fa-solid fa-headset"></i> Contact Support</a>
        </div>
      </aside>
    </div>
  </div>
</section>

</main>

<?php include __DIR__ . "/partials/footer.php"; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("requestForm");
  const dateInput = document.getElementById("prefDate");
  if (dateInput && !dateInput.value) dateInput.min = new Date().toISOString().split("T")[0];

  const steps = [...document.querySelectorAll(".request-step")];
  const nodes = [...document.querySelectorAll(".step-node")];
  const categoryInput = document.getElementById("categoryInput");
  let current = 1;
  let selectedCategory = categoryInput.value || "";

  const tiles = [...document.querySelectorAll(".option-tile")];
  tiles.forEach(tile => {
    tile.addEventListener("click", () => {
      tiles.forEach(t => t.classList.remove("selected"));
      tile.classList.add("selected");
      selectedCategory = tile.dataset.value;
      categoryInput.value = selectedCategory;
      document.getElementById("categoryError").style.display = "none";
    });
  });
  if (selectedCategory) {
    const match = tiles.find(t => t.dataset.value === selectedCategory);
    if (match) match.classList.add("selected");
  }

  function goToStep(n) {
    steps.forEach(s => s.classList.toggle("active", Number(s.dataset.step) === n));
    nodes.forEach(node => {
      const val = Number(node.dataset.step);
      node.classList.toggle("active", val === n);
      node.classList.toggle("done", val < n);
    });
    current = n;
    if (n === 3) buildReview();
    document.querySelector(".stepper").scrollIntoView({ behavior: "smooth", block: "center" });
  }

  function validateStep1() {
    let ok = true;
    if (!selectedCategory) { document.getElementById("categoryError").style.display = "block"; ok = false; }
    const location = document.getElementById("location");
    const wrap = location.closest(".field");
    if (!location.value.trim()) { wrap.classList.add("error"); ok = false; } else wrap.classList.remove("error");
    return ok;
  }
  function validateStep2() {
    let ok = true;
    ["prefDate", "prefTime"].forEach(id => {
      const el = document.getElementById(id);
      const wrap = el.closest(".field");
      if (!el.value) { wrap.classList.add("error"); ok = false; } else wrap.classList.remove("error");
    });
    return ok;
  }
  function buildReview() {
    const rows = [
      ["Category", selectedCategory || "—"],
      ["Location", document.getElementById("location").value || "—"],
      ["Preferred Date", document.getElementById("prefDate").value || "—"],
      ["Preferred Time", document.getElementById("prefTime").value || "—"],
      ["Preferred Contact", document.getElementById("contactMethod").value],
      ["Additional Notes", document.getElementById("notes").value || "None provided"]
    ];
    document.getElementById("reviewList").innerHTML = rows
      .map(([label, val]) => `<div class="review-row"><span>${label}</span><span>${val}</span></div>`).join("");
  }

  document.querySelectorAll(".next-step").forEach(btn => {
    btn.addEventListener("click", () => {
      if (current === 1 && !validateStep1()) return;
      if (current === 2 && !validateStep2()) return;
      goToStep(current + 1);
    });
  });
  document.querySelectorAll(".prev-step").forEach(btn => btn.addEventListener("click", () => goToStep(current - 1)));

  form.addEventListener("submit", e => {
    const agree = document.getElementById("agreeRules");
    if (!agree.checked) {
      e.preventDefault();
      document.getElementById("agreeError").style.display = "block";
      return;
    }
    document.getElementById("agreeError").style.display = "none";
    // No preventDefault — this is a real POST to request.php, saved to MySQL.
  });
});
</script>
</body>
</html>
