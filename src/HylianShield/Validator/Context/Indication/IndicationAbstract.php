<?php
/**
 * IndicationAbstract.php.
 *
 * @package HylianShield\Validator\Context\Indication
 * @subpackage
 */
namespace HylianShield\Validator\Context\Indication;

use \InvalidArgumentException;
use \LogicException;

/**
 * Class IndicationAbstract.
 */
abstract class IndicationAbstract implements IndicationInterface
{
    /**
     * Description of the validator indication.
     *
     * @var string $description
     */
    protected $description;

    /**
     * Set the description of the indication.
     *
     * @param string $description
     * @throws \InvalidArgumentException when $description is not a string.
     * @return IndicationAbstract
     */
    protected function setDescription($description)
    {
        if (!is_string($description)) {
            throw new InvalidArgumentException(
                'Invalid indication description: ' . gettype($description)
            );
        }

        $this->description = $description;

        return $this;
    }

    /**
     * Get the description of the indication.
     *
     * @return string
     * @throws \LogicException when the description property is not set.
     */
    public function getDescription()
    {
        if (!isset($this->description)) {
            throw new LogicException(
                'Missing property description.'
            );
        }

        return $this->description;
    }
}
