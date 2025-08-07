<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

// Get featured news
$featuredNews = getFeaturedNews();

// Get recent news for sidebar
$recentNews = getAllNews(3);

// Get recent activities for sidebar
$recentActivities = getAllActivities(4);

// Get additional news for bottom section
$additionalNews = getAllNews(2);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Karang Taruna 01/03</title>
  <link rel="icon" href="assets/images/katar.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f5f5;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 10px;
    }

    .news-img {
      max-height: 450px;
      object-fit: cover;
    }

    .card-body h2 {
      font-size: 1.8rem;
    }

    .card-body p {
      font-size: 1.1rem;
    }

    .category-title {
      background-color: #1455a4;
      color: white;
      padding: 10px;
      font-weight: bold;
    }

    .sidebar-news .card-text {
      font-size: 1.05rem;
    }

    .sidebar-news strong {
      font-size: 1.1rem;
    }

    .sidebar-news small {
      font-size: 1rem;
    }

    .gallery-img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      transition: transform 0.3s ease;
      border-radius: 10px;
    }

    .gallery-img:hover {
      transform: scale(1.05);
    }

    .gallery-title {
      background-color: #1455a4;
      color: white;
      padding: 15px;
      font-size: 1.5rem;
      text-align: center;
      font-weight: bold;
      border-radius: 5px;
      margin-bottom: 30px;
    }

    .caption {
      text-align: center;
      margin-top: 10px;
      font-weight: 500;
    }

    footer a {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/images/katar.png" alt="Logo Karang Taruna" />
      <strong>KARANG TARUNA</strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">HOME</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">PROFIL</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="struktur.html">Struktur Organisasi</a></li>
            <li><a class="dropdown-item" href="visimisi.html">Visi dan Misi</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">KEGIATAN</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="programunggulan.html">Program Unggulan</a></li>
            <li><a class="dropdown-item" href="#">Kerja Sama</a></li>
          </ul>
        </li>
        <?php if (isLoggedIn()): ?>
          <?php if (isAdmin()): ?>
            <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">ADMIN</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">LOGOUT</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">LOGIN</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Headline -->
<div class="container mt-4">
  <div class="row">
    <!-- Berita Utama -->
    <div class="col-md-8">
      <?php if ($featuredNews): ?>
        <div class="card">
          <img src="<?= htmlspecialchars($featuredNews['image_url']) ?>" class="card-img-top news-img" alt="<?= htmlspecialchars($featuredNews['title']) ?>" />
          <div class="card-body">
            <span class="badge bg-gradient bg-success mb-3 px-3 py-2 rounded-pill shadow-sm">
              <i class="bi bi-newspaper me-1"></i> <?= htmlspecialchars($featuredNews['category']) ?>
            </span>
            <h2 class="text-primary fw-bold mb-3 border-bottom pb-2">
              <i class="bi bi-exclamation-circle-fill text-danger me-2"></i>
              <?= htmlspecialchars($featuredNews['title']) ?>
            </h2>
            <p class="card-text lh-lg text-justify">
              <?= htmlspecialchars($featuredNews['excerpt'] ?: truncateText($featuredNews['content'], 200)) ?>
            </p>
            <div class="bg-light p-3 rounded shadow-sm mb-3">
              <p class="fst-italic text-dark mb-1">
                <i class="bi bi-quote text-warning fs-4 me-2"></i>
                "<?= htmlspecialchars(truncateText($featuredNews['content'], 100)) ?>"
              </p>
              <footer class="blockquote-footer mt-2">Penulis: <cite><?= htmlspecialchars($featuredNews['author_name']) ?></cite></footer>
            </div>
            <p class="card-text text-justify">
              <?= htmlspecialchars(truncateText($featuredNews['content'], 300)) ?>
            </p>
            <div class="text-end">
              <small class="text-muted">Dipublikasikan: <?= formatDateIndonesian($featuredNews['created_at']) ?></small>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="card">
          <div class="card-body text-center">
            <h3>Belum ada berita tersedia</h3>
            <p class="text-muted">Silakan kembali lagi nanti untuk berita terbaru.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>

   <!-- Sidebar -->
<div class="col-md-4">
  <!-- Kalender & Waktu -->
  <div class="datetime-container mb-3 p-3 bg-white rounded shadow-sm text-center">
    <div class="date" id="date" style="font-size:16px; font-weight:bold; color:#333;"></div>
    <div class="time" id="time" style="font-size:20px; font-weight:bold; color:#007bff;"></div>
  </div>

  <!-- Agenda Kegiatan -->
  <div class="category-title text-center rounded-top">📰 Agenda Kegiatan</div>
  <div class="sidebar-news mt-2">
    <?php foreach ($recentActivities as $activity): ?>
      <div class="card mb-3 shadow-sm border-0">
        <div class="row g-0 align-items-center">
          <div class="col-4">
            <img src="<?= htmlspecialchars($activity['image_url'] ?: 'assets/images/img/default.jpg') ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($activity['title']) ?>">
          </div>
          <div class="col-8">
            <div class="card-body py-2 px-3">
              <div class="d-flex align-items-start">
                <div class="me-2 text-success fs-5">
                  <?php
                  $icons = [
                    'event' => '🎯',
                    'program' => '🏆',
                    'competition' => '⚽'
                  ];
                  echo $icons[$activity['activity_type']] ?? '📅';
                  ?>
                </div>
                <div>
                  <p class="card-text mb-1 text-dark">
                    <strong><?= htmlspecialchars($activity['status'] === 'upcoming' ? 'Coming Soon:' : 'KABAR:') ?></strong> 
                    <?= htmlspecialchars(truncateText($activity['title'], 50)) ?>
                  </p>
                  <small class="text-muted">
                    <?= $activity['event_date'] ? formatDateIndonesian($activity['event_date']) : 'Segera' ?>
                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Galeri -->
<div class="container mt-5">
  <div class="gallery-title">Galeri Kegiatan Karang Taruna</div>
  <div class="row g-4">
    <div class="col-md-4 col-sm-6"><img src="assets/images/img_kegiatan/festival.jpeg" class="gallery-img"><p class="caption">Festival Pemuda</p></div>
    <div class="col-md-4 col-sm-6"><img src="assets/images/img_kegiatan/donordarah.jpg" class="gallery-img"><p class="caption">Donor Darah</p></div>
    <div class="col-md-4 col-sm-6"><img src="assets/images/img_kegiatan/bola.jpg" class="gallery-img"><p class="caption">Karang Taruna Cup</p></div>
    <div class="col-md-4 col-sm-6"><img src="assets/images/img_kegiatan/kesehatan.jpg" class="gallery-img"><p class="caption">Pemeriksaan Kesehatan</p></div>
  </div>
</div>

<!-- Kabar Nasional -->
<div class="container mt-5">
  <div class="category-title">KABAR TERBARU</div>
  <div class="row mt-3">
    <?php foreach ($additionalNews as $news): ?>
      <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0 hover-card">
          <img src="<?= htmlspecialchars($news['image_url']) ?>" class="card-img-top rounded-top" alt="<?= htmlspecialchars($news['title']) ?>">
          <div class="card-body d-flex flex-column">
            <h6 class="card-title fw-bold text-dark mb-2">
              <?= htmlspecialchars($news['title']) ?>
            </h6>
            <p class="text-muted small mb-3">
              <?= htmlspecialchars($news['excerpt'] ?: truncateText($news['content'], 100)) ?>
            </p>
            <div class="mt-auto">
              <small class="text-muted">
                <?= formatDateIndonesian($news['created_at']) ?> | <?= htmlspecialchars($news['author_name']) ?>
              </small>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-4 mt-5">
  <p class="mb-1">&copy; 2025 Karang Taruna</p>
  <p>
    Ikuti kami di:
    <a href="#" class="text-white fw-bold">Facebook</a> |
    <a href="https://www.instagram.com/karangtaruna01.03" class="text-white fw-bold">Instagram</a> |
    <a href="#" class="text-white fw-bold">YouTube</a>
  </p>
</footer>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateDateTime() {
  const now = new Date();
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const dateString = now.toLocaleDateString('id-ID', options);

  let hours = now.getHours();
  let minutes = now.getMinutes();
  let seconds = now.getSeconds();
  hours = hours < 10 ? '0' + hours : hours;
  minutes = minutes < 10 ? '0' + minutes : minutes;
  seconds = seconds < 10 ? '0' + seconds : seconds;

  const timeString = `${hours}:${minutes}:${seconds}`;

  document.getElementById('date').textContent = dateString;
  document.getElementById('time').textContent = timeString;
}
setInterval(updateDateTime, 1000);
updateDateTime();
</script>

</body>
</html>

