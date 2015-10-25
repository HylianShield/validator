<?php
/**
 * A rule for the password section of a URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;

/**
 * A rule for the password section of a URL.
 */
class PasswordRule extends RuleAbstract
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
        if (empty($url['pass'])) {
            $context->addViolation(
                'Missing password',
                Network::VIOLATION_EMPTY_PASSWORD
            );
            return false;
        }

        return true;
    }
}
