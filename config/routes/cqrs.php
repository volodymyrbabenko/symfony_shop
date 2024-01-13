<?php
return static function (\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator $routes) {

    \DigitalCraftsman\CQRS\Routing\RouteBuilder::addCommandRoute(
        $routes,
        path: '/shop/cart/change',
        dtoClass: \App\Domain\ChangeCartItemCount\ChangeCartItemCountCommand::class,
        handlerClass: \App\Domain\ChangeCartItemCount\ChangeCartItemCountCommandHandler::class,
//        requestDecoderClass: CommandWithFilesRequestDecoder::class,
//        dtoValidatorClasses: [
//
//        ],
    );


};