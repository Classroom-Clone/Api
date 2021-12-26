<?php

declare(strict_types=1);

use Blumilk\Codestyle\Config;
use Blumilk\Codestyle\Configuration\Defaults\CommonSkippedRules;
use Blumilk\Codestyle\Configuration\Defaults\LaravelPaths;
use Blumilk\Codestyle\Configuration\Utils\Rule;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;

$paths = new LaravelPaths();
$skip = new CommonSkippedRules();

$config = new Config(
    paths: $paths->add("public", "bootstrap/app.php", "ecs.php"),
    skipped: $skip->add(new Rule(SwitchCaseSemicolonToColonFixer::class)),
);

return $config->config();
