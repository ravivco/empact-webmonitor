<?php 

$excluded_folders = [
    'vendor'
];

$finder = PhpCsFixer\Finder::create()
    ->exclude($excluded_folders )
    ->in(__DIR__);
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
    ])
    ->setFinder($finder);