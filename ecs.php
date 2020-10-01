<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'commentType' => 'PHPDoc',
            'header' => "This file is part of the promised-entities package.
            
(c) Jordi Domènech Bonilla

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code."
        ]]);

    $services->set(GeneralPhpdocAnnotationRemoveFixer::class)
        ->call('configure', [[
            'annotations'=> ['package']
        ]]);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        Option::SETS,
        [
            SetList::PSR_12,
            SetList::PHP_70,
            SetList::PHP_71,
            SetList::PHPUNIT,
            SetList::CLEAN_CODE,
        ]
    );

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/src-test',
        __DIR__ . '/tests',
    ]);
};