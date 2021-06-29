<?php

namespace RMValidator\Attributes\PropertyAttributes\DateTime;

use Attribute;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeBeforeException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class DateTimeBeforeAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $before, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        $beforeDate = new DateTime($this->before);
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value >= $beforeDate) {
            throw new DateTimeBeforeException($value, $beforeDate);
        }
    }
}