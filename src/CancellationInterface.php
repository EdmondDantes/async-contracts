<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface CancellationInterface
{
    /**
     * Subscribes a new handler to be invoked on a cancellation request.
     *
     * This handler might be invoked immediately in case the cancellation has already been requested. Any unhandled
     * exceptions will be thrown into the event loop.
     *
     * @return string Identifier that can be used to cancel the subscription.
     */
    public function subscribe(\Closure $callback): string;
    
    /**
     * Unsubscribes a previously registered handler.
     *
     * The handler will no longer be called as long as this method isn't invoked from a subscribed callback.
     */
    public function unsubscribe(string $id): void;
    
    /**
     * Returns whether cancellation has been requested yet.
     */
    public function isRequested(): bool;
    
    /**
     * Throws the `CancelledException` if cancellation has been requested, otherwise does nothing.
     */
    public function throwIfRequested(): void;
}