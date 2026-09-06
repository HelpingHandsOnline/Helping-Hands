<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

const DB_HOST = 'localhost';
const DB_NAME = 'helpinghands_db';
const DB_USER = 'root';
const DB_PASS = '';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die('<!doctype html><html><head><meta charset="utf-8"><title>Database Setup Required</title><link rel="stylesheet" href="common.css"></head><body><main class="setup-error"><div class="panel"><div class="brand-mark">HH</div><h1>Helping Hands needs its database</h1><p>Apache and PHP are running, but MySQL is not connected to <strong>' . DB_NAME . '</strong>.</p><ol><li>Open XAMPP and start <strong>Apache</strong> and <strong>MySQL</strong>.</li><li>Open <strong>http://localhost/helping-hands/setup_local.php</strong>.</li><li>Run the setup once, then return to the home page.</li></ol><p class="muted">For InfinityFree, use the database credentials supplied by your hosting account in <strong>config.php</strong>.</p></div></main></body></html>');
}

function h(mixed $value): string { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function logged_in(): bool { return isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] > 0; }
function require_login(string $next = ''): void { if (!logged_in()) redirect('login.php' . ($next !== '' ? '?next=' . urlencode($next) : '')); }
function user(): ?array { global $pdo; if (!logged_in()) return null; $stmt=$pdo->prepare('SELECT * FROM users WHERE id=?'); $stmt->execute([(int)$_SESSION['user_id']]); return $stmt->fetch() ?: null; }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Invalid form token. Please refresh the page and try again.'); } }
function flash(string $type, string $message): void { $_SESSION['flash']=['type'=>$type,'message'=>$message]; }
function get_flash(): ?array { $f=$_SESSION['flash']??null; unset($_SESSION['flash']); return $f; }
