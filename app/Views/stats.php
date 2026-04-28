<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FoodSwipe — Mes Stats</title>
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

  <!-- Stats Content -->
  <div class="stats-container">
    <h1>Mes Statistiques</h1>
    <p class="stats-subtitle"><?= $user_name ?>, voici votre activité sur FoodSwipe</p>

    <!-- Summary Cards -->
    <div class="stats-summary">
      <div class="stat-card">
        <div class="stat-number"><?= $summary['total'] ?></div>
        <div class="stat-label">Plats vus</div>
      </div>
      <div class="stat-card liked">
        <div class="stat-number"><?= $summary['likes'] ?></div>
        <div class="stat-label">J'aime</div>
      </div>
      <div class="stat-card skipped">
        <div class="stat-number"><?= $summary['skips'] ?></div>
        <div class="stat-label">Pas intéressé</div>
      </div>
      <div class="stat-card super">
        <div class="stat-number"><?= $summary['supers'] ?></div>
        <div class="stat-label">Super Likes</div>
      </div>
    </div>

    <!-- Liked Foods -->
    <?php if (!empty($liked_foods)): ?>
    <div class="stats-section">
      <h2>♥ Plats que vous aimez</h2>
      <div class="food-grid">
        <?php foreach ($liked_foods as $food): ?>
        <div class="food-item">
          <div class="food-image" style="background-image: url('<?= $food['img'] ?>')">
            <div class="food-emoji"><?= $food['emoji'] ?></div>
          </div>
          <div class="food-info">
            <h4><?= $food['food_name'] ?></h4>
            <p class="food-category"><?= $food['category_name'] ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Super Liked Foods -->
    <?php if (!empty($super_liked_foods)): ?>
    <div class="stats-section">
      <h2>⭐ Vos Super Likes</h2>
      <div class="food-grid">
        <?php foreach ($super_liked_foods as $food): ?>
        <div class="food-item">
          <div class="food-image" style="background-image: url('<?= $food['img'] ?>')">
            <div class="food-emoji"><?= $food['emoji'] ?></div>
          </div>
          <div class="food-info">
            <h4><?= $food['food_name'] ?></h4>
            <p class="food-category"><?= $food['category_name'] ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Skipped Foods -->
    <?php if (!empty($skipped_foods)): ?>
    <div class="stats-section">
      <h2>✕ Plats ignorés</h2>
      <div class="food-grid">
        <?php foreach ($skipped_foods as $food): ?>
        <div class="food-item">
          <div class="food-image" style="background-image: url('<?= $food['img'] ?>')">
            <div class="food-emoji"><?= $food['emoji'] ?></div>
          </div>
          <div class="food-info">
            <h4><?= $food['food_name'] ?></h4>
            <p class="food-category"><?= $food['category_name'] ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if (empty($liked_foods) && empty($super_liked_foods) && empty($skipped_foods)): ?>
    <div class="empty-stats">
      <div class="emoji">📊</div>
      <h2>Pas encore d'activité</h2>
      <p>Commencez à swiper des plats pour voir vos statistiques ici !</p>
      <a href="/home" class="btn-primary">Commencer à swiper</a>
    </div>
    <?php endif; ?>

  </div>

  <!-- Bottom Nav -->
  <div class="bottom-nav">
    <a href="/home">
      <span class="nav-icon">🔥</span>Découvrir
    </a>
    <a href="/add-food">
      <span class="nav-icon">➕</span>Ajouter
    </a>
    <a href="/stats" class="active">
      <span class="nav-icon">📊</span>Mes stats
    </a>
  </div>

</div>

</body>
</html>
