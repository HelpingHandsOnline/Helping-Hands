<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$host='localhost'; $user='root'; $pass=''; $db='helpinghands_db';
$message=''; $ok=false;
try {
  $pdo=new PDO("mysql:host=$host;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
  $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
  $pdo->exec("USE `$db`");
  $sql=file_get_contents(__DIR__.'/schema.sql');
  foreach (array_filter(array_map('trim', preg_split('/;\s*(?:\r?\n|$)/',$sql))) as $statement) { if (strpos($statement,'--')===0) { $statement=preg_replace('/^(?:--.*\r?\n)+/','',$statement); } if(trim($statement)) $pdo->exec($statement); }
  $ok=true; $message='Database and tables created successfully.';
} catch(Throwable $e) { $message=$e->getMessage(); }
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Helping Hands Setup</title><link rel="stylesheet" href="common.css"></head><body><main class="setup-error"><div class="panel"><div class="brand-mark">HH</div><h1>Helping Hands setup</h1><div class="alert <?php echo $ok?'success':'error'; ?>"><?php echo htmlspecialchars($message,ENT_QUOTES,'UTF-8'); ?></div><?php if($ok): ?><p>Your database <strong><?php echo $db; ?></strong> is ready.</p><a class="btn primary" href="database_check.php">Check database</a> <a class="btn secondary" href="index.php">Open Helping Hands</a><?php else: ?><p>Make sure MySQL is running in XAMPP, then refresh this page.</p><a class="btn secondary" href="setup_local.php">Try again</a><?php endif; ?><p class="muted">Delete or rename setup_local.php after successful deployment for a cleaner production setup.</p></div></main></body></html>
