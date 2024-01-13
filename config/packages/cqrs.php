<?php

declare(strict_types=1);

use DigitalCraftsman\CQRS\DTOConstructor\SerializerDTOConstructor;
use DigitalCraftsman\CQRS\RequestDecoder\JsonRequestDecoder;
use DigitalCraftsman\CQRS\ResponseConstructor\EmptyResponseConstructor;
use DigitalCraftsman\CQRS\ResponseConstructor\SerializerJsonResponseConstructor;
// Automatically generated by Symfony though a config builder (see https://symfony.com/doc/current/configuration.html#config-config-builder).
use Symfony\Config\CqrsConfig;

return static function (CqrsConfig $cqrsConfig) {
//    $cqrsConfig->queryController()
//        ->defaultRequestDecoderClass(JsonRequestDecoder::class)
//        ->defaultDtoConstructorClass(SerializerDTOConstructor::class)
//        ->defaultResponseConstructorClass(SerializerJsonResponseConstructor::class);

    $cqrsConfig->commandController()
        ->defaultRequestDecoderClass(JsonRequestDecoder::class)
        ->defaultDtoConstructorClass(SerializerDTOConstructor::class)
        ->defaultResponseConstructorClass(EmptyResponseConstructor::class);
};