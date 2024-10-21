<?php
declare(strict_types=1);

namespace IfCastle\Async;

interface FutureInterface
{
    public function isComplete(): bool;
    
    public function ignore(): static;
}