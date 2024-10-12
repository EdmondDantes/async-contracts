<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface CoroutineContextInterface
{
    public function isCoroutine(): bool;
    
    public function getCoroutineId(): string|int;
    
    public function getCoroutineParentId(): string|int;
    
    public function has(string $key): bool;
    
    public function get(string $key): mixed;
    
    public function getLocal(string $key): mixed;
    
    public function hasLocal(string $key): bool;
    
    public function set(string $key, mixed $value): static;
    
    /**
     * Call the callback when the coroutine is destroyed
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function defer(callable $callback): static;
}