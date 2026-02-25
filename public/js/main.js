window.toggleSidebar = function () {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("mobileOverlay");
  sidebar.classList.toggle("active");
  overlay.classList.toggle("hidden");
};

window.toggleUserMenu = function () {
  const dropdown = document.getElementById("userDropdown");
  dropdown.classList.toggle("hidden");
};

// Close dropdowns when clicking outside
document.addEventListener("click", (e) => {
  const userBtn = document.getElementById("userProfileBtn");
  const userDropdown = document.getElementById("userDropdown");
  if (
    userBtn &&
    !userBtn.contains(e.target) &&
    !userDropdown.contains(e.target)
  ) {
    userDropdown.classList.add("hidden");
  }
});