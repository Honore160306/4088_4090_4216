<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FoodSwipe — Ajouter un plat</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body>

<div class="app-page">

  <!-- Top Bar -->
  <div class="topbar">
    <span class="topbar-logo"><span>🍽️</span>FoodSwipe</span>
    <div class="topbar-actions">
      <a href="/home" title="Découvrir">🔥</a>
      <a href="/logout" title="Se déconnecter">🚪</a>
    </div>
  </div>

  <!-- Add Food Form -->
  <div class="add-food-container">
    <h1>Ajouter un plat</h1>
    <p class="form-subtitle">Partagez votre découverte culinaire avec la communauté</p>

    <form id="add-food-form" enctype="multipart/form-data">
      <!-- Image Upload -->
      <div class="form-group">
        <label>Photo du plat</label>
        <div class="image-upload" id="image-upload">
          <input type="file" id="food_image" name="food_image" accept="image/*" style="display: none;">
          <div class="upload-placeholder" onclick="document.getElementById('food_image').click()">
            <div class="upload-icon">📷</div>
            <p>Cliquez pour ajouter une photo</p>
            <small>JPG, PNG - Max 5MB</small>
          </div>
          <div class="upload-preview" id="upload-preview" style="display: none;">
            <img id="preview-img" src="" alt="Preview">
            <button type="button" class="remove-image" onclick="removeImage()">✕</button>
          </div>
        </div>
      </div>

      <!-- Name -->
      <div class="form-group">
        <label>Nom du plat *</label>
        <input type="text" id="food-name" name="name" placeholder="Ex: Ramen Tonkotsu" required>
      </div>

      <!-- Emoji -->
      <div class="form-group">
        <label>Emoji *</label>
        <select id="food-emoji" name="emoji" required>
          <option value="">Choisissez un emoji</option>
          <?php foreach ($emojis as $emoji): ?>
          <option value="<?= $emoji['id_emoji'] ?>"><?= $emoji['img'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Category -->
      <div class="form-group">
        <label>Catégorie *</label>
        <select id="food-category" name="category" required>
          <option value="">Choisissez une catégorie</option>
          <?php foreach ($categories as $category): ?>
          <option value="<?= $category['id_category'] ?>"><?= $category['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Time and Calories (Row) -->
      <div class="form-row">
        <div class="form-group">
          <label>Temps de préparation *</label>
          <input type="number" id="food-time" name="time" placeholder="45" min="1" required>
          <small>minutes</small>
        </div>
        <div class="form-group">
          <label>Calories *</label>
          <input type="number" id="food-calories" name="calories" placeholder="620" min="1" required>
          <small>kcal</small>
        </div>
      </div>

      <!-- Rating -->
      <div class="form-group">
        <label>Note *</label>
        <div class="rating-input">
          <?php for ($i = 1; $i <= 5; $i++): ?>
          <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= $i == 5 ? 'checked' : '' ?>>
          <label for="star<?= $i ?>">⭐</label>
          <?php endfor; ?>
        </div>
      </div>

      <!-- Description -->
      <div class="form-group">
        <label>Description *</label>
        <textarea id="food-description" name="description" placeholder="Décrivez ce plat, ses ingrédients, son goût..." rows="4" required></textarea>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn-primary">Ajouter le plat 🍴</button>
    </form>
  </div>

  <!-- Bottom Nav -->
  <div class="bottom-nav">
    <a href="/home">
      <span class="nav-icon">🔥</span>Découvrir
    </a>
    <a href="/add-food" class="active">
      <span class="nav-icon">➕</span>Ajouter
    </a>
    <a href="/stats">
      <span class="nav-icon">📊</span>Mes stats
    </a>
  </div>

</div>

<script>
  // Image upload preview
  document.getElementById('food_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      if (file.size > 5 * 1024 * 1024) {
        alert('L\'image ne doit pas dépasser 5MB');
        return;
      }
      
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('upload-preview').style.display = 'block';
        document.querySelector('.upload-placeholder').style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });

  function removeImage() {
    document.getElementById('food_image').value = '';
    document.getElementById('upload-preview').style.display = 'none';
    document.querySelector('.upload-placeholder').style.display = 'block';
    document.getElementById('preview-img').src = '';
  }

  // Form submission
  document.getElementById('add-food-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Ajout en cours...';
    submitBtn.disabled = true;
    
    fetch('/add-food', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Plat ajouté avec succès !');
        window.location.href = '/home';
      } else {
        alert('Erreur: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Erreur lors de l\'ajout du plat');
    })
    .finally(() => {
      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
    });
  });
</script>

</body>
</html>
