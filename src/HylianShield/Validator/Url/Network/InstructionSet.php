<?php
/**
 * An instruction set for network validators.
 * The instruction set is meant to process the definition of a network
 * protocol into a set of validation rules and parsers to process URLs into
 * data that the validators can understand.
 *
 * The internally registered instructions are therefore highly dependent on
 * configuration, which creates the possibility to implement highly
 * configurable network validators, while the validators themselves stay true
 * to a simple job: validating input.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network\Parser\ParserException;
use \HylianShield\Validator\Url\Network\Parser\ParserInterface;
use \HylianShield\Validator\Url\Network\Parser\PathParser;
use \HylianShield\Validator\Url\Network\Parser\QueryParser;
use \HylianShield\Validator\Url\Network\Parser\UrlStringParser;
use \HylianShield\Validator\Url\Network\Rule\AllowedParametersRule;
use \HylianShield\Validator\Url\Network\Rule\HostRule;
use \HylianShield\Validator\Url\Network\Rule\IllegalParametersRule;
use \HylianShield\Validator\Url\Network\Rule\PasswordRule;
use \HylianShield\Validator\Url\Network\Rule\PathRule;
use \HylianShield\Validator\Url\Network\Rule\PortRule;
use \HylianShield\Validator\Url\Network\Rule\RequiredParametersRule;
use \HylianShield\Validator\Url\Network\Rule\RuleInterface;
use \HylianShield\Validator\Url\Network\Rule\SchemeRule;
use \HylianShield\Validator\Url\Network\Rule\UserRule;

/**
 * An instruction set for network validators.
 */
class InstructionSet implements InstructionSetInterface
{
    /**
     * The definition on which the instruction set is based.
     *
     * @var ProtocolDefinitionInterface $definition
     */
    private $definition;

    /**
     * A list of rules for the current instruction set.
     *
     * @var RuleInterface[] $rules
     */
    private $rules = array();

    /**
     * A list of parsers for the current instruction set.
     *
     * @var ParserInterface[] $parsers
     */
    private $parsers = array();

    /**
     * Whether the definition has been processed.
     *
     * @var bool $processedDefinition
     */
    private $processedDefinition = false;

    /**
     * Initialize a new instruction set.
     *
     * @param ProtocolDefinitionInterface $definition
     */
    private function __construct(ProtocolDefinitionInterface $definition)
    {
        $this->definition = $definition;
    }

    /**
     * Reset the rules and parsers.
     *
     * @return void
     */
    private function reset()
    {
        $this->rules = array();
        $this->parsers = array();
        $this->processedDefinition = false;
    }

    /**
     * Create an instruction set from the supplied protocol definition.
     *
     * @param ProtocolDefinitionInterface $definition
     * @return static
     */
    public static function fromDefinition(
        ProtocolDefinitionInterface $definition
    ) {
        return new static($definition);
    }

    /**
     * Getter for the definition property.
     *
     * @return ProtocolDefinitionInterface
     * @throws \LogicException when property definition is not set.
     */
    protected function getDefinition()
    {
        if (!isset($this->definition)) {
            throw new \LogicException('Missing property definition');
        }

        return $this->definition;
    }

    /**
     * Add the supplied rule to the list of rules.
     *
     * @param RuleInterface $rule
     * @return void
     */
    private function addRule(RuleInterface $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * Add the supplied parser to the list of parsers.
     *
     * @param ParserInterface $parser
     * @return void
     */
    private function addParser(ParserInterface $parser)
    {
        $this->parsers[] = $parser;
    }

    /**
     * Process the network protocol definition into different rules and parsers.
     *
     * @return void
     */
    private function processDefinition()
    {
        if ($this->processedDefinition === true) {
            return;
        }

        $this->reset();
        $definition = $this->getDefinition();

        // The initial parser.
        $this->addParser(new UrlStringParser());

        $this->addRule(HostRule::fromDefinition($definition));
        $this->addRule(SchemeRule::fromDefinition($definition));

        if (!$definition->isEmptyPathAllowed()) {
            $this->addParser(new PathParser());
            $this->addRule(PathRule::fromDefinition($definition));
        }

        if ($definition->isRequireUser()) {
            $this->addRule(UserRule::fromDefinition($definition));
        }

        if ($definition->isRequirePassword()) {
            $this->addRule(PasswordRule::fromDefinition($definition));
        }

        $this->addRule(PortRule::fromDefinition($definition));

        if ($definition->hasQueryConfiguration()) {
            $this->processQueryConfiguration($definition);
        }

        $this->processedDefinition = true;
    }

    /**
     * Process the configuration of query rules.
     *
     * @param ProtocolDefinitionInterface $definition
     * @return void
     */
    private function processQueryConfiguration(
        ProtocolDefinitionInterface $definition
    ) {
        $this->addParser(new QueryParser());

        if ($definition->hasAllowedParameters()) {
            $this->addRule(
                AllowedParametersRule::fromDefinition($definition)
            );
        }

        if ($definition->hasInvalidParameters()) {
            $this->addRule(
                IllegalParametersRule::fromDefinition($definition)
            );
        }

        if ($definition->hasRequiredParameters()) {
            $this->addRule(
                RequiredParametersRule::fromDefinition($definition)
            );
        }
    }

    /**
     * Getter for the rules property.
     *
     * @return RuleInterface[]
     */
    public function getRules()
    {
        $this->processDefinition();

        return $this->rules;
    }

    /**
     * Getter for the parsers property.
     *
     * @return ParserInterface[]
     */
    public function getParsers()
    {
        $this->processDefinition();

        return $this->parsers;
    }

    /**
     * Parse a given value into an array structure with URL components.
     *
     * @param mixed $value
     * @return array
     * @throws ParserException when a parser returned something but
     *   an array.
     */
    public function parse($value)
    {
        foreach ($this->getParsers() as $parser) {
            $value = $parser->parse($value);

            if (!is_array($value)) {
                throw new ParserException(
                    'Parser returned non-array: '
                    . get_class($parser)
                );
            }
        }

        return $value;
    }

    /**
     * Test the supplied URL components against the concrete rule.
     *
     * @param array $url
     * @param ContextInterface $context
     * @return bool
     */
    public function test(array $url, ContextInterface $context)
    {
        $valid = true;

        // Check validation rules.
        foreach ($this->getRules() as $rule) {
            if (!$rule->test($url, $context)) {
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}
