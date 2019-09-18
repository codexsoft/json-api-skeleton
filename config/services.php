<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\FileLoader;

/** @var FileLoader $this */

$defaultDefinition = (new Definition)
    ->setAutoconfigured(true)
    ->setAutowired(true)
    ->setPublic(false);

$webServerSchema = \CodexSoft\JsonApi\JsonApiSchema::getFromConfigFile(__DIR__.'/codexsoft.json-api.php');

$paths = [
    $webServerSchema->getNamespaceActions().'\\' => $webServerSchema->getPathToActions().'/*',
];

foreach ($paths as $namespace => $path) {
    $this->registerClasses((clone $defaultDefinition)->setPublic(true), $namespace, $path);
}

$classes = [
    \CodexSoft\JsonApi\Form\Extensions\FormFieldDefaultValueExtension::class,
    \CodexSoft\JsonApi\Form\Extensions\FormFieldExampleExtension::class,
    \CodexSoft\JsonApi\Command\CreateActionCommand::class,
    \CodexSoft\JsonApi\Command\SwagenCommand::class,
    \CodexSoft\JsonApi\EventListener\HttpRequestJsonToArraySubscriber::class,
];

foreach ($classes as $class) {
    $this->setDefinition($class, (clone $defaultDefinition));
}
