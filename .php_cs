<?php

/*
 * This file is part of the wwp66650/zhetaoke.
 *
 * (c) wwp66650 <levelooy@666.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

$header = <<<EOF
This file is part of the levelooy/zhetaoke.

(c) levelooy <levelooy@666.com>

This source file is subject to the MIT license that is bundled.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'header_comment' => ['header' => $header],
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    )
;
