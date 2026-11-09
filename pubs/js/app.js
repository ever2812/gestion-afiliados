  //-- Lógica básica de Login y accesibilidad móvil -- //   
    
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('passwordInput');
      const eyeIcon = document.getElementById('passwordEyeIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    }

async function handleLogin() {
  const username = document.getElementById('usernameInput').value.trim();
  const password = document.getElementById('passwordInput').value.trim();
  const alertBox = document.getElementById('loginAlert');
  const alertText = document.getElementById('loginAlertText');
  const btnSubmit = document.getElementById('btnLoginSubmit');
  const btnText = document.getElementById('btnLoginText');
  const btnSpinner = document.getElementById('btnLoginSpinner');

  alertBox.classList.add('d-none');

  if (!username || !password) {
    alertText.textContent = 'Por favor completa todos los campos requeridos.';
    alertBox.classList.remove('d-none');
    return;
  }

  btnSubmit.disabled = true;
  btnText.textContent = 'Verificando...';
  btnSpinner.classList.remove('d-none');

  try {
    const response = await fetch('api-login/index.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ username, password })
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error(result.error || 'Credenciales inválidas');
    }

    // Redirección hacia la carpeta protegida
    window.location.href = result.redirect || './adm/';

  } catch (err) {
    alertText.textContent = err.message || 'Error al conectar con el servidor.';
    alertBox.classList.remove('d-none');
  } finally {
    btnSubmit.disabled = false;
    btnText.textContent = 'Ingresar al Sistema';
    btnSpinner.classList.add('d-none');
  }
}