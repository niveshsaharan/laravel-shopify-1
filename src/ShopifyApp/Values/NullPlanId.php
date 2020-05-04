<?php

namespace Osiset\ShopifyApp\Values;

use Funeralzone\ValueObjects\NullTrait;
use Osiset\ShopifyApp\Contracts\PlanId as PlanIdValue;

/**
 * Value object for plan's ID (null).
 */
final class NullPlanId implements PlanIdValue
{
    use NullTrait;
}
