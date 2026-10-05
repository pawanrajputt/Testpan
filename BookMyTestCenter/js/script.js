// Heading script start
document.addEventListener('DOMContentLoaded', function () {
  // Select all nav links
  const navLinks = document.querySelectorAll('.nav-link');

  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      // Remove active-link from all
      navLinks.forEach(l => l.classList.remove('active-link'));

      // Add active-link to clicked one
      this.classList.add('active-link');
    });
  });
});


