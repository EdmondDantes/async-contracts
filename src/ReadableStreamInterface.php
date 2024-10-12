<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface ReadableStreamInterface extends ClosableInterface
{
    /**
     * Reads data from the stream.
     */
    public function read(?CancellationInterface $cancellation = null): ?string;
    
    /**
     * @return bool A stream may become unreadable if the underlying source is closed or lost.
     */
    public function isReadable(): bool;
}