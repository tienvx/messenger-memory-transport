<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('logs/')
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
    ])
    ->setUsingCache(false)
    ->setFinder($finder)
;
