<?php
require_once 'db-connect.php';
require_once 'functions.php';
$page_title = 'Games';

$search  = trim($_GET['search'] ?? '');
$genreId = (int)($_GET['genre'] ?? 0);
$sort    = in_array($_GET['sort'] ?? '', ['newest','oldest','top_rated','most_reviews','a_z','z_a'])
           ? $_GET['sort'] : 'newest';
$page    = max(1, (int)($_GET['page'] ?? 1));
$perPage = 18;

$result     = getFilteredGames($conn, $search, $genreId, $sort, $perPage, $page);
$games      = $result['games'];
$total      = $result['total'];
$totalPages = max(1, (int)ceil($total / $perPage));
$page       = min($page, $totalPages);

$genres = getAllGenres($conn);

// Build query string helper (preserves current filters, replaces $key)
function buildQuery(array $override): string
{
    $base = [
        'search' => $_GET['search'] ?? '',
        'genre'  => $_GET['genre']  ?? '',
        'sort'   => $_GET['sort']   ?? 'newest',
        'page'   => $_GET['page']   ?? 1,
    ];
    return http_build_query(array_filter(array_merge($base, $override), fn($v) => $v !== '' && $v !== '0' && $v !== 0));
}

require_once 'header.php'; ?>

<div class="welcome-section">
    <div class="container">
        <h1>Discover the Whole World of Games</h1>
        <p>Your ultimate destination for game reviews and ratings. Explore our collection of games, read honest reviews, and share your own experiences with the gaming community.</p>
    </div>
</div>

<section class="container">
    <form class="filter-bar" method="get" action="games.php">
        <div class="filter-search">
            <input type="text" name="search" placeholder="Search games…"
                   value="<?= sanitize($search) ?>" autocomplete="off">
        </div>
        <div class="filter-selects">
            <select name="genre">
                <option value="">All Genres</option>
                <?php while ($g = $genres->fetch_assoc()): ?>
                    <option value="<?= (int)$g['id'] ?>"<?= $genreId === (int)$g['id'] ? ' selected' : '' ?>>
                        <?= sanitize($g['name']) ?>
                    </option>
                <?php endwhile ?>
            </select>
            <select name="sort">
                <option value="newest"       <?= $sort === 'newest'       ? 'selected' : '' ?>>Newest</option>
                <option value="oldest"       <?= $sort === 'oldest'       ? 'selected' : '' ?>>Oldest</option>
                <option value="top_rated"    <?= $sort === 'top_rated'    ? 'selected' : '' ?>>Top Rated</option>
                <option value="most_reviews" <?= $sort === 'most_reviews' ? 'selected' : '' ?>>Most Reviews</option>
                <option value="a_z"          <?= $sort === 'a_z'          ? 'selected' : '' ?>>A – Z</option>
                <option value="z_a"          <?= $sort === 'z_a'          ? 'selected' : '' ?>>Z – A</option>
            </select>
            <button type="submit" class="btn-filter">Search</button>
            <?php if ($search !== '' || $genreId > 0 || $sort !== 'newest'): ?>
                <a href="games.php" class="btn-filter btn-filter-clear">Clear</a>
            <?php endif ?>
        </div>
    </form>

    <div class="filter-info">
        <?php if ($search !== '' || $genreId > 0): ?>
            <span class="text-muted"><?= $total ?> game<?= $total !== 1 ? 's' : '' ?> found</span>
        <?php else: ?>
            <span class="text-muted"><?= $total ?> game<?= $total !== 1 ? 's' : '' ?></span>
        <?php endif ?>
    </div>

    <?php if ($games): ?>
        <div class="grid-games">
            <?php foreach ($games as $g): ?>
                <a href="game-detail.php?id=<?= (int)$g['id'] ?>" class="game-card">
                    <img src="<?= coverSrc($g['cover_image']) ?>" alt="<?= sanitize($g['title']) ?>">
                    <div class="card-title">
                        <p><?= sanitize($g['title']) ?></p>
                        <div class="card-info">
                            <div class="genres-box"><?= sanitize($g['genre']) ?></div>
                            <div class="release-box"><?= (int)$g['release_year'] ?></div>
                        </div>
                    </div>
                    <div class="card-main">
                        <div class="rating-badge" style="background-color: var(--score-<?= (int)$g['avg_rating'] ?>)">✯ <?= number_format($g['avg_rating'], 1) ?></div>
                        <div class="text-muted"><?= (int)$g['rating_count'] ?> Reviews</div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <div class="no-results">
            <p>No games found. Try a different search or filter.</p>
            <a href="games.php" class="btn-filter">Show all games</a>
        </div>
    <?php endif ?>

    <?php if ($totalPages > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a href="?<?= buildQuery(['page' => $page - 1]) ?>" class="page-btn">&#8592;</a>
            <?php endif ?>

            <?php
            $start = max(1, $page - 2);
            $end   = min($totalPages, $page + 2);
            if ($start > 1): ?>
                <a href="?<?= buildQuery(['page' => 1]) ?>" class="page-btn">1</a>
                <?php if ($start > 2): ?><span class="page-dots">…</span><?php endif ?>
            <?php endif ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="?<?= buildQuery(['page' => $i]) ?>"
                   class="page-btn<?= $i === $page ? ' page-btn-active' : '' ?>"><?= $i ?></a>
            <?php endfor ?>

            <?php if ($end < $totalPages): ?>
                <?php if ($end < $totalPages - 1): ?><span class="page-dots">…</span><?php endif ?>
                <a href="?<?= buildQuery(['page' => $totalPages]) ?>" class="page-btn"><?= $totalPages ?></a>
            <?php endif ?>

            <?php if ($page < $totalPages): ?>
                <a href="?<?= buildQuery(['page' => $page + 1]) ?>" class="page-btn">&#8594;</a>
            <?php endif ?>
        </nav>
    <?php endif ?>
</section>

<?php require_once 'footer.php'; ?>
