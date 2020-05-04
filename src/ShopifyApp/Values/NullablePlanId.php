<?php

namespace Osiset\ShopifyApp\Values;

use Funeralzone\ValueObjects\Nullable;
use Osiset\ShopifyApp\Contracts\PlanId as PlanIdValue;

/**
 * Value object for plan's ID (nullable).
 */
final class NullablePlanId extends Nullable implements PlanIdValue
{
    /**
     * @return string
     */
    protected static function nonNullImplementation(): string
    {
        return PlanId::class;
    }

    /**
     * @return string
     */
    protected static function nullImplementation(): string
    {
        return NullPlanId::class;
    }
}
