<?php

namespace Osiset\ShopifyApp\Transfers;

use Osiset\ShopifyApp\Contracts\AccessToken as AccessTokenValue;
use Osiset\ShopifyApp\Contracts\ShopDomain as ShopDomainValue;

/**
 * Reprecents details for API session used by API helper.
 */
final class ApiSession extends AbstractTransfer
{
    /**
     * The shop's domain.
     *
     * @var ShopDomainValue
     */
    public $domain;

    /**
     * The access token.
     *
     * @var AccessTokenValue
     */
    public $token;
}
