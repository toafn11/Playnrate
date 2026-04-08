<?php

/**
 * Sanitise a string from user input.
 */
function sanitize(string $value): string
{
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a URL.
 */
function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/**
 * Render star rating HTML (out of 10 mapped to 5 stars).
 */
function starRating(float $score): string
{
    $full  = (int) round($score / 2);
    $empty = 5 - $full;
    $html  = '<span class="stars" title="' . number_format($score, 1) . '/10">';
    $html .= str_repeat('<i class="star full">★</i>', $full);
    $html .= str_repeat('<i class="star empty">☆</i>', $empty);
    $html .= '</span>';
    return $html;
}

/**
 * Handle cover image upload. Returns filename on success, false on failure.
 */
function uploadCover(array $file, string &$error): string|false
{
    $allowed   = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $maxBytes  = 2 * 1024 * 1024; // 2 MB
    $uploadDir = __DIR__ . '/../uploads/';

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Upload error code: ' . $file['error'];
        return false;
    }
    if (!in_array($file['type'], $allowed)) {
        $error = 'Only JPG, PNG, WebP or GIF images are allowed.';
        return false;
    }
    if ($file['size'] > $maxBytes) {
        $error = 'Image must be smaller than 2 MB.';
        return false;
    }

    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('cover_', true) . '.' . strtolower($ext);
    $dest     = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        $error = 'Failed to move uploaded file. Check folder permissions.';
        return false;
    }

    return $filename;
}

/**
 * Return a cover image path (falls back to placeholder).
 */
function coverSrc(string $filename): string
{
    $path = __DIR__ . '/../uploads/' . $filename;
    if ($filename && file_exists($path)) {
        return 'uploads/' . htmlspecialchars($filename);
    }
    return 'images/placeholder.png';
}

/**
 * Paginate helper – returns [offset, totalPages].
 */
function paginate(int $total, int $perPage, int $page): array
{
    $totalPages = max(1, (int) ceil($total / $perPage));
    $page       = max(1, min($page, $totalPages));
    $offset     = ($page - 1) * $perPage;
    return [$offset, $totalPages, $page];
}

function getTopGames(mysqli $conn, int $limit): array
{
    $stmt = $conn->query("SELECT g.*, gr.name AS genre
                        FROM games g
                        LEFT JOIN genres gr ON g.genre_id = gr.id
                        WHERE g.rating_count >= 1
                        ORDER BY g.avg_rating DESC, g.rating_count DESC
                        LIMIT $limit");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getAllGames(mysqli $conn): array
{
    $stmt = $conn->query("SELECT g.*, gr.name AS genre
                        FROM games g
                        LEFT JOIN genres gr ON g.genre_id = gr.id
                        ORDER BY g.title ASC");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getRecentGames(mysqli $conn, int $limit): array
{
    $stmt = $conn->query("SELECT g.*, gr.name AS genre
                        FROM games g
                        LEFT JOIN genres gr ON g.genre_id = gr.id
                        ORDER BY g.created_at DESC
                        LIMIT $limit");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getStat(mysqli $conn): array
{
    $totalGames = $conn->query("SELECT COUNT(*) as c FROM games");
    $totalReviews = $conn->query("SELECT COUNT(*) as c FROM ratings");
    $totalGenres = $conn->query("SELECT COUNT(*) as c FROM genres");
    return [
        "Game" => $totalGames->fetch_assoc()['c'],
        "Review" => $totalReviews->fetch_assoc()['c'],
        "Genres" => $totalGenres->fetch_assoc()['c']
    ];
}


function addUsers(mysqli $conn, string $username, string $pwd)
{
    $stmt = $conn->prepare("INSERT INTO users(username, password) VALUE (?,?)");
    $stmt->bind_param("ss", $username, $pwd);
    if ($stmt->execute())
        return $stmt->insert_id;
    return false;
}

function getLogin(mysqli $conn, string $username, string $pwd)
{
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");

    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            if (password_verify($pwd, $row['password'])) {
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    return false;
}

function checkPasswordMatch(string $password, string $retype_password)
{
    if (empty($password) || empty($retype_password)) {
        return "Password cannot blank!";
    }

    if (strlen($password) < 6) {
        return "Please enter more than 6 digits password!";
    }

    if ($password !== $retype_password) {
        return "Retype password does not match!";
    }
}
function addGame(mysqli $conn, array $data) 
{
    $stmt = $conn->prepare("
            INSERT INTO games (title, description, genre_id, release_year, developer, publisher, cover_image)
            VALUES (?,?,?,?,?,?,?)
        ");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('ssiisss', $data['title'], $data['description'], (int)$data['genre_id'], (int)$data['release_year'], $data['developer'], $data['publisher'], $data['coverFile']);
    if ($stmt->execute()) {
        return $conn->insert_id;
    }
    return false;
}
function delGame(mysqli $conn, int $id)
{
    $stmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        return true;
    }
    return false; 
}
function updateGame(mysqli $conn, array $data, int $id)
{
    $upd = $conn->prepare("
            UPDATE games SET title=?, description=?, genre_id=?, release_year=?, developer=?, publisher=?, cover_image=?
            WHERE id=?");
    if(!$upd) {
        return false;
    }
    $upd->bind_param('ssiisssi', $data['title'], $data['description'], (int)$data['genre_id'], (int)$data['release_year'], $data['developer'], $data['publisher'], $data['coverFile'], $id);
    if($upd->execute()) {
        return $upd->affected_rows > 0;
    }
    return false;
}
function updateGamePlatforms(mysqli $conn, int $game_id, array $platform_ids)
{
    $del = $conn->prepare("DELETE FROM game_platforms WHERE game_id = ?");
    if(!$del) return false;
    $del->bind_param('i', $game_id);
    $del->execute();

    if(empty($platform_ids)) {
        return true;
    }

    $ins = $conn->prepare("
            INSERT INTO game_platforms(game_id, platform_id)
            VALUES(?,?)
    ");
    if(!$ins) return false;

    foreach($platform_ids AS $pid) {
        $pid = (int)$pid;
        $ins->bind_param('ii', $game_id, $pid);
        $ins->execute();
    }
    return true;
}
function getReview(mysqli $conn, int $id) 
{
    $stmt = $conn->prepare("SELECT * FROM ratings WHERE game_id = ? ORDER BY created_at DESC");
    if(!$stmt) return FALSE;

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function addReview(mysqli $conn, Array $data) 
{
    $stmt = $conn->prepare("
            INSERT INTO ratings(game_id, user_id, score, review_text) VALUES (?,?,?,?)
    ");
    if(!$stmt) return false;

    $stmt->bind_param('iiis', (int)$data['game_id'], (int)$data['user_id'], (int)$data['score'], $data['review_text']);
    if ($stmt->execute()) {
        return $conn->insert_id;
    }
    return false;
}