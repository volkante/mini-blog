<?php
require __DIR__ . '/../src/functions.php';
$id = (string) ($_GET['id']) ?? '';
$post = $id ? find_post($id) : null;
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title><?= $post ? e($post['title']) . ' - Mini Blog' : 'Not found - Mini Blog' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{font-family: system-ui,-apple-system,Arial,sans-serif; margin:2rem auto; max-width:720px; line-height:1.6}
        .muted{color:#666}
        a{color:#0b5; text-decoration:none}
    </style>
</head>
<body>
    <?php if (!$post): ?>
        <h1>Post not found</h1>
        <p><a href="/"> ← Homepage </a></p>
    <?php else: ?>
        <h1><?= e($post['title']) ?></h1>
        <p class="muted"><?= e(date('d.m.Y H:i', strtotime($post['created_at']))) ?></p>
        <p><?= nl2br(e($post['content']))  ?></p>
        <p><a href="/">← Homepage</a></p>
    <?php endif; ?>
</body>
</html>