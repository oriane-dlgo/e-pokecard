<?php
// Script utilitaire pour convertir un dump SQL en tableau PHP pour CodeIgniter 4
// Compatible PHP 8.4+

$inputFile = 'temp_dump.sql';

if (!file_exists($inputFile)) {
    die(" Fichier $inputFile introuvable.\n");
}

$content = file_get_contents($inputFile);
$lines = explode("\n", $content);

echo "\n------------------------------------------------------------\n";
echo " CODE À COPIER DANS FullDataSeeder.php\n";
echo "------------------------------------------------------------\n\n";

$currentTable = '';

foreach ($lines as $line) {
    // On cherche les lignes qui commencent par INSERT INTO
    if (preg_match('/INSERT INTO `(\w+)` \((.*?)\) VALUES (.*);/', $line, $matches)) {
        $table = $matches[1];
        $columns = str_replace('`', '', $matches[2]);
        $columnsList = explode(', ', $columns); // Liste des noms de colonnes

        $valuesPart = $matches[3];

        // On sépare les groupes de valeurs
        preg_match_all('/\((.*?)\)/', $valuesPart, $valueGroups);

        if ($table !== $currentTable) {
            if ($currentTable !== '') echo "        ];\n        \$this->db->table('$currentTable')->insertBatch(\$$currentTable);\n\n";
            echo "        // " . strtoupper($table) . "\n";
            echo "        \$$table = [\n";
            $currentTable = $table;
        }

        foreach ($valueGroups[1] as $valString) {
            // CORRECTION PHP 8.4 : Ajout du 4ème paramètre d'échappement ("\\")
            $valArray = str_getcsv($valString, ",", "'", "\\");

            echo "            [";
            foreach ($columnsList as $index => $colName) {
                $val = $valArray[$index] ?? 'NULL';

                if (is_numeric($val)) {
                    echo "'$colName' => $val";
                } elseif ($val === 'NULL') {
                    echo "'$colName' => NULL";
                } else {
                    $safeVal = str_replace("'", "\'", $val);
                    echo "'$colName' => '$safeVal'";
                }

                if ($index < count($columnsList) - 1) echo ", ";
            }
            echo "],\n";
        }
    }
}

if ($currentTable !== '') {
    echo "        ];\n        \$this->db->table('$currentTable')->insertBatch(\$$currentTable);\n";
}

echo "\n------------------------------------------------------------\n";
