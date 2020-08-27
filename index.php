<?php

require_once __DIR__.'/vendor/autoload.php';

use App\ValidateVat;

$records = [
    '10648200011',
    '22222222222',
    '11648200011',
    '08616480011'
];
print_r("<pre>");

foreach ($records as $record) {
    $result = ValidateVat::verify($record) == true ? "valid." : "invalid.";
    print_r("VAT " . $record . ": is " . $result . PHP_EOL);
}

print_r("</pre>");
