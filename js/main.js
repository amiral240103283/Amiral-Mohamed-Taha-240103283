
const btn = document.querySelector(".menu-btn");
const links = document.querySelector(".nav-links");

if (btn && links) {
  btn.addEventListener("click", () => links.classList.toggle("open"));
}

const path = window.location.pathname.split("/").pop() || "index.html";
document.querySelectorAll(".nav-links a").forEach(a => {
  if (a.getAttribute("href") === path) a.classList.add("active");
});

(function () {
  const chips = document.querySelectorAll(".chip");
  const sections = document.querySelectorAll(".menu-section");

  if (!chips.length || !sections.length) return;

  chips.forEach(btn => {
    btn.addEventListener("click", () => {
      chips.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const filter = btn.dataset.filter;

      sections.forEach(el => {
        const sec = el.dataset.section;
        el.style.display = (filter === "all" || sec === filter) ? "" : "none";
      });
    });
  });
})();
