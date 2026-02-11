// forgot-password.ts
window.addEventListener('DOMContentLoaded', () => {
  const sendBtn = document.getElementById('sendBtn') as HTMLButtonElement | null;
  const emailInput = document.getElementById('email') as HTMLInputElement | null;
  const messageDiv = document.getElementById('message') as HTMLDivElement | null;

  if (!sendBtn || !emailInput || !messageDiv) return;

  sendBtn.addEventListener('click', () => {
    const email: string = emailInput.value.trim();

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

    messageDiv.innerText = `Se ha enviado un correo de recuperación a ${email}`;
    messageDiv.style.display = 'block';
    messageDiv.classList.add('success');

    emailInput.value = '';
  });
});
