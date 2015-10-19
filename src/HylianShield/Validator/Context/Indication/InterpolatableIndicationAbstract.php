<?php
/**
 * Abstract implementation for interpolatable indication entities.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context\Indication;

use \InvalidArgumentException;

/**
 * Abstract implementation for interpolatable indication entities.
 */
abstract class InterpolatableIndicationAbstract extends IndicationAbstract implements
    InterpolatableInterface
{
    /**
     * Interpolate the context parameters into the supplied local translation
     * of the violation.
     *
     * The given string can use :param to denote the position where the
     * parameters can be interpolated.
     *
     * E.g.:
     *
     * Context: ['user' => 'Impa', 'domain' => 'gerudo.vil.hyr']
     * Translation: Invalid user :user and domain :domain found.
     * Interpolated: Invalid user Impa and domain gerudo.vil.hyr found.
     *
     * @param string $translation
     * @param string $interpolationStart
     * @param string $interpolationEnd
     * @return string
     * @throws \InvalidArgumentException when $translation is not a string
     * @throws \InvalidArgumentException when $interpolationStart is not a
     *   string
     * @throws \InvalidArgumentException when $interpolationEnd is not a string
     */
    public function interpolate(
        $translation,
        $interpolationStart = InterpolatableInterface::INTERPOLATION_START,
        $interpolationEnd = InterpolatableInterface::INTERPOLATION_END
    ) {
        if (!is_string($translation)) {
            throw new InvalidArgumentException(
                'Invalid translation type supplied: ' . gettype($translation)
            );
        }

        if (!is_string($interpolationStart)) {
            throw new InvalidArgumentException(
                'Invalid interpolationStart type supplied: '
                . gettype($interpolationStart)
            );
        }

        if (!is_string($interpolationEnd)) {
            throw new InvalidArgumentException(
                'Invalid interpolationEnd type supplied: '
                . gettype($interpolationEnd)
            );
        }

        $interpolations = $this->getInterpolations();

        // Return an interpolated translation string.
        return str_replace(
            // Search for these entries.
            array_map(
                // Generate interpolation identifiers.
                function ($key) use ($interpolationStart, $interpolationEnd) {
                    return "{$interpolationStart}{$key}{$interpolationEnd}";
                },
                array_keys($interpolations)
            ),
            // Replace with these entries.
            array_values($interpolations),
            // Use this as input.
            $translation
        );
    }

    /**
     * Return a list of interpolation key and values.
     *
     * @return array
     */
    abstract protected function getInterpolations();
}
