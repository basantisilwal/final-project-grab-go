// script.js
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('nav ul li a');
    const sections = document.querySelectorAll('.page');

    links.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('data-target');

            sections.forEach(section => {
                if (section.id === targetId) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }

                
                
            });
        });
    });
});
<script>
  // Add event listener to the "Create an account...!" link
  document.getElementById('create-account-link').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior
    
    // Redirect to the registration page
    window.location.href = 'register.html'; // Replace 'register.html' with your registration page URL
  });
</script>