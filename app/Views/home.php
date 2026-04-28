<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FoodSwipe — Découvrir</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<div class="app-page">

  <!-- Top Bar -->
  <div class="topbar">
    <span class="topbar-logo"><span>🍽️</span>FoodSwipe</span>
    <div class="topbar-actions">
      <a href="/stats" title="Mes stats">📊</a>
      <a href="/logout" title="Se déconnecter">🚪</a>
    </div>
  </div>

  <!-- Card Area -->
  <div class="card-area">
    <div class="card-stack" id="card-stack"></div>

    <div class="empty-state" id="empty-state" style="display: none;">
      <div class="emoji">🍀</div>
      <h2>C'est tout pour l'instant !</h2>
      <p>Vous avez vu tous les plats disponibles.<br>Consultez vos stats !</p>
      <a href="/stats" class="btn-primary" style="max-width:200px;margin-top:8px;text-align:center;display:block">
        Voir mes stats 📊
      </a>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-btns" id="action-btns">
    <button class="action-btn btn-skip"  title="Pas intéressé" onclick="swipeLeft()">✕</button>
    <button class="action-btn btn-super" title="Super Like"    onclick="superLike()">⭐</button>
    <button class="action-btn btn-like"  title="J'aime"        onclick="swipeRight()">♥</button>
  </div>

  <!-- Bottom Nav -->
  <div class="bottom-nav">
    <a href="/home" class="active">
      <span class="nav-icon">🔥</span>Découvrir
    </a>
    <a href="/add-food">
      <span class="nav-icon">➕</span>Ajouter
    </a>
    <a href="/stats">
      <span class="nav-icon">📊</span>Mes stats
    </a>
  </div>

</div>

<script>
  /* ── Data from backend ── */
  let foods = <?= json_encode($foods) ?>;
  let stats = <?= json_encode($stats) ?>;
  let currentCardIndex = 0;

  const CAT_COLORS = [
    '#FF6B6B','#FF8E53','#FFC371','#4ECDC4','#45B7D1',
    '#96CEB4','#DDA0DD','#FF69B4','#20B2AA','#9370DB','#F08080','#3CB371',
  ];
  
  const ALL_CATS = [...new Set(foods.map(f => f.category_name))];
  const catColor = cat => CAT_COLORS[ALL_CATS.indexOf(cat) % CAT_COLORS.length];

  /* ── Card rendering ── */
  function renderCard(food, index) {
    const card = document.createElement('div');
    card.className = 'food-card';
    card.style.transform = `translateY(${index * 2}px) scale(${1 - index * 0.03})`;
    card.style.zIndex = foods.length - index;
    
    card.innerHTML = `
      <div class="card-image" style="background-image:url('${food.img}')">
        <div class="card-emoji">${food.emoji}</div>
        <div class="card-category" style="background-color:${catColor(food.category_name)}">${food.category_name}</div>
      </div>
      <div class="card-content">
        <h3>${food.name}</h3>
        <div class="card-meta">
          <span>⏱️ ${food.time} min</span>
          <span>🔥 ${food.cal} kcal</span>
          <span>⭐ ${food.rating}</span>
        </div>
        <p>${food.description}</p>
      </div>
    `;
    
    return card;
  }

  function renderDeck() {
    const stack = document.getElementById('card-stack');
    const emptyState = document.getElementById('empty-state');
    
    stack.innerHTML = '';
    
    if (foods.length === 0 || currentCardIndex >= foods.length) {
      stack.style.display = 'none';
      emptyState.style.display = 'block';
      return;
    }
    
    stack.style.display = 'block';
    emptyState.style.display = 'none';
    
    // Render up to 3 cards
    for (let i = 0; i < Math.min(3, foods.length - currentCardIndex); i++) {
      const card = renderCard(foods[currentCardIndex + i], i);
      stack.appendChild(card);
    }
  }

  /* ── Swipe actions ── */
  function performSwipe(type) {
    if (currentCardIndex >= foods.length) return;
    
    const currentFood = foods[currentCardIndex];
    const card = document.querySelector('.food-card');
    
    // Animate card
    if (type === 'like') {
      card.style.transform = 'translateX(150%) rotate(20deg)';
      card.style.opacity = '0';
    } else if (type === 'skip') {
      card.style.transform = 'translateX(-150%) rotate(-20deg)';
      card.style.opacity = '0';
    } else if (type === 'super') {
      card.style.transform = 'translateY(-100%) scale(1.2)';
      card.style.opacity = '0';
    }
    
    // Send to backend
    fetch('/swipe', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `food_id=${currentFood.id_food}&type=${type}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        foods = data.next_foods || [];
        stats = data.stats || stats;
        currentCardIndex++;
        
        setTimeout(() => {
          renderDeck();
          updateStats();
        }, 300);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }

  function swipeLeft() { performSwipe('skip'); }
  function swipeRight() { performSwipe('like'); }
  function superLike() { performSwipe('super'); }

  /* ── Stats display ── */
  function updateStats() {
    // Update stats display if needed
    console.log('Updated stats:', stats);
  }

  /* ── Keyboard support ── */
  document.addEventListener('keydown', e => {
    if (e.key === 'ArrowLeft') swipeLeft();
    if (e.key === 'ArrowRight') swipeRight();
    if (e.key === 'ArrowUp') superLike();
  });

  /* ── Initialize ── */
  document.addEventListener('DOMContentLoaded', () => {
    renderDeck();
    updateStats();
  });
</script>

</body>
</html>
