<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

try {
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    $mysqli->set_charset('utf8mb4');

    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed: ' . $mysqli->connect_error);
    }

    echo "✅ Connected to database\n";

    // Check if clubjyza section exists
    $sectionResult = $mysqli->query("SELECT id, slug FROM content_sections WHERE slug = 'clubjyza'");
    if ($sectionResult->num_rows > 0) {
        $section = $sectionResult->fetch_assoc();
        echo "✅ Section 'clubjyza' exists with ID: " . $section['id'] . "\n";
        $sectionId = $section['id'];

        // Count blocks in clubjyza
        $blocksResult = $mysqli->query("SELECT COUNT(*) as count FROM content_blocks WHERE section_id = $sectionId");
        $blocksCount = $blocksResult->fetch_assoc()['count'];
        echo "✅ Found $blocksCount blocks in clubjyza section\n";

        // Show sample blocks
        $samplesResult = $mysqli->query("SELECT block_key, block_type, is_active FROM content_blocks WHERE section_id = $sectionId LIMIT 10");
        echo "\nSample blocks:\n";
        while ($block = $samplesResult->fetch_assoc()) {
            echo "  - {$block['block_key']} ({$block['block_type']}) - active: {$block['is_active']}\n";
        }
    } else {
        echo "❌ Section 'clubjyza' not found\n";
    }

    // Check content_images table structure
    $columnsResult = $mysqli->query("DESCRIBE content_images");
    echo "\nContent_images columns:\n";
    while ($col = $columnsResult->fetch_assoc()) {
        echo "  - {$col['Field']} ({$col['Type']}) nullable: {$col['Null']}\n";
    }

    // Count images
    $imagesCount = $mysqli->query("SELECT COUNT(*) as count FROM content_images")->fetch_assoc()['count'];
    echo "\n✅ Total images in database: $imagesCount\n";

    $mysqli->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
