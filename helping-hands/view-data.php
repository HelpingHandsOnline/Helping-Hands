<?php
require __DIR__ . "/config.php";

$users = $pdo->query("SELECT id, first_name, last_name, email, phone, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
$requests = $pdo->query("
    SELECT r.*, u.first_name AS req_first, u.last_name AS req_last, v.first_name AS vol_first, v.last_name AS vol_last
    FROM requests r
    JOIN users u ON u.id = r.user_id
    LEFT JOIN users v ON v.id = r.volunteer_id
    ORDER BY r.created_at DESC
")->fetchAll();
$volunteers = $pdo->query("
    SELECT vo.*, u.first_name, u.last_name, u.email
    FROM volunteers vo JOIN users u ON u.id = vo.user_id
    ORDER BY vo.created_at DESC
")->fetchAll();
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
$subs = $pdo->query("SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC")->fetchAll();

$statusClass = ["Pending" => "status-pending", "Accepted" => "status-accepted", "Completed" => "status-completed"];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Helping Hands | Data Viewer</title>
<link rel="icon" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="common.css">
<style>
  .dv-hero{padding:44px 0 20px;background:linear-gradient(120deg,var(--cream),#fffdf9 58%,#edf6f5)}
  .dv-tabs{display:flex;gap:8px;flex-wrap:wrap;margin:20px 0 30px}
  .dv-tab{border:1px solid var(--line);background:#fff;color:var(--teal-dark);font-size:11px;font-weight:800;padding:10px 18px;border-radius:999px;cursor:pointer}
  .dv-tab.active{background:var(--teal-dark);border-color:var(--teal-dark);color:#fff}
  .dv-panel{display:none}
  .dv-panel.active{display:block}
  .dv-table-wrap{overflow:auto;border:1px solid var(--line);border-radius:14px;background:#fff;box-shadow:var(--shadow-sm)}
  table.dv-table{width:100%;border-collapse:collapse;font-size:12px;min-width:600px}
  table.dv-table th{background:var(--teal-dark);color:#fff;text-align:left;padding:12px 14px;font-size:10px;text-transform:uppercase;letter-spacing:.04em;white-space:nowrap}
  table.dv-table td{padding:12px 14px;border-bottom:1px solid var(--line);white-space:nowrap;color:var(--ink)}
  table.dv-table tr:last-child td{border-bottom:0}
  table.dv-table tr:hover td{background:#fbfaf7}
  .dv-empty{padding:30px;text-align:center;color:var(--muted);font-size:12px}
  .dv-count{display:inline-block;background:var(--orange-soft);color:var(--orange);font-weight:800;font-size:10px;padding:3px 9px;border-radius:999px;margin-left:8px}
</style>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<?php include __DIR__ . "/partials/header.php"; ?>

<main id="main">

<section class="dv-hero">
  <div class="container">
    <span class="eyebrow">DATA VIEWER</span>
    <h1 style="font-size:34px;color:var(--teal-dark);margin:6px 0">Everything saved in your database</h1>
    <p style="color:var(--muted);font-size:13px;max-width:600px">A live look at the <code>helpinghands_db</code> database — every account, request, volunteer application, message and newsletter sign-up, straight from MySQL. Refresh this page any time to see the latest data.</p>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">

    <div class="dv-tabs" role="tablist">
      <button class="dv-tab active" data-target="tab-users">Users <span class="dv-count"><?php echo count($users); ?></span></button>
      <button class="dv-tab" data-target="tab-requests">Requests <span class="dv-count"><?php echo count($requests); ?></span></button>
      <button class="dv-tab" data-target="tab-volunteers">Volunteers <span class="dv-count"><?php echo count($volunteers); ?></span></button>
      <button class="dv-tab" data-target="tab-messages">Contact Messages <span class="dv-count"><?php echo count($messages); ?></span></button>
      <button class="dv-tab" data-target="tab-newsletter">Newsletter <span class="dv-count"><?php echo count($subs); ?></span></button>
    </div>

    <!-- USERS -->
    <div class="dv-panel active" id="tab-users">
      <?php if (!$users): ?>
        <div class="dv-empty">No accounts yet — <a href="signup.php" style="color:var(--orange);font-weight:800">sign up</a> to create one.</div>
      <?php else: ?>
      <div class="dv-table-wrap"><table class="dv-table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Joined</th></tr></thead>
        <tbody>
          <?php foreach ($users as $u): ?>
          <tr>
            <td>#<?php echo (int)$u["id"]; ?></td>
            <td><?php echo h($u["first_name"] . " " . $u["last_name"]); ?></td>
            <td><?php echo h($u["email"]); ?></td>
            <td><?php echo h($u["phone"]); ?></td>
            <td><?php echo h($u["role"]); ?></td>
            <td><?php echo h(date("d M Y, H:i", strtotime($u["created_at"]))); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <p style="margin-top:10px;font-size:11px;color:var(--muted)">Passwords are never shown here — they're stored as one-way hashes, not readable text.</p>
      <?php endif; ?>
    </div>

    <!-- REQUESTS -->
    <div class="dv-panel" id="tab-requests">
      <?php if (!$requests): ?>
        <div class="dv-empty">No requests yet — <a href="request.php" style="color:var(--orange);font-weight:800">submit one</a>.</div>
      <?php else: ?>
      <div class="dv-table-wrap"><table class="dv-table">
        <thead><tr><th>ID</th><th>Category</th><th>Location</th><th>Requested By</th><th>Volunteer</th><th>Status</th><th>Submitted</th></tr></thead>
        <tbody>
          <?php foreach ($requests as $r): ?>
          <tr>
            <td>#<?php echo (int)$r["id"]; ?></td>
            <td><?php echo h($r["category"]); ?></td>
            <td><?php echo h($r["location"]); ?></td>
            <td><?php echo h($r["req_first"] . " " . $r["req_last"]); ?></td>
            <td><?php echo $r["vol_first"] ? h($r["vol_first"] . " " . $r["vol_last"]) : "—"; ?></td>
            <td><span class="status-pill <?php echo $statusClass[$r["status"]] ?? ""; ?>"><?php echo h($r["status"]); ?></span></td>
            <td><?php echo h(date("d M Y, H:i", strtotime($r["created_at"]))); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>

    <!-- VOLUNTEERS -->
    <div class="dv-panel" id="tab-volunteers">
      <?php if (!$volunteers): ?>
        <div class="dv-empty">No volunteer applications yet — <a href="volunteer.php" style="color:var(--orange);font-weight:800">apply</a>.</div>
      <?php else: ?>
      <div class="dv-table-wrap"><table class="dv-table">
        <thead><tr><th>ID</th><th>Name</th><th>Areas</th><th>Availability</th><th>Emergency Contact</th><th>Status</th><th>Applied</th></tr></thead>
        <tbody>
          <?php foreach ($volunteers as $v): ?>
          <tr>
            <td>#<?php echo (int)$v["id"]; ?></td>
            <td><?php echo h($v["first_name"] . " " . $v["last_name"]); ?></td>
            <td><?php echo h($v["areas"]); ?></td>
            <td><?php echo h($v["availability"]); ?></td>
            <td><?php echo h($v["emergency_contact_name"]); ?> · <?php echo h($v["emergency_contact_phone"]); ?></td>
            <td><?php echo h($v["status"]); ?></td>
            <td><?php echo h(date("d M Y, H:i", strtotime($v["created_at"]))); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>

    <!-- CONTACT MESSAGES -->
    <div class="dv-panel" id="tab-messages">
      <?php if (!$messages): ?>
        <div class="dv-empty">No messages yet — <a href="contact.php" style="color:var(--orange);font-weight:800">send one</a>.</div>
      <?php else: ?>
      <div class="dv-table-wrap"><table class="dv-table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Sent</th></tr></thead>
        <tbody>
          <?php foreach ($messages as $m): ?>
          <tr>
            <td>#<?php echo (int)$m["id"]; ?></td>
            <td><?php echo h($m["name"]); ?></td>
            <td><?php echo h($m["email"]); ?></td>
            <td><?php echo h($m["subject"]); ?></td>
            <td style="white-space:normal;max-width:280px"><?php echo h(mb_strimwidth($m["message"], 0, 80, "…")); ?></td>
            <td><?php echo h(date("d M Y, H:i", strtotime($m["created_at"]))); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>

    <!-- NEWSLETTER -->
    <div class="dv-panel" id="tab-newsletter">
      <?php if (!$subs): ?>
        <div class="dv-empty">No subscribers yet — sign up from the <a href="resources.php#stay-connected" style="color:var(--orange);font-weight:800">Resources page</a>.</div>
      <?php else: ?>
      <div class="dv-table-wrap"><table class="dv-table">
        <thead><tr><th>ID</th><th>Email</th><th>Subscribed</th></tr></thead>
        <tbody>
          <?php foreach ($subs as $s): ?>
          <tr>
            <td>#<?php echo (int)$s["id"]; ?></td>
            <td><?php echo h($s["email"]); ?></td>
            <td><?php echo h(date("d M Y, H:i", strtotime($s["subscribed_at"]))); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>

    <div style="margin-top:30px;text-align:center">
      <a class="btn btn-ghost" href="database_check.php"><i class="fa-solid fa-database"></i> Database Connection Check</a>
      <a class="btn btn-orange" href="http://localhost/phpmyadmin/" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i> Open in phpMyAdmin</a>
    </div>
    <p style="text-align:center;font-size:11px;color:var(--muted);margin-top:12px;max-width:520px;margin-left:auto;margin-right:auto">
      This page and phpMyAdmin show the exact same database — <code>helpinghands_db</code>.
      Whatever you see above will match phpMyAdmin's <strong>Browse</strong> tab for that table
      (click the database name on the left, then a table, then <strong>Browse</strong> — not
      <strong>Structure</strong>, which only ever shows column names, never your actual data).
    </p>
  </div>
</section>

</main>

<?php include __DIR__ . "/partials/footer.php"; ?>
<script>
document.querySelectorAll(".dv-tab").forEach(function (tab) {
  tab.addEventListener("click", function () {
    document.querySelectorAll(".dv-tab").forEach(function (t) { t.classList.remove("active"); });
    document.querySelectorAll(".dv-panel").forEach(function (p) { p.classList.remove("active"); });
    tab.classList.add("active");
    document.getElementById(tab.dataset.target).classList.add("active");
  });
});
</script>
</body>
</html>
