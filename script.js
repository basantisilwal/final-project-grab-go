<script>
  document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting for validation
    var password = document.querySelector('input[name="password"]').value;
    var confirmPassword = document.querySelector('input[name="confirm_password"]').value;

    if (password !== confirmPassword) {
      alert('Passwords do not match!');
    } else {
      alert('Registration successful!'); // Replace this with actual form submission logic
      // Optionally submit the form here, using AJAX or a traditional form submission
      // this.submit();
    }
  });
</script>
