<?php declare(strict_types = 1);

namespace Mailbox\Domain\Throwable;

final class DetailedThrowable
{
    /**
     * @var \Throwable
     */
    private $throwable;

    /**
     * @param \Throwable $throwable
     */
    public function __construct(\Throwable $throwable)
    {
        $this->throwable = $throwable;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $throwable = $this->throwable;

        $array = [];
        do {
            $array[] = [
                'type' => get_class($throwable),
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
                'trace' => explode("\n", $throwable->getTraceAsString()),
            ];
        } while ($throwable = $throwable->getPrevious());

        return $array;
    }
}
