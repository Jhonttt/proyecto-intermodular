// forgot-password.ts
window.addEventListener('DOMContentLoaded', function () {
    var sendBtn = document.getElementById('sendBtn');
    var emailInput = document.getElementById('email');
    var messageDiv = document.getElementById('message');
    if (!sendBtn || !emailInput || !messageDiv)
        return;
    sendBtn.addEventListener('click', function () {
        var email = emailInput.value.trim();
        // Reset mensaje
        messageDiv.style.display = 'none';
        messageDiv.className = '';
        if (!email) {
            messageDiv.innerText = 'Por favor, introduce un correo válido.';
            messageDiv.style.display = 'block';
            messageDiv.classList.add('error');
            emailInput.focus();
            return;
        }
        messageDiv.innerText = "Se ha enviado un correo de recuperaci\u00F3n a ".concat(email);
        messageDiv.style.display = 'block';
        messageDiv.classList.add('success');
        emailInput.value = '';
    });
});
