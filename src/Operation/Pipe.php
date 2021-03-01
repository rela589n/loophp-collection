<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Pipe extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(Iterator<TKey, T>): Iterator<TKey, T> ...): Closure (Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(Iterator<TKey, T>): Generator<TKey, T> ...$operations
             *
             * @psalm-return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (callable ...$operations): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Iterator<TKey, T>
                 */
                static function (Iterator $iterator) use ($operations): Iterator {
                    $callback =
                        /**
                         * @psalm-param Iterator<TKey, T> $iterator
                         * @psalm-param callable(Iterator<TKey, T>): Iterator<TKey, T> $fn
                         *
                         * @psalm-return Iterator<TKey, T>
                         */
                        static fn (Iterator $iterator, callable $fn): Iterator => $fn($iterator);

                    return array_reduce($operations, $callback, $iterator);
                };
    }
}
