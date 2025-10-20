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

function update_post(string $id, string $title, string $content): bool {
    $posts = load_posts();
    $updated = false;
    foreach ($posts as &$p) {
        if ($p['id'] === $id) {
            $p['title'] = trim($title);
            $p['content'] = trim($content);
            $updated = true;
            break;
        }
    }
    if ($updated) save_posts($posts);
    return $updated;
}

function delete_post(string $id): bool {
    $posts = load_posts();
    $before = count($posts);
    // array_values yeniden index atamak için filtre edilmiş associative arr'a.
    $posts = array_values(array_filter($posts, fn($p) => $p['id'] !== $id));
    $after = count($posts);
    if ($after < $before) {
        save_posts($posts);
        return true;
    }
    return false;
}



// to prevent XSS ?
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}