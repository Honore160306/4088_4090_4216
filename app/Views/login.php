<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FoodSwipe — Connexion</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<div class="auth-page">
  <div class="auth-card">

    <div class="auth-logo">
      <span class="logo-icon">🍽️</span>
      <h1>FoodSwipe</h1>
      <p>Swipez. Savourez. Régalez-vous.</p>
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" id="login-email" placeholder="vous@exemple.com" autocomplete="email" />
    </div>

    <div class="form-group">
      <label>Mot de passe</label>
      <input type="password" id="login-pwd" placeholder="••••••••" autocomplete="current-password" />
    </div>

    <p class="form-error" id="login-error">Email ou mot de passe incorrect.</p>

    <button class="btn-primary" onclick="doLogin()">Se connecter 🍴</button>

    <div class="auth-switch">
      Pas encore de compte ? <a href="/register">S'inscrire</a>
    </div>

  </div>
</div>

<script>
  function doLogin() {
    const email = document.getElementById('login-email').value.trim();
    const pwd   = document.getElementById('login-pwd').value;
    const err   = document.getElementById('login-error');

    if (!email || !pwd) {
      err.textContent = 'Veuillez remplir tous les champs.';
      err.classList.add('visible');
      return;
    }

    err.classList.remove('visible');

    // Send AJAX request to server
    fetch('/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `email=${encodeURIComponent(email)}&pwd=${encodeURIComponent(pwd)}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        window.location.href = '/home';
      } else {
        err.textContent = data.message;
        err.classList.add('visible');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      err.textContent = 'Erreur de connexion. Veuillez réessayer.';
      err.classList.add('visible');
    });
  }

  // Enter key support
  document.addEventListener('keydown', e => { if (e.key === 'Enter') doLogin(); });
</script>

</body>
</html>
