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

      // Estado de carga
      btnSubmit.disabled = true;
      btnText.textContent = 'Verificando...';
      btnSpinner.classList.remove('d-none');

      try {
        /*
          // Ejemplo de integración con tu backend local o API:
          const response = await fetch('./login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
          });
          const res = await response.json();
          if (!response.ok) throw new Error(res.error || 'Credenciales inválidas');
        */

        // Simulación de respuesta exitosa
        await new Promise(resolve => setTimeout(resolve, 800));

        // Redirección a la pantalla de captura
        window.location.href = './adm/';

      } catch (err) {
        alertText.textContent = err.message || 'Error al iniciar sesión. Inténtalo de nuevo.';
        alertBox.classList.remove('d-none');
      } finally {
        btnSubmit.disabled = false;
        btnText.textContent = 'Ingresar al Sistema';
        btnSpinner.classList.add('d-none');
      }
    }