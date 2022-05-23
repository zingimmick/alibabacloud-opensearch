<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector;
use Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (\Rector\Config\RectorConfig $rectorConfig): void {
    $rectorConfig->rule(MultipleClassFileToPsr4ClassesRector::class);
    $rectorConfig->rule(UpdateFileNameByClassNameFileSystemRector::class);
    $rectorConfig->paths([
        __DIR__ . '/OpenSearch',
    ]);
};
