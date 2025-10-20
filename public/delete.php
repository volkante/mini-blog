<?php
require __DIR__ . '/../src/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

$id = (string)($_POST['id'] ?? '');
if ($id && delete_post($id)) {
    header('Location: /');
    exit;
}

http_response_code(404);
echo 'Post not found';