<?php
require __DIR__ . '/../src/functions.php';
$posts = load_posts();
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>Volkan's Mini Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{font-family: system-ui,-apple-system,Arial,sans-serif; margin:2rem auto; max-width:720px; line-height:1.5}
        header,footer{display:flex; justify-content:space-between; align-items:center}
        a{color:#0b5; text-decoration:none}
        a:hover{text-decoration:underline}
        .card{border:1px solid #ddd; border-radius:12px; padding:1rem; margin:.75rem 0}
        .muted{color:#666; font-size:.9rem}
        .btn{display:inline-block; padding:.5rem .8rem; border-radius:8px; border:1px solid #0b5}
        .btn:hover{background:#0b5; color:#fff}
    </style>
</head>
<body>
    <header>
        <h1>Volkan's Mini Blog</h1>
        <a href="/new.php">New Blog Post</a>
    </header>

    <?php if (empty($posts)): ?>
        <p>No posts yet! <a href="/new.php">Add your first post</a> 🎉</p>
    <?php else: ?>
        <?php foreach ($posts as $p): ?>
            <article class="card">
                <h2><a href="/show.php?id=<?= e($p['id']) ?>"><?= e($p['title']) ?></a></h2>
                <p class="muted"><?= e(date('d.m.Y H:i', strtotime($p['created_at']))) ?></p>
                <p><?= nl2br(e(mb_strimwidth($p['content'], 0, 200, '…'))) ?></p>
                <a href="/show.php?id=<?= e($p['id']) ?>">Read →</a>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>

    <footer class="muted">
        <span>PHP Mini Blog</span>
        <a href="/">Homepage</a>
    </footer>
</body>
</html>

