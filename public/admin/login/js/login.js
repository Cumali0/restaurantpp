// Parola görünür/gizli toggle
const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('password');

togglePassword.addEventListener('click', function () {
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        togglePassword.textContent = 'visibility';
    } else {
        passwordField.type = 'password';
        togglePassword.textContent = 'visibility_off';
    }
});
