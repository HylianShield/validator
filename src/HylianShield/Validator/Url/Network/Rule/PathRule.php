<?php
/**
 * Rule for the path of a URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;

/**
 * Rule for the path of a URL.
 */
class PathRule extends RuleAbstract
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
        if (empty($url['path'])) {
            $context->addViolation(
                'Missing path',
                Network::VIOLATION_EMPTY_PATH
            );
            return false;
        }

        return true;
    }
}
