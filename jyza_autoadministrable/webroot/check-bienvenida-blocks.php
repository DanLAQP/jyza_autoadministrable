<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

echo "<h2>📋 Bloques de BIENVENIDA (que funciona)</h2>";

$query = "
    SELECT cb.id, cb.block_key, cb.block_type, cb.content, cb.sort_order
    FROM content_blocks cb
    JOIN content_sections cs ON cb.section_id = cs.id
    WHERE cs.slug = 'bienvenida'
    ORDER BY cb.sort_order ASC
";

$result = $mysqli->query($query);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Block Key</th><th>Type</th><th>Content</th><th>Order</th></tr>";

while ($row = $result->fetch_object()) {
    echo "<tr>";
    echo "<td>{$row->id}</td>";
    echo "<td><strong>{$row->block_key}</strong></td>";
    echo "<td><span style='background:#ccc; padding:3px;'>{$row->block_type}</span></td>";
    echo "<td>" . htmlspecialchars(substr($row->content, 0, 50)) . "</td>";
    echo "<td>{$row->sort_order}</td>";
    echo "</tr>";
}

echo "</table>";

echo "<hr>";

echo "<h2>📋 Bloques de PORQUEELEGIRNOS (que NO funciona)</h2>";

$query2 = "
    SELECT cb.id, cb.block_key, cb.block_type, cb.content, cb.sort_order
    FROM content_blocks cb
    JOIN content_sections cs ON cb.section_id = cs.id
    WHERE cs.slug = 'porqueelegirnos'
    ORDER BY cb.sort_order ASC
";

$result2 = $mysqli->query($query2);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Block Key</th><th>Type</th><th>Content</th><th>Order</th></tr>";

while ($row = $result2->fetch_object()) {
    echo "<tr>";
    echo "<td>{$row->id}</td>";
    echo "<td><strong>{$row->block_key}</strong></td>";
    echo "<td><span style='background:#ccc; padding:3px;'>{$row->block_type}</span></td>";
    echo "<td>" . htmlspecialchars(substr($row->content, 0, 50)) . "</td>";
    echo "<td>{$row->sort_order}</td>";
    echo "</tr>";
}

echo "</table>";

$mysqli->close();
?>
