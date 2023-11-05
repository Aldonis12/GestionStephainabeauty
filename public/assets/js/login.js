/* Check email if exist */
const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error');
const buttonBe = document.getElementById('button-modifier');

emailInput.addEventListener('blur', async () => {
    const email = emailInput.value;
    const response = await fetch(`/check-email?mail=${email}`);
    const data = await response.json();

    if (data.exists) {
        emailError.textContent = '';
        buttonBe.disabled = false;
    } else {
        emailError.textContent = 'Veuillez mettre votre email actuel!';
        buttonBe.disabled = true;
    }
});
/* FIN Check email if exist */

/* Check mot de passe */
var passwordInput = document.getElementById("password");
var confirmPasswordInput = document.getElementById("confirmPassword");
var passwordError = document.getElementById("passwordError");

confirmPasswordInput.addEventListener("input", function() {
    if (passwordInput.value !== confirmPasswordInput.value) {
        passwordError.textContent = "Les mots de passes ne sont pas identiques.";
    } else {
        passwordError.textContent = "";
    }
});
/* FIN Check mot de passe */