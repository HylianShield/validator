<?php
/**
 * Rule for the user section of a URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;

/**
 * Rule for the user section of a URL.
 */
class UserRule extends RuleAbstract
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
        if (empty($url['user'])) {
            $context->addViolation(
                'Missing username',
                Network::VIOLATION_EMPTY_USER
            );
            return false;
        }

        return true;
    }
}
