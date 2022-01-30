<?php

namespace App\Cart\Shipping;

use MelhorEnvio\Resources\Shipment\Product;
use MelhorEnvio\Shipment;

class MelhorEnvioShippingMethod implements ShippingMethod
{
    /**
     * @var Shipment
     */
    private $api;

    /**
     * @var string
     */
    private $origin;

    public function __construct(string $origin)
    {
        $token = config('shipping.melhor_envio.token');
        $env = config('shipping.melhor_envio.env');

        $this->origin = $origin;
        $this->api = new Shipment($token, $env);
    }

    public function getId(): string
    {
        return  'melhor_envio';
    }

    public function getName(): string
    {
        return 'Melhor Envio';
    }

    /**
     * @param Shippable[] $shippables
     *
     * @return ShippingRate[]
     */
    public function getRates(array $shippables, string $destination): array
    {
        $calculator = $this->api->calculator();
        $calculator->postalCode($this->origin, $destination);

        foreach ($shippables as $shippable) {
            $product = new Product(
                $shippable->getId(),
                $shippable->getHeight(),
                $shippable->getWidth(),
                $shippable->getLength(),
                $shippable->getWeight(),
                $shippable->getPrice(),
                $shippable->getQty()
            );

            $calculator->addProduct($product);
        }


        return array_map(function ($rate) {
            return new MelhorEnvioShippingRate($rate);
        }, $this->filter($calculator->calculate()));
    }


    /**
     * Filters out rates with error
     *
     * @var array $rates
     *
     * @return array
     */
    private function filter(array $rates): array
    {
        return array_filter($rates, function ($rate) {
            return !isset($rate['error']);
        });
    }
}
