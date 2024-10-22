<?php
declare(strict_types=1);

namespace IfCastle\Async;

/**
 * Asynchronous Coroutine scheduler interface.
 */
interface CoroutineSchedulerInterface
{
    /**
     * Runs a coroutine.
     */
    public function run(\Closure $function): CoroutineInterface;
    
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
     * If you want the first future completed without an error, use {@see awaitFirstSuccessful()} instead.
     */
    public function awaitFirst(iterable $futures, ?CancellationInterface $cancellation = null): mixed;
    
    /**
     * Unwraps the first completed future without an error.
     *
     * If you want the first future completed, regardless of whether it completed with an error, use {@see awaitFirst()} instead.
     */
    public function awaitFirstSuccessful(iterable $futures, ?CancellationInterface $cancellation = null): mixed;
    
    /**
     * Unwraps all completed futures.
     *
     * If you want the all future completed, use {@see awaitAnyN()} instead.
     */
    public function awaitAll(iterable $futures, ?CancellationInterface $cancellation = null): array;
    
    /**
     * Awaits the first N successfully completed futures, ignoring errors.
     *
     * @template Tk of array-key
     * @template Tv
     *
     * @param positive-int $count
     * @param iterable<Tk, FutureInterface<Tv>> $futures
     * @param CancellationInterface|null $cancellation Optional cancellation.
     *
     * @return non-empty-array<Tk, Tv>
     */
    public function awaitAnyN(int $count, iterable $futures, ?CancellationInterface $cancellation = null): array;
    
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
     * Creates a timeout cancellation.
     *
     * @param float $timeout Timeout in seconds.
     * @param string $message Message for the exception. Default is "Operation timed out".
     */
    public function createTimeoutCancellation(float $timeout, string $message = 'Operation timed out'): CancellationInterface;
    
    /**
     * Creates a composite cancellation.
     */
    public function compositeCancellation(CancellationInterface... $cancellations): CancellationInterface;
    
    /**
     * Creates a deferred cancellation.
     */
    public function createDeferredCancellation(): DeferredCancellationInterface;
    
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
    public function cancelInterval(int|string $timerId): void;
    
    public function stopAllCoroutines(?\Throwable $exception = null): bool;
}