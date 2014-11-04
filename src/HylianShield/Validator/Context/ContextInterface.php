<?php
/**
 * Interface for validator context objects.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context;

use \HylianShield\Validator\Context\Indication\IndicationInterface;

/**
 * Interface ContextInterface
 */
interface ContextInterface
{
    public function add(IndicationInterface $indication);
}
