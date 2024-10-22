<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface DeferredCancellationInterface
{
    public function getCancellation(): CancellationInterface;
    
    public function isCancelled(): bool;
    
    public function cancel(?\Throwable $previous = null): void;
}