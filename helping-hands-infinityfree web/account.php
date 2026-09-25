<?php
require __DIR__ . "/config.php";
require_login();
$me = user();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM requests WHERE user_id = ?");
$stmt->execute([$me["id"]]);
$requestCount = (int)$stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT * FROM requests WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$me["id"]]);
$requests = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM volunteers WHERE user_id = ?");
$stmt->execute([$me["id"]]);
$vol = $stmt->fetch();

$statusClass = ["Pending" => "status-pending", "Accepted" => "status-accepted", "Completed" => "status-completed"];
$activePage = "account";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | My Account</title>
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="contact.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="section" style="padding-bottom:0;background:linear-gradient(120deg,var(--cream),#fffdf9 58%,#edf6f5)">
  <div class="container" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;padding:14px 0">
    <div style="width:60px;height:60px;border-radius:50%;background:var(--orange);color:#fff;display:grid;place-items:center;font-size:22px;font-weight:800">
      <?php echo h(strtoupper(($me["first_name"][0] ?? "") . ($me["last_name"][0] ?? ""))); ?>
    </div>
    <div>
      <span class="eyebrow">MY ACCOUNT</span>
      <h1 style="font-size:32px;color:var(--teal-dark);margin:4px 0">Welcome back, <?php echo h($me["first_name"]); ?>!</h1>
      <p style="font-size:12px;color:var(--muted)">Loaded fresh from the database on every visit.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top:24px">
  <div class="container">

    <div class="stats-band" style="margin-bottom:36px">
      <div class="stat"><strong><?php echo $requestCount; ?></strong><small>Help requests</small></div>
      <div class="stat"><strong><?php echo $vol ? "Yes" : "Not yet"; ?></strong><small>Volunteer application</small></div>
      <div class="stat"><strong><?php echo h(date("d M Y", strtotime($me["created_at"]))); ?></strong><small>Member since</small></div>
      <div class="stat"><strong><?php echo h($me["role"] ?: "Member"); ?></strong><small>Account role</small></div>
    </div>

    <div class="grid4" style="grid-template-columns:.9fr 1.1fr 1fr;align-items:start">

      <div class="info-card">
        <h2 style="font-size:19px;margin-bottom:6px">Account Details</h2>
        <div class="info-item"><div class="info-icon"><i class="fa-regular fa-user"></i></div><div><small>Full Name</small><strong><?php echo h($me["first_name"] . " " . $me["last_name"]); ?></strong></div></div>
        <div class="info-item"><div class="info-icon"><i class="fa-regular fa-envelope"></i></div><div><small>Email</small><strong><?php echo h($me["email"]); ?></strong></div></div>
        <div class="info-item"><div class="info-icon"><i class="fa-solid fa-phone"></i></div><div><small>Phone</small><strong><?php echo h($me["phone"]); ?></strong></div></div>
        <div class="info-item"><div class="info-icon"><i class="fa-solid fa-id-badge"></i></div><div><small>Role</small><strong><?php echo h($me["role"]); ?></strong></div></div>
        <a class="btn btn-outline full" style="margin-top:10px;width:100%" href="logout.php">Log Out</a>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;color:var(--teal-dark)">My Requests</h3>
        <?php if (!$requests): ?>
          <div class="empty"><strong>No requests yet</strong><p class="muted">Submit one whenever you need a hand.</p>
            <a class="btn btn-orange" style="margin-top:12px;display:inline-flex" href="request.php">Request Help <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        <?php else: foreach ($requests as $r): ?>
          <div class="task-card">
            <div class="task-main">
              <strong><?php echo h($r["category"]); ?> <span class="status-pill <?php echo $statusClass[$r["status"]] ?? ""; ?>"><?php echo h($r["status"]); ?></span></strong>
              <span><?php echo h($r["location"]); ?> · <?php echo h($r["preferred_date"] ?: "No date set"); ?></span>
            </div>
          </div>
        <?php endforeach; endif; ?>
        <a class="btn btn-ghost full" style="margin-top:10px" href="request.php">+ New Request</a>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;color:var(--teal-dark)">My Volunteer Application</h3>
        <?php if (!$vol): ?>
          <div class="empty"><strong>Not registered yet</strong><p class="muted">Apply to start helping neighbours nearby.</p>
            <a class="btn btn-orange" style="margin-top:12px;display:inline-flex" href="volunteer.php">Apply to Volunteer <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        <?php else: ?>
          <p class="muted"><strong style="color:var(--teal-dark)">Areas:</strong> <?php echo h($vol["areas"]); ?></p>
          <p class="muted"><strong style="color:var(--teal-dark)">Availability:</strong> <?php echo h($vol["availability"]); ?></p>
          <p class="muted"><strong style="color:var(--teal-dark)">Emergency contact:</strong> <?php echo h($vol["emergency_contact_name"]); ?> · <?php echo h($vol["emergency_contact_phone"]); ?></p>
          <a class="btn btn-ghost full" style="margin-top:12px" href="volunteer.php#apply">Update Application</a>
          <a class="btn btn-orange full" style="margin-top:10px" href="tasks.php">Open Task Centre <i class="fa-solid fa-arrow-right"></i></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<div class="cta">
  <div class="cta-icon"><i class="fa-regular fa-heart"></i></div>
  <div class="cta-copy"><strong>Ready to help someone today?</strong><span>Visit the Task Centre to accept a nearby request, or apply as a volunteer if you haven't yet.</span></div>
  <a class="btn btn-orange" href="tasks.php">Open Task Centre <i class="fa-solid fa-arrow-right"></i></a>
</div>

</main>

<?php include __DIR__ . "/partials/footer.php"; ?>
</body>
</html>
