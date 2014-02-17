<?php
/**
 * Benchmark for Validator\String.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Benchmarks\Validator\String\Utf8;

use \AthLetic\AthleticEvent;
use \HylianShield\Validator\String\Utf8\Mes3A;

/**
 * Mes3AEvent.
 */
class Mes3AEvent extends AthleticEvent
{
    /**
     * The String validator.
     *
     * @var \HylianShield\Validator\String $defaultValidator
     */
    private $defaultValidator;

    /**
     * The String validator with a minimum length.
     *
     * @var \HylianShield\Validator\String $minValidator
     */
    private $minValidator;

    /**
     * The String validator with a maximum length.
     *
     * @var \HylianShield\Validator\String $maxValidator
     */
    private $maxValidator;

    /**
     * The String validator with a minimum and maximum length.
     *
     * @var \HylianShield\Validator\String $rangeValidator
     */
    private $rangeValidator;

    /**
     * The value to test. We use 50 paragraphs of lorum ipsum.
     *
     * @var string $testValue
     */
    private $testValue = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nibh augue, faucibus eu orci ac, rutrum tincidunt arcu. Duis semper elementum lectus, eu fringilla nibh elementum id. Praesent sit amet placerat lectus. Vivamus vulputate sit amet risus id interdum. Cras sollicitudin tortor ut velit tempus venenatis. Maecenas tempus dolor eget est interdum, nec lacinia quam tristique. Mauris eu sagittis massa. Nullam sit amet nisl et ante pellentesque dignissim et a mi. Suspendisse potenti. Cras sit amet pulvinar arcu. Nulla hendrerit convallis elit, et semper quam tincidunt ut. Suspendisse placerat lobortis hendrerit. Suspendisse elementum odio at ligula scelerisque blandit vel et risus. Nam vitae varius augue, sed bibendum erat.

In hac habitasse platea dictumst. In tempus pharetra odio eget molestie. Phasellus dignissim leo sed malesuada volutpat. Vestibulum at sodales arcu. Aenean lectus metus, elementum sed vulputate eu, feugiat vitae orci. Phasellus vel nulla ut ante cursus tristique. Nulla pharetra ante sed mi dictum cursus. Proin blandit commodo ligula a ornare. Nam eu mauris justo. Etiam leo nunc, euismod ut viverra nec, commodo at erat. Donec ut mauris interdum, scelerisque justo eget, egestas nisi. Morbi ac venenatis risus. Phasellus orci quam, venenatis at sapien non, porttitor hendrerit tellus. Duis vel laoreet nisi.

In vulputate mi et felis sollicitudin, auctor cursus quam tincidunt. Curabitur quam eros, iaculis at eleifend at, semper et quam. Phasellus tincidunt urna vel nibh vulputate, ut rhoncus justo tempor. Vivamus eget porttitor magna. Nullam pharetra sem ut nulla luctus viverra sit amet et erat. Integer sodales lectus sed neque lobortis, vel gravida felis eleifend. Mauris luctus augue dolor, ut dignissim nisl viverra a. Vestibulum velit tortor, adipiscing non justo non, tincidunt ornare turpis. Sed commodo convallis lacus eu porttitor.

Vestibulum commodo et lorem id luctus. Fusce sit amet felis pellentesque elit gravida viverra imperdiet cursus ligula. Nunc luctus lacus sit amet neque condimentum, eget convallis arcu tristique. Donec ullamcorper interdum elit, id mattis leo eleifend pretium. Aenean scelerisque adipiscing nulla, sit amet porta sem gravida id. Cras congue tellus ut vehicula adipiscing. Maecenas vitae sapien imperdiet, pretium ligula et, tincidunt massa. Morbi vulputate viverra libero non consequat. Duis at purus feugiat, feugiat massa at, ullamcorper orci. Aliquam volutpat commodo hendrerit. Praesent auctor magna eget leo tempor sodales. Nullam laoreet tellus eget venenatis lobortis. Nam mattis porttitor purus non eleifend. Cras mauris elit, hendrerit eu tempor sed, aliquam vel leo.

Cras adipiscing arcu in leo fringilla commodo. Cras sed nisl pretium, dapibus purus porttitor, varius nulla. Praesent eget vehicula lorem, porttitor fermentum turpis. Nullam eget dolor ut nisl aliquam tincidunt. Pellentesque elementum vulputate urna, ut vestibulum dui aliquet lobortis. Morbi vel purus ut nunc ullamcorper elementum vitae eu mauris. Integer porta nec nibh eget imperdiet. Ut aliquam in ipsum a vulputate. Etiam consectetur ligula odio, at molestie arcu posuere eget. Proin a nisl non ipsum dignissim egestas et vel risus. Donec odio ante, congue at aliquet a, mattis malesuada ante. Sed pretium mauris eget nibh porta, nec lobortis mi sodales. Quisque neque tellus, malesuada ut gravida quis, varius nec nunc. In sed libero mattis, bibendum turpis at, rutrum felis. Cras quis varius nisl. Donec eu lobortis ligula.';

    /**
     * Create the validator.
     *
     * @return void
     */
    public function setUp()
    {
        // Set the regex encoding to UTF-8.
        mb_regex_encoding('UTF-8');

        $this->defaultValidator = new Mes3A;
        $this->minValidator = new Mes3A(1);
        $this->maxValidator = new Mes3A(null, 1);
        $this->rangeValidator = new Mes3A(1, 1);
    }

    /**
     * @iterations 100
     */
    public function defaultValidator()
    {
        $this->defaultValidator->validate($this->testValue);
    }

    /**
     * @iterations 100
     */
    public function minLength()
    {
        $this->minValidator->validate($this->testValue);
    }

    /**
     * @iterations 100
     */
    public function maxLength()
    {
        $this->maxValidator->validate($this->testValue);
    }

    /**
     * @iterations 100
     */
    public function rangeValidator()
    {
        $this->rangeValidator->validate($this->testValue);
    }
}
