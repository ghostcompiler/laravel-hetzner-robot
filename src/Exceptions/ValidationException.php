<?php

namespace Vendor\HetznerRobot\Exceptions;

class ValidationException extends ApiException
{
    /**
     * Get list of missing input fields.
     */
    public function getMissingFields(): array
    {
        return $this->details['missing'] ?? [];
    }

    /**
     * Get list of invalid input fields.
     */
    public function getInvalidFields(): array
    {
        return $this->details['invalid'] ?? [];
    }
}
