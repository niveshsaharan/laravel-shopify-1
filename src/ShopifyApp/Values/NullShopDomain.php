<?php

namespace Osiset\ShopifyApp\Values;

use Funeralzone\ValueObjects\NullTrait;
use Osiset\ShopifyApp\Contracts\ShopDomain as ShopDomainValue;

/**
 * Value object for the shop's domain (null).
 */
final class NullShopDomain implements ShopDomainValue
{
    use NullTrait;
}
