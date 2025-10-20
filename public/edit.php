<?php
require __DIR__ . '/../src/functions.php';

$id = (string)($_GET['id'] ?? '');
echo '<pre>';
    var_dump($_GET);
echo '</pre>';
$post = $id ? find_post($id) : null;

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    if (trim($title) === '') $errors[] = 'Title required';
    if (trim($content) === '') $errors[] = 'Content required';

    if (!$errors) {
        if (update_post($id, $title, $content)) {
            header('Location: /show.php?id=' . urlencode($id));
            exit;
        } else {
            $errors[] = 'Post not found';
        }
    }
} else {
    // form ilk açılışta mevcut değerleri doldursun
    if ($post) {
        $_POST['title'] = $post['title'];
        $_POST['content'] = $post['content'];
    }
}
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title><?= $post ? 'Edit: ' . e($post['title']) : 'Content not found' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{font-family: system-ui,-apple-system,Arial,sans-serif; margin:2rem auto; max-width:720px}
        label{display:block; margin:.5rem 0 .25rem}
        input,textarea{width:100%; padding:.6rem; border-radius:8px; border:1px solid #ccc}
        textarea{min-height:180px}
        .btn{margin-top:1rem; padding:.6rem 1rem; border-radius:8px; border:1px solid #0b5; background:#0b5; color:#fff}
        .error{background:#fee; border:1px solid #f99; padding:.6rem; border-radius:8px; margin:.5rem 0}
        a{color:#0b5; text-decoration:none}
    </style>
</head>
<body>
<?php if (!$post): ?>
    <h1>Content not found</h1>
    <p><a href="/">← Homepage</a></p>
<?php else: ?>
    <h1>Edit content</h1>

    <?php foreach ($errors as $e): ?>
        <div class="error"><?= e($e) ?></div>
    <?php endforeach; ?>

    <form method="post">
        <label for="title">Title</label>
        <input id="title" name="title" value="<?= e($_POST['title'] ?? '') ?>">

        <label for="content">Content</label>
        <textarea id="content" name="content"><?= e($_POST['content'] ?? '') ?></textarea>

        <button class="btn" type="submit">Update</button>
    </form>

    <p><a href="/show.php?id=<?= e($post['id']) ?>">← Back</a></p>
<?php endif; ?>
</body>
</html>

