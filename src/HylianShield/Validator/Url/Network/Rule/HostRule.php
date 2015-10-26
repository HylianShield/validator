<?php
/**
 * A rule for the host section of a URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;

/**
 * A rule for the host section of a URL.
 */
class HostRule extends RuleAbstract
{
    /**
     * Test the supplied URL components against the concrete rule.
     *
     * @param array $url
     * @param ContextInterface $context
     * @return bool
     */
    public function test(array $url, ContextInterface $context)
    {
        if (empty($url['host'])) {
            $context->addViolation(
                'Missing host index',
                Network::VIOLATION_HOST
            );
            return false;
        }

        return true;
    }
}
