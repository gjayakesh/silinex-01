<?php
// api/search.php – Fast server-side search with relevance scoring
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

require_once __DIR__ . '/../includes/config.php';

$q     = trim($_GET['q'] ?? '');
$limit = min((int)($_GET['limit'] ?? 10), 20);

if (strlen($q) < 2) { echo json_encode([]); exit; }

$results = search_index($q, $search_index, $limit);
echo json_encode($results, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

/* ── Core search function ────────────────────────────────────── */
function search_index(string $q, array $index, int $limit): array {
    $terms   = array_filter(array_map('trim', explode(' ', strtolower($q))));
    $scored  = [];

    foreach ($index as $item) {
        $score = 0;
        $haystack = strtolower($item['title'] . ' ' . $item['desc'] . ' ' . ($item['tags'] ?? ''));

        foreach ($terms as $term) {
            // Exact title match – highest weight
            if (str_contains(strtolower($item['title']), $term)) $score += 10;
            // Desc match
            if (str_contains(strtolower($item['desc']), $term))  $score += 5;
            // Tags match
            if (str_contains(strtolower($item['tags'] ?? ''), $term)) $score += 3;
            // Fuzzy: partial char match
            if (similar_text($term, strtolower($item['title'])) / max(strlen($term),1) > 0.6) $score += 2;
        }

        if ($score > 0) {
            $scored[] = [
                'title' => $item['title'],
                'url'   => $item['url'],
                'desc'  => substr($item['desc'], 0, 120) . (strlen($item['desc']) > 120 ? '…' : ''),
                'score' => $score,
            ];
        }
    }

    usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);
    return array_slice(array_map(fn($r) => ['title'=>$r['title'],'url'=>$r['url'],'desc'=>$r['desc']], $scored), 0, $limit);
}
