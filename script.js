// script.js
document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('nav a');

    function updateActiveLink() {
      let index = sections.length;
      while (--index && window.scrollY + 50 < sections[index].offsetTop) {}
      navLinks.forEach((link) => link.classList.remove('active'));
      navLinks[index].classList.add('active');
    }

    updateActiveLink();
    window.addEventListener('scroll', updateActiveLink);
  });

  // Back to top button functionality
  const backToTopButton = document.getElementById('backToTop');
  window.addEventListener('scroll', function () {
    if (window.scrollY > 300) {
      backToTopButton.style.display = 'block';
    } else {
      backToTopButton.style.display = 'none';
    }
  });

  backToTopButton.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

