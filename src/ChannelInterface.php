<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface ChannelInterface extends ClosableInterface
{
    public function send(mixed $data): void;
    
    public function sendAsync(mixed $data, CancellationInterface $cancellation = null): void;
    
    public function receive(): mixed;
    
    public function isEmpty(): bool;
    
    public function isFull(): bool;
}