/* ==========================================================================
   RESOURCES PAGE SCRIPT
   Handles: keyword search, category filter chips, the resource detail
   modal, and the newsletter sign-up. common.js (loaded first) already
   handles the mobile nav and the FAQ accordion.
   ========================================================================== */

/* Extra detail shown in the modal for each resource card, keyed by title */
const RESOURCE_DETAILS = {
  "How to Request Help": "Tell us what you need in a few sentences, choose a category, and a local coordinator will match you with a volunteer or service, usually within one working day. No paperwork, no fees, no judgement.",
  "Volunteer Best Practices": "Covers safe introductions, respecting privacy, setting time boundaries, and what to do if a request feels outside your comfort zone. Read this before your first visit.",
  "Senior Care Guide": "Practical, dignity-first advice for supporting older neighbours: home safety checks, staying socially connected, medication reminders, and when to involve a health professional.",
  "Local Support Services": "A directory of food parcels, shelters, clinics and legal aid organisations operating in and around Cape Town, with contact details and hours.",
  "Volunteer Safety Checklist": "A printable checklist to run through before every visit: share your location, confirm the request, carry ID, and know your exit plan.",
  "Understanding Community Assist": "A short overview of how requests are verified, matched and followed up, so you know exactly what happens after you submit a form.",
  "Food & Grocery Support": "Where to find community pantries, meal deliveries and grocery vouchers, plus how to request an emergency food parcel.",
  "Mental Health & Wellbeing": "Free and low-cost counselling lines, peer support groups and grounding techniques for stressful moments — for neighbours and volunteers alike."
};

document.addEventListener("DOMContentLoaded", () => {
  const cards = [...document.querySelectorAll(".resource-card")];

  /* ---- Keyword search ---- */
  const form = document.getElementById("resourceSearch");
  const input = document.getElementById("searchInput");
  const empty = document.getElementById("filterEmpty");
  const chips = [...document.querySelectorAll(".chip")];
  let activeCategory = "all";

  function applyFilters() {
    const q = (input.value || "").trim().toLowerCase();
    let shown = 0;
    cards.forEach(c => {
      const matchesSearch = !q || c.dataset.search.includes(q);
      const matchesCategory = activeCategory === "all" || c.dataset.category === activeCategory;
      const ok = matchesSearch && matchesCategory;
      c.style.display = ok ? "flex" : "none";
      if (ok) shown++;
    });
    if (empty) empty.style.display = shown ? "none" : "block";
  }

  if (form) {
    form.addEventListener("submit", e => {
      e.preventDefault();
      applyFilters();
      document.getElementById("featured").scrollIntoView({ behavior: "smooth", block: "start" });
    });
    input.addEventListener("input", applyFilters);
  }

  chips.forEach(chip => {
    chip.addEventListener("click", () => {
      chips.forEach(c => c.classList.remove("active"));
      chip.classList.add("active");
      activeCategory = chip.dataset.category;
      applyFilters();
    });
  });

  /* ---- Resource detail modal ---- */
  const backdrop = document.getElementById("resourceModal");
  const modalTag = document.getElementById("modalTag");
  const modalTitle = document.getElementById("modalTitle");
  const modalBody = document.getElementById("modalBody");
  const modalClose = document.getElementById("modalClose");
  const modalVideoWrap = document.getElementById("modalVideoWrap");
  const modalVideo = document.getElementById("modalVideo");

  window.showResource = function (title, tag, videoId) {
    if (!backdrop) return;
    modalTag.textContent = tag || "RESOURCE";
    modalTitle.textContent = title;
    modalBody.textContent = RESOURCE_DETAILS[title] || "This resource is ready to be connected to a real PDF, video or article.";
    if (videoId) {
      modalVideo.src = "https://www.youtube.com/embed/" + videoId + "?autoplay=1";
      modalVideoWrap.style.display = "block";
    } else {
      modalVideo.src = "";
      modalVideoWrap.style.display = "none";
    }
    backdrop.classList.add("open");
  };
  function closeModal() {
    if (!backdrop) return;
    backdrop.classList.remove("open");
    modalVideo.src = ""; // stop playback when the modal closes
  }
  if (modalClose) modalClose.addEventListener("click", closeModal);
  if (backdrop) backdrop.addEventListener("click", e => { if (e.target === backdrop) closeModal(); });
  document.addEventListener("keydown", e => { if (e.key === "Escape") closeModal(); });
});
