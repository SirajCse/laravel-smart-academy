<?php

/**
 * Smart Academy — csv_helper.php
 * Replaces CI3 application/helpers/csv_helper.php (CSVReader library wrappers).
 */

if (! function_exists('parseCsv')) {
    function parseCsv(string $filePath, bool $hasHeader = true, string $delimiter = ','): array
    {
        $rows = [];
        if (! file_exists($filePath)) return $rows;

        $handle = fopen($filePath, 'r');
        if ($handle === false) return $rows;

        $header = null;
        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            if ($hasHeader && $header === null) {
                $header = array_map('trim', $row);
                continue;
            }
            $rows[] = $hasHeader ? array_combine($header, $row) : $row;
        }

        fclose($handle);
        return $rows;
    }
}

if (! function_exists('writeCsv')) {
    function writeCsv(string $filePath, array $rows, array $headers = null): bool
    {
        $handle = fopen($filePath, 'w');
        if ($handle === false) return false;

        if ($headers) fputcsv($handle, $headers);

        foreach ($rows as $row) {
            fputcsv($handle, array_values($row));
        }

        fclose($handle);
        return true;
    }
}

if (! function_exists('csvToAssoc')) {
    function csvToAssoc(string $filePath): array
    {
        return parseCsv($filePath, true);
    }
}
