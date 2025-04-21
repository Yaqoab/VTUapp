// show or hide inputs of changePassword, changePin, and newPin files
const show=document.getElementById('show');
const showText=document.getElementById('showtext');
const inputs=document.querySelectorAll('.inp');

show.addEventListener('click', () => {
  const isPasswordVisible = show.classList.contains('fa-eye-slash');

  for (const input of inputs) {
    input.type = isPasswordVisible ? 'text' : 'password';
  }
  isPasswordVisible ? showText.textContent = 'Hide' : showText.textContent = 'show';

  // Toggle the eye icon based on the password visibility
  show.classList.toggle('fa-eye-slash');
  show.classList.toggle('fa-eye');
});