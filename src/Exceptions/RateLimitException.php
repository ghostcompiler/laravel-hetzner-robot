<?php

namespace Vendor\HetznerRobot\Exceptions;

class RateLimitException extends ApiException
{
    /**
     * Get max allowed requests.
     */
    public function getMaxRequest(): ?int
    {
        return $this->details['max_request'] ?? null;
    }

    /**
     * Get interval in seconds.
     */
    public function getInterval(): ?int
    {
        return $this->details['interval'] ?? null;
    }
}
