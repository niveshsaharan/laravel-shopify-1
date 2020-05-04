<?php

namespace Osiset\ShopifyApp\Transfers;

use Illuminate\Support\Carbon;
use Osiset\ShopifyApp\Contracts\PlanId;
use Osiset\ShopifyApp\Enums\ChargeStatus;
use Osiset\ShopifyApp\Enums\ChargeType;
use Osiset\ShopifyApp\Values\ChargeReference;
use Osiset\ShopifyApp\Values\ShopId;

/**
 * Reprecents create charge.
 */
final class Charge extends AbstractTransfer
{
    /**
     * Shop ID.
     *
     * @var ShopId
     */
    public $shopId;

     /**
      * Plan ID.
      *
      * @var PlanId
      */
    public $planId;

    /**
     * Charge ID from Shopify.
     *
     * @var ChargeReference
     */
    public $chargeReference;

    /**
     * Charge type (recurring or single).
     *
     * @var ChargeType
     */
    public $chargeType;

    /**
     * Charge status.
     *
     * @var ChargeStatus $chargeStatus
     */
    public $chargeStatus;

    /**
     * When the charge was activated.
     *
     * @var Carbon
     */
    public $activatedOn;

    /**
     * When the charge will be billed on.
     *
     * @var Carbon|null
     */
    public $billingOn;

    /**
     * When the trial ends on.
     *
     * @var Carbon|null
     */
    public $trialEndsOn;

    /**
     * Plan details for reference.
     *
     * @var PlanDetails
     */
    public $planDetails;
}
