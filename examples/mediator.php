<?php
use HylianShield\Validator\ValidatorInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$logger = new class extends AbstractLogger implements LoggerInterface
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        echo json_encode(
            [
                'level' => $level,
                'message' => $message,
                'context' => $context
            ],
            JSON_PRETTY_PRINT
        ) . PHP_EOL;
    }
};

$validator = new class implements ValidatorInterface
{
    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'Foo';
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        return $subject === $this->getIdentifier();
    }
};

$mediator = new class($validator, $logger) implements ValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ValidatorLogMediator constructor.
     *
     * @param ValidatorInterface $validator
     * @param LoggerInterface $logger
     */
    public function __construct(
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->validator->getIdentifier();
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        $isValid = $this->validator->validate($subject);

        $this
            ->logger
            ->log(
                'debug',
                sprintf(
                    'Validation \'%s\': %s',
                    $this->getIdentifier(),
                    var_export($isValid, true)
                ),
                ['subject' => $subject]
            );

        return $isValid;
    }
};

$mediator->validate('foo');
$mediator->validate('Foo');
