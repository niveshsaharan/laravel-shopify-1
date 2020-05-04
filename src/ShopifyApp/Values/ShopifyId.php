<?php

namespace Osiset\ShopifyApp\Values;

use Funeralzone\ValueObjects\Scalars\IntegerTrait;
use Funeralzone\ValueObjects\ValueObject;

/**
 * Value object for a Shopify ID.
 */
abstract class ShopifyId implements ValueObject
{
    use IntegerTrait;
}
