<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\iterators\PackIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Pack extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @param T $value
             * @param TKey $key
             *
             * @return array{0: TKey, 1: T}
             */
            static fn ($value, $key): array => [$key, $value];

        /** @var Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}> $pipe */
        $pipe = Pipe::ofTyped2(
            Map::of()($mapCallback),
            (new Normalize())()
        );

        // Point free style.
        return $pipe;
    }
}
