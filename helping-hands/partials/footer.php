<footer class="footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <a class="logo" href="index.php">
        <img src="logo.png" alt="Helping Hands logo">
        <span class="logo-text"><strong>HELPING HANDS</strong><span>COMMUNITY ASSIST</span></span>
      </a>
      <p>Connecting neighbours. Building stronger communities. One helping hand at a time.</p>
    </div>
    <div class="footer-col">
      <h4>Quick Links</h4>
      <a href="index.php">Home</a>
      <a href="howitworks.php">How It Works</a>
      <a href="request.php">Request Help</a>
      <a href="volunteer.php">Volunteer</a>
      <a href="about.php">About Us</a>
      <a href="resources.php">Resources</a>
      <a href="contact.php">Contact Us</a>
    </div>
    <div class="footer-col">
      <h4>For Users</h4>
      <?php if (logged_in()): ?>
        <a href="account.php">My Account</a>
        <a href="tasks.php">Task Centre</a>
        <a href="request.php">Request Help</a>
        <a href="volunteer.php">Volunteer Application</a>
        <a href="logout.php">Log Out</a>
      <?php else: ?>
        <a href="login.php">Log In</a>
        <a href="signup.php">Sign Up</a>
        <a href="request.php">Request Help</a>
        <a href="volunteer.php">Volunteer</a>
      <?php endif; ?>
    </div>
    <div class="footer-col">
      <h4>Stay Connected</h4>
      <p>Subscribe for community updates.</p>
      <div class="socials">
        <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook (opens in a new tab)"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram (opens in a new tab)"><i class="fa-brands fa-instagram"></i></a>
        <a href="https://www.youtube.com/" target="_blank" rel="noopener" aria-label="YouTube (opens in a new tab)"><i class="fa-brands fa-youtube"></i></a>
      </div>
    </div>
  </div>
  <div class="container footer-bottom">
    <span>© 2026 Helping Hands Community Assist. All rights reserved.</span>
    <span><a href="privacy.php" style="color:#779596">Privacy Policy</a> &nbsp;·&nbsp; <a href="terms.php" style="color:#779596">Terms of Use</a></span>
    <span>Made for the community <i class="fa-solid fa-heart" style="color:#ff7900"></i></span>
  </div>
</footer>

<script src="common.js"></script>
<script>
/* Password show/hide toggle, shared by login.php and signup.php */
document.querySelectorAll(".reveal-toggle").forEach(function (btn) {
  btn.addEventListener("click", function () {
    var input = document.getElementById(btn.dataset.target);
    var icon = btn.querySelector("i");
    var showing = input.type === "text";
    input.type = showing ? "password" : "text";
    icon.className = showing ? "fa-regular fa-eye" : "fa-regular fa-eye-slash";
  });
});
/* Gentle entrance animation for any element marked .reveal */
if ("IntersectionObserver" in window) {
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) { e.target.classList.add("in-view"); io.unobserve(e.target); }
    });
  }, { threshold: 0.12 });
  document.querySelectorAll(".reveal").forEach(function (el) { io.observe(el); });
} else {
  document.querySelectorAll(".reveal").forEach(function (el) { el.classList.add("in-view"); });
}
</script>
