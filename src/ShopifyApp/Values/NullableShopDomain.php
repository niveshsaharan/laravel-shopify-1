<?php

namespace Osiset\ShopifyApp\Values;

use Funeralzone\ValueObjects\Nullable;
use Osiset\ShopifyApp\Contracts\ShopDomain as ShopDomainValue;

/**
 * Value object for the shop's domain (nullable).
 */
final class NullableShopDomain extends Nullable implements ShopDomainValue
{
    /**
     * @return string
     */
    protected static function nonNullImplementation(): string
    {
        return ShopDomain::class;
    }

    /**
     * @return string
     */
    protected static function nullImplementation(): string
    {
        return NullShopDomain::class;
    }
}
