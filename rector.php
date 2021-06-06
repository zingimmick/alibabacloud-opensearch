<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector;
use Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(MultipleClassFileToPsr4ClassesRector::class);
    $services->set(UpdateFileNameByClassNameFileSystemRector::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/OpenSearch',
    ]);
};
