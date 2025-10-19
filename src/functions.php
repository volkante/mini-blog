<?php
declare(strict_types=1);

const DATA_FILE = __DIR__ . '/../data/posts.json';


function load_posts(): array {
  if(!file_exists(DATA_FILE)) return [];
  $json = file_get_contents(DATA_FILE);
  $data = json_decode($json, true);
  return is_array($data) ? $data : [];
}

function save_posts(array $posts): void {
  file_put_contents(DATA_FILE, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function create_post(string $title, string $content): array {
   $posts = load_posts();
   $id = bin2hex(random_bytes(4));
   $post = [
       'id' => $id,
       'title' => trim($title),
       'content' => trim($content),
       'created_at' => date('c'),
   ];
   array_unshift($posts, $post);
   save_posts($posts);
   return $post;
}

function find_post(string $id): ?array {
    foreach (load_posts() as $p) {
        if ($p['id'] === $id) return $p;
    }
    return null;
}

// to prevent XSS ?
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}