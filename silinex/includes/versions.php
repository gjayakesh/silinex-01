<?php
/**
 * silinex/includes/versions.php
 * Version snapshot helpers used by silinex-cms/site/index.php
 */

function load_version_site_snapshot(?PDO $pdo, ?string $versionNumber): ?array {
    if (!$pdo || !$versionNumber) return null;

    try {
        $stmt = $pdo->prepare("SELECT snapshot_json FROM versions WHERE version_number = ? LIMIT 1");
        $stmt->execute([$versionNumber]);
        $row = $stmt->fetch();
    } catch (PDOException $e) {
        return null;
    }

    if (!$row) return null;
    return json_decode($row['snapshot_json'], true);
}
