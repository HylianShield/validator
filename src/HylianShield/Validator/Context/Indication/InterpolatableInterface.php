<?php
/**
 * Interface for interpolatable entities.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context\Indication;

/**
 * Interface for interpolatable entities.
 */
interface InterpolatableInterface
{
    /**
     * The starting character of an interpolatable tag.
     *
     * @var string INTERPOLATION_START
     */
    const INTERPOLATION_START = ':';

    /**
     * The ending character of an interpolatable tag.
     *
     * @var string INTERPOLATION_END
     */
    const INTERPOLATION_END = '';

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
     */
    public function interpolate(
        $translation,
        $interpolationStart = InterpolatableInterface::INTERPOLATION_START,
        $interpolationEnd = InterpolatableInterface::INTERPOLATION_END
    );
}
