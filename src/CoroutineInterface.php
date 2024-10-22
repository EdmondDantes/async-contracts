<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface CoroutineInterface
{
    public function getCoroutineId(): int|string;
    
    public function isRunning(): bool;
    
    public function isCancelled(): bool;
    
    public function isFinished(): bool;
    
    public function stop(\Throwable $throwable = null): bool;
}