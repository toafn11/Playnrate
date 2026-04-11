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
    $uploadDir = __DIR__ . '/uploads/';

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


function coverSrc(?string $filename): string
{
    if (empty($filename)) {
        return 'images/placeholder.png';
    }
    $path = __DIR__ . '/uploads/' . $filename;

    if (file_exists($path)) {
        return '/PlayNRate/uploads/' . htmlspecialchars($filename);
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
                        ORDER BY created_at DESC");
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
                return (int)$row['id'];
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

function getGameDetail(mysqli $conn, int $id)
{
    $stmt = $conn->prepare("SELECT g.*, gr.name AS genre
                            FROM games g
                            LEFT JOIN genres gr
                            ON g.genre_id = gr.id
                            WHERE g.id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            return $row;
        }
    }
    return false;
}

function getGamePlatform(mysqli $conn, int $id)
{
    $stmt = $conn->prepare("SELECT p.name AS name FROM platforms p
                            JOIN game_platforms gp
                            ON p.id = gp.platform_id
                            WHERE gp.game_id = ?");
    $stmt->bind_param('i', $id);
    $platforms = [];
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $platforms[] = $row['name'];
        }
    }
    return $platforms;
}

function addGame(mysqli $conn, array $data)
{
    $errors_list = [];

    $add = $conn->prepare("INSERT INTO games(title, description, genre_id, release_year, developer, publisher, cover_image)
                            VAlUES (?,?,?,?,?,?,?)");
    if (!$add) return ["db-error" => $conn->error];

    $add->bind_param(
        'ssiisss',
        $data['title'],
        $data['description'],
        $data['genre_id'],
        $data['release_year'],
        $data['developer'],
        $data['publisher'],
        $data['cover_image'],
    );

    if (!$add->execute()) $errors_list['game-add'] = "Cannot add game info.";

    $newid = $add->insert_id;
    if (!empty($data['platforms']) && is_array($data['platforms'])) {
        $ins = $conn->prepare("INSERT INTO game_platforms(game_id, platform_id) VALUES(?,?)");
        foreach ($data['platforms'] as $pid) {
            $platform_id = (int)$pid;
            $ins->bind_param('ii', $newid, $platform_id);
            $ins->execute();
        }
    }

    return empty($errors_list) ? (int)$newid : $errors_list;
}

function delGame(mysqli $conn, array $data)
{
    if ($data['cover_image'] && $data['cover_image'] !== 'default-cover.jpg') {
        $path = __DIR__ . '/uploads/' . $data['cover_image'];
        if (file_exists($path)) unlink($path);
    }
    $del = $conn->prepare("DELETE FROM games WHERE id = ?");
    $del->bind_param('i', $data['id']);
    if ($del->execute()) return true;
    return false;
}

function updateGame(mysqli $conn, array $data, int $id)
{
    $errors_list = [];

    $upd = $conn->prepare("UPDATE games SET title=?, description=?, genre_id=?, release_year=?, developer=?, publisher=?, cover_image=? WHERE id=?");
    if (!$upd) return ["db-error" => $conn->error];

    $upd->bind_param(
        'ssiisssi',
        $data['title'],
        $data['description'],
        $data['genre_id'],
        $data['release_year'],
        $data['developer'],
        $data['publisher'],
        $data['cover_image'],
        $id
    );

    if (!$upd->execute()) $errors_list['game-update'] = "Cannot update game info.";

    $del = $conn->prepare("DELETE FROM game_platforms WHERE game_id = ?");
    $del->bind_param('i', $id);
    $del->execute();

    if (!empty($data['platforms']) && is_array($data['platforms'])) {
        $ins = $conn->prepare("INSERT INTO game_platforms(game_id, platform_id) VALUES(?,?)");
        foreach ($data['platforms'] as $pid) {
            $platform_id = (int)$pid;
            $ins->bind_param('ii', $id, $platform_id);
            $ins->execute();
        }
    }

    return empty($errors_list) ? true : $errors_list;
}

function checkValidForm(array $data): array
{
    $errors = [];
    if (empty(trim($data['title'])) || strlen($data['title']) < 2)
        $errors['title'] = 'Title is required (min 2 chars).';

    if (empty($data['genre_id']))
        $errors['genre_id'] = 'Please select a genre.';

    $year = (int)($data['release_year'] ?? 0);
    if ($year < 1970 || $year > (date('Y') + 2))
        $errors['release_year'] = 'Enter a valid release year (1970 - ' . (date('Y') + 2) . ').';

    if (empty(trim($data['description'])) || strlen($data['description']) < 10)
        $errors['description'] = 'Description is required (min 10 chars).';

    return $errors;
}

function checkImgPath(string $currentImg)
{
    if (empty($_FILES['cover_image']['name'])) {
        return $currentImg;
    }

    $uploadError = '';
    $uploadedFileName = uploadCover($_FILES['cover_image'], $uploadError);

    if ($uploadedFileName) {
        if ($currentImg !== 'default-cover.jpg') {
            $oldPath = __DIR__ . '/uploads/' . $currentImg;
            if (file_exists($oldPath)) @unlink($oldPath);
        }
        return $uploadedFileName;
    }

    return false;
}

function getReview(mysqli $conn, int $id)
{
    $stmt = $conn->prepare("SELECT r.*, u.username FROM ratings r
                            JOIN users u
                            ON u.id = r.user_id
                            WHERE game_id = ? 
                            ORDER BY created_at DESC");
    if (!$stmt) return FALSE;

    $stmt->bind_param('i', $id);
    $reviews = [];

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function addReview(mysqli $conn, array $data)
{
    $stmt = $conn->prepare("
            INSERT INTO ratings(game_id, user_id, score, review_text) VALUES (?,?,?,?)
    ");
    if (!$stmt) return false;

    $stmt->bind_param('iiis', (int)$data['game_id'], (int)$data['user_id'], (int)$data['score'], $data['review_text']);
    if ($stmt->execute()) {
        return $conn->insert_id;
    }
    return false;
}

function viewMyReview(mysqli $conn, int $userid)
{
    $sql = "SELECT r.*, g.title AS game_title, g.id AS game_id, g.cover_image
            FROM ratings r
            JOIN games g ON r.game_id = g.id
            WHERE r.user_id = ?
            ORDER BY r.created_at DESC";

    $stmt = $conn->prepare($sql);

    if (!$stmt) return [];

    $stmt->bind_param('i', $userid);
    $reviews = [];

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function createReview(mysqli $conn, int $userid, int $gameid, int $score, string $text)
{
    $stmt = $conn->prepare("INSERT INTO ratings(game_id, user_id, score, review_text)
                            VALUES (?,?,?,?)");
    $stmt->bind_param('iiis', $gameid, $userid, $score, $text);
    if ($stmt->execute()) return true;
    return false;
}


function checkUserReviewed(mysqli $conn, int $userid, int $gameid)
{
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM ratings WHERE user_id = ? AND game_id = ?");
    if (!$stmt) return false;
    $stmt->bind_param("ii", $userid, $gameid);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['count'] > 0) {
        return true;
    }

    return false;
}


function getAllGenres(mysqli $conn)
{
    return $conn->query("SELECT * FROM genres ORDER BY name");
}

function getAllPlatforms(mysqli $conn)
{
    return $conn->query("SELECT * FROM platforms ORDER BY name");
}
