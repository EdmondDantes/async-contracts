<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface QueueInterface
{
    public function pushAsync(mixed $value): void;
    
    public function pushWithPromise(mixed $value): FutureInterface;
    
    public function push(mixed $value): void;
    
    public function getIterator(): ConcurrentIteratorInterface;
    
    /**
     * @return bool True if the queue has been completed or errored.
     */
    public function isComplete(): bool;
    
    /**
     * @return bool True if the queue has been disposed.
     */
    public function isDisposed(): bool;
    
    /**
     * Completes the queue.
     */
    public function complete(): void;
    
    /**
     * Errors the queue with the given reason.
     */
    public function error(\Throwable $reason): void;
}