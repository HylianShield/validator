<?php
use HylianShield\Validator\Invoker;
use HylianShield\Validator\NotValidator;
use HylianShield\Validator\ValidatorInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$minimumAge = 18;
$now        = new DateTimeImmutable('now');

$ageValidator = new class($minimumAge, $now) implements ValidatorInterface {
    /**
     * @var int
     */
    private $age;

    /**
     * @var DateTimeInterface
     */
    private $now;

    /**
     * Age validator constructor.
     *
     * @param int               $age
     * @param DateTimeInterface $now
     */
    public function __construct(int $age, DateTimeInterface $now)
    {
        $this->age = $age;
        $this->now = $now;
    }

    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return sprintf('age(%d)', $this->age);
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        if (!($subject instanceof DateTimeInterface)) {
            return false;
        }

        $diff = $subject->diff($this->now, false);

        return $diff->y >= $this->age;
    }
};

$ages = [
    new DateTimeImmutable('-18 years'),
    new DateTimeImmutable('-12 years'),
    new DateTimeImmutable('-24 years'),
    new DateTimeImmutable('next year')
];

$allowedAges = array_filter(
    $ages,
    new Invoker($ageValidator)
);

$disallowedAges = array_filter(
    $ages,
    new Invoker(new NotValidator($ageValidator))
);

echo sprintf('Minimum age: %s', $minimumAge) . PHP_EOL;

$outputAge = function (DateTimeInterface $date) use ($now) {
    $diff = $date->diff($now, false);

    echo sprintf(
        '%d %s %s',
        $diff->y,
        $diff->y === 1 ? 'year' : 'years',
        $diff->invert ? 'before born' : 'old'
    ) . PHP_EOL;
};

echo PHP_EOL . 'Allowed ages:' . PHP_EOL;
array_walk($allowedAges, $outputAge);

echo PHP_EOL . 'Disallowed ages:' . PHP_EOL;
array_walk($disallowedAges, $outputAge);
