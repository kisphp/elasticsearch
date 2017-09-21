<?php

$header = <<<'EOF'
This file is property of Marius-Bogdan Rizac @ KISPHP
EOF;

// commented values are set by default
$fixers = [
//    '@PHP56Migration' => true,
    '@PSR2' => true,
    '@Symfony' => true,
//    '@Symfony:risky' => true,
    'align_multiline_comment' => true,
    'array_syntax' => ['syntax' => 'short'],
    'blank_line_before_statement' => true,
    'combine_consecutive_unsets' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    // one should use PHPUnit methods to set up expected exception instead of annotations
    'general_phpdoc_annotation_remove' => [
        'annotations' => [
            'package',
            'expectedException',
            'expectedExceptionMessage',
            'expectedExceptionMessageRegExp',
        ],
    ],
//    'header_comment' => [
//        'header' => $header,
//    ],
    'heredoc_to_nowdoc' => true,
    'method_argument_space' => [
        'ensure_fully_multiline' => true,
    ],
    'no_extra_consecutive_blank_lines' => [
        'tokens' => [
            'break',
            'continue',
            'extra',
            'return',
            'throw',
            'use',
            'parenthesis_brace_block',
            'square_brace_block',
            'curly_brace_block',
        ],
    ],
    'no_null_property_initialization' => true,
    'no_leading_import_slash' => false,
    'no_short_echo_tag' => true,
    'no_superfluous_elseif' => true,
    'no_unneeded_curly_braces' => true,
    'no_unneeded_final_method' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'php_unit_strict' => true,
    'php_unit_test_class_requires_covers' => false,
    'phpdoc_align' => false,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_order' => true,
    'phpdoc_types_order' => true,
    'semicolon_after_instruction' => true,
    'single_line_comment_style' => true,
    'strict_comparison' => true,
    'strict_param' => true,
];

$config = \PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules($fixers)
    ->setUsingCache(false)
    ->setFinder(
        \PhpCsFixer\Finder::create()
            ->exclude('vendor/*')
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
    )
;

// special handling of fabbot.io service if it's using too old PHP CS Fixer version
try {
    PhpCsFixer\FixerFactory::create()
        ->registerBuiltInFixers()
        ->registerCustomFixers($config->getCustomFixers())
        ->useRuleSet(new PhpCsFixer\RuleSet($config->getRules()));
} catch (PhpCsFixer\ConfigurationException\InvalidConfigurationException $e) {
    $config->setRules([]);
}

return $config;
