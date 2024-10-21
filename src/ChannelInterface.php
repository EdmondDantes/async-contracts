<?php
declare(strict_types=1);

namespace IfCastle\Async;

/**
 * A channel is a communication mechanism that allows one coroutine to send data to another coroutine.
 */
interface ChannelInterface extends ClosableInterface
{
    /**
     * Send data to the channel and block until the data is received by the receiver.
     */
    public function send(mixed $data): void;

    /**
     * Send data to the channel and block until the data is received by the receiver or the timeout is reached.
     */
    public function sendAsync(mixed $data, CancellationInterface $cancellation = null): void;
    
    /**
     * Send data to the channel and return a promise that will be resolved when the data is received by the receiver.
     */
    public function sendWithPromise(mixed $data, CancellationInterface $cancellation = null): FutureInterface;
    
    /**
     * Receive data from the channel and block until the data is sent by the sender.
     */
    public function receive(): mixed;
    
    /**
     * Return a true if the channel is empty.
     */
    public function isEmpty(): bool;
    
    /**
     * Return a true if the channel is full.
     */
    public function isFull(): bool;
}