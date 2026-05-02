<?php

declare(strict_types=1);

if (!extension_loaded('zip')) {
    fwrite(STDERR, "PHP zip extension is required.\n");
    exit(1);
}

$basePath = dirname(__DIR__);
$sourceDir = $basePath . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'who-growth';
$targetPath = $basePath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'who_growth.php';

$sources = [
    'wfl_girls' => $sourceDir . DIRECTORY_SEPARATOR . 'wfl-girls.xlsx',
    'wfl_boys' => $sourceDir . DIRECTORY_SEPARATOR . 'wfl-boys.xlsx',
    'wfh_girls' => $sourceDir . DIRECTORY_SEPARATOR . 'wfh-girls.xlsx',
    'wfh_boys' => $sourceDir . DIRECTORY_SEPARATOR . 'wfh-boys.xlsx',
    'lhfa_girls' => $sourceDir . DIRECTORY_SEPARATOR . 'lhfa-girls.xlsx',
    'lhfa_boys' => $sourceDir . DIRECTORY_SEPARATOR . 'lhfa-boys.xlsx',
];

$tables = [];

foreach ($sources as $key => $path) {
    if (!is_file($path)) {
        fwrite(STDERR, "Missing source file: {$path}\n");
        exit(1);
    }

    $tables[$key] = parseWhoWorkbook($path);
}

$export = var_export($tables, true);
$content = <<<PHP
<?php

return {$export};

PHP;

file_put_contents($targetPath, $content);

foreach ($tables as $key => $rows) {
    echo sprintf("%s: %d rows\n", $key, count($rows));
}

echo "Generated: {$targetPath}\n";

function parseWhoWorkbook(string $path): array
{
    $zip = new ZipArchive();

    if ($zip->open($path) !== true) {
        throw new RuntimeException("Cannot open workbook: {$path}");
    }

    $sharedStrings = parseSharedStrings($zip);
    $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
    $zip->close();

    if ($sheetXml === false) {
        throw new RuntimeException("Workbook does not contain xl/worksheets/sheet1.xml: {$path}");
    }

    $xml = simplexml_load_string($sheetXml);

    if (!$xml) {
        throw new RuntimeException("Cannot parse sheet XML: {$path}");
    }

    $rows = [];

    foreach ($xml->sheetData->row as $row) {
        $values = [];

        foreach ($row->c as $cell) {
            $ref = (string) $cell['r'];
            $column = columnIndex($ref);
            $values[$column] = cellValue($cell, $sharedStrings);
        }

        ksort($values);
        $values = array_values($values);

        $numeric = array_values(array_filter($values, static fn ($value) => is_numeric($value)));

        if (count($numeric) < 13) {
            continue;
        }

        $measure = round((float) $numeric[0], 1);
        $rows[(string) $measure] = [
            'l' => round((float) $numeric[1], 4),
            'm' => round((float) $numeric[2], 4),
            's' => round((float) $numeric[3], 5),
            '-4' => round((float) $numeric[4], 1),
            '-3' => round((float) $numeric[5], 1),
            '-2' => round((float) $numeric[6], 1),
            '-1' => round((float) $numeric[7], 1),
            '0' => round((float) $numeric[8], 1),
            '1' => round((float) $numeric[9], 1),
            '2' => round((float) $numeric[10], 1),
            '3' => round((float) $numeric[11], 1),
            '4' => round((float) $numeric[12], 1),
        ];
    }

    ksort($rows, SORT_NUMERIC);

    return $rows;
}

function parseSharedStrings(ZipArchive $zip): array
{
    $xml = $zip->getFromName('xl/sharedStrings.xml');

    if ($xml === false) {
        return [];
    }

    $strings = [];
    $shared = simplexml_load_string($xml);

    foreach ($shared->si as $item) {
        if (isset($item->t)) {
            $strings[] = (string) $item->t;
            continue;
        }

        $text = '';
        foreach ($item->r as $run) {
            $text .= (string) $run->t;
        }
        $strings[] = $text;
    }

    return $strings;
}

function cellValue(SimpleXMLElement $cell, array $sharedStrings): string
{
    $value = (string) $cell->v;

    if ((string) $cell['t'] === 's') {
        return $sharedStrings[(int) $value] ?? '';
    }

    return $value;
}

function columnIndex(string $cellRef): int
{
    preg_match('/^[A-Z]+/', $cellRef, $matches);
    $letters = $matches[0] ?? '';
    $index = 0;

    foreach (str_split($letters) as $letter) {
        $index = ($index * 26) + (ord($letter) - 64);
    }

    return $index;
}
