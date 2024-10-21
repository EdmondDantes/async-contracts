<?php
declare(strict_types=1);

namespace IfCastle\Async;

/**
 * Asynchronous Coroutine scheduler interface.
 */
interface CoroutineSchedulerInterface
{
    /**
     * Runs a coroutine and returns a coroutine descriptor.
     */
    public function run(callable $coroutine): CoroutineInterface;
    
    /**
     * Awaits all futures to complete or aborts if any errors.
     *
     * The returned array keys will be in the order the futures resolved, not in the order given by the iterable.
     * Sort the array after completion if necessary.
     *
     * This is equivalent to awaiting all futures in a loop, except that it aborts as soon as one of the futures errors
     * instead of relying on the order in the iterable and awaiting the futures sequentially.
     *
     * @template Tk of array-key
     * @template Tv
     *
     * @param iterable<Tk, FutureInterface<Tv>> $futures
     * @param CancellationInterface|null $cancellation Optional cancellation.
     *
     * @return array<Tk, Tv> Unwrapped values with the order preserved.
     */
    public function await(iterable $futures, ?CancellationInterface $cancellation = null): array;
    
    /**
     * Unwraps the first completed future.
     *
     * If you want the first future completed without an error, use {@see awaitAny()} instead.
     */
    public function awaitFirst(iterable $futures, ?CancellationInterface $cancellation = null): mixed;
    
    /**
     * Unwraps the first completed future without an error.
     *
     * If you want the first future completed, regardless of whether it completed with an error, use {@see awaitFirst()} instead.
     */
    public function awaitAny(iterable $futures, ?CancellationInterface $cancellation = null): mixed;
    
    /**
     * Unwraps all completed futures.
     *
     * If you want the first future completed, use {@see awaitFirst()} instead.
     */
    public function awaitAll(iterable $futures, ?CancellationInterface $cancellation = null): array;
    
    /**
     * Unwraps all completed futures without an error.
     *
     * If you want the first future completed, use {@see awaitFirst()} instead.
     */
    public function awaitAllWithoutError(iterable $futures, ?CancellationInterface $cancellation = null): array;
    
    /**
     * Returns a new channel pair.
     *
     * The first channel is used to send data to the second channel.
     * The second channel is used to receive data from the first channel.
     *
     * @param int $size
     *
     * @return ChannelInterface[]
     */
    public function createChannelPair(int $size = 0): array;
    
    /**
     * Returns a new queue.
     *
     * @param int $size
     *
     * @return QueueInterface
     */
    public function createQueue(int $size = 0): QueueInterface;
    
    /**
     * Schedules a callback to execute in the next iteration of the event loop.
     *
     * @param   callable            $callback
     * @return  void
     */
    public function defer(callable $callback): void;
    
    /**
     * Schedules a callback to execute after a specified delay.
     *
     * @param   float|int           $delay
     * @param   callable            $callback
     *
     * @return  int|string
     */
    public function delay(float|int $delay, callable $callback): int|string;
    
    /**
     * Schedules a callback to execute periodically.
     *
     * $callback will be called repeatedly, with $interval seconds between each call.
     * $callback can implement a FreeInterface. So when a process is terminated, $callback->free() should be called.
     *
     * @param   float|int           $interval  Interval in seconds
     * @param   callable            $callback
     *
     * @return  int|string
     */
    public function interval(float|int $interval, callable $callback): int|string;
    
    /**
     * Cancels a callback scheduled with interval().
     *
     * @param   int|string          $timerId
     *
     * @return  void
     */
    public function clear(int|string $timerId): void;
    
    public function stopAll(?\Throwable $exception = null): bool;
}