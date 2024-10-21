<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface FutureInterface
{
    public function isComplete(): bool;
    
    public function ignore(): void;
    
    public function await(CancellationInterface $cancellation = null): mixed;
    
    /**
     * Attaches a callback that is invoked if this future completes. The returned future is completed with the return
     * value of the callback, or errors with an exception thrown from the callback.
     */
    public function map(callable $mapper): FutureInterface;
    
    /**
     * Attaches a callback that is invoked if this future errors.
     */
    public function catch(callable $onRejected): static;
    
    /**
     * Attaches a callback that is always invoked when the future is completed.
     */
    public function finally(callable $onFinally): static;
}