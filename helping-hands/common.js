/* ==========================================================================
   HELPING HANDS — COMMON SCRIPT
   Shared behaviour used on every page: the mobile nav toggle and the FAQ
   accordion. Loaded first; page-specific scripts (resources.js / contact.js)
   handle everything unique to that page.
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {

  /* Mobile navigation toggle */
  const menuBtn = document.getElementById("menuBtn");
  const nav = document.getElementById("nav");
  if (menuBtn && nav) {
    menuBtn.addEventListener("click", () => {
      const isOpen = nav.classList.toggle("open");
      menuBtn.setAttribute("aria-expanded", isOpen ? "true" : "false");
      menuBtn.innerHTML = isOpen
        ? '<i class="fa-solid fa-xmark"></i>'
        : '<i class="fa-solid fa-bars"></i>';
    });
    nav.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", () => {
        nav.classList.remove("open");
        menuBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
        menuBtn.setAttribute("aria-expanded", "false");
      });
    });
  }

  /* FAQ accordion — works for any .faq-item on the page */
  document.querySelectorAll(".faq-item").forEach(item => {
    const question = item.querySelector(".faq-q");
    if (!question) return;
    question.addEventListener("click", () => {
      const alreadyOpen = item.classList.contains("open");
      item.closest(".faq-list").querySelectorAll(".faq-item").forEach(other => {
        other.classList.remove("open");
        other.querySelector(".faq-q").setAttribute("aria-expanded", "false");
      });
      if (!alreadyOpen) {
        item.classList.add("open");
        question.setAttribute("aria-expanded", "true");
      }
    });
  });

});
