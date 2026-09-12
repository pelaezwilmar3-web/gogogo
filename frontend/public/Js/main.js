// Toggle Sidebar en dispositivos móviles
const toggleBtn = document.getElementById("vsSidebarToggle");
const sidebar = document.getElementById("vsSidebar");
const main = document.getElementById("vsMain");

if (toggleBtn && sidebar) {
  // Click en el botón toggle
  toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("active");
  });

  // Cerrar sidebar al hacer click en un enlace de navegación
  const navLinks = sidebar.querySelectorAll(".nav-link");
  navLinks.forEach(link => {
    link.addEventListener("click", () => {
      if (window.innerWidth <= 768) {
        sidebar.classList.remove("active");
      }
    });
  });

  // Cerrar sidebar al hacer click fuera de él
  document.addEventListener("click", (e) => {
    if (window.innerWidth <= 768 && 
        sidebar.classList.contains("active") && 
        !sidebar.contains(e.target) && 
        !toggleBtn.contains(e.target)) {
      sidebar.classList.remove("active");
    }
  });
}

// Chart.js
const ctx = document.getElementById("salesChart");

if (ctx) {
  new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun"],
      datasets: [{
        label: "Ventas",
        data: [12, 19, 10, 15, 22, 30],
        borderWidth: 2
      }]
    }
  });
}
