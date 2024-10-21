<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface QueueInterface extends ClosableInterface
{
    public function pushAsync(mixed $value, CancellationInterface $cancellation = null): void;
    
    public function push(mixed $value): void;
    
    public function getIterator(): ConcurrentIteratorInterface;
}