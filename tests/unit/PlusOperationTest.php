<?php

declare(strict_types=1);

namespace tests\loophp\collection;

use loophp\collection\Operation\Plus;
use PHPUnit\Framework\TestCase;

final class PlusOperationTest extends TestCase
{
    public function testPlusEmptySetDoesNotChangeTheExistingSet(): void
    {
        $leftHand = ['a', 'b'];
        $rightHand = [];

        $result = Plus::of()($rightHand)($leftHand);
        self::assertSame(['a', 'b'], iterator_to_array($result));
    }

    public function testEmptySetPlusExistingSetResultsInExistingSet(): void
    {
        $leftHand = [];
        $rightHand = ['a', 'b'];

        $result = Plus::of()($rightHand)($leftHand);
        self::assertSame(['a', 'b'], iterator_to_array($result));
    }

    public function testPlusIntersectingIntKeysSetsDoesNotOverwriteLeftHandSetItems(): void
    {
        $leftHand = [0 => 'yes', 1 => 'yes'];
        $rightHand = [0 => 'no', 2 => 'yes'];

        $result = Plus::of()($rightHand)($leftHand);
        self::assertSame([0 => 'yes', 1 => 'yes', 2 => 'yes'], iterator_to_array($result));
    }

    public function testPlusIntersectingStringKeysSetsDoesNotOverwriteLeftHandSetItems(): void
    {
        $leftHand = ['first' => 'yes', 'second' => 'yes'];
        $rightHand = ['first' => 'no', 'third' => 'yes'];

        $result = Plus::of()($rightHand)($leftHand);

        self::assertSame(['first' => 'yes', 'second' => 'yes', 'third' => 'yes'], iterator_to_array($result));
    }

    public function testPlusSupersetAddsKeyDifference(): void
    {
        $leftHand = ['a', 'b'];
        $rightHand = ['c', 'd', 'e', 'f'];

        $result = Plus::of()($rightHand)($leftHand);
        self::assertSame(['a', 'b', 'e', 'f'], iterator_to_array($result));
    }

    public function testPlusSubsetDoesNotAddAnyValues(): void
    {
        $leftHand = ['a', 'b', 'c'];
        $rightHand = ['d', 'e'];

        $result = Plus::of()($rightHand)($leftHand);
        self::assertSame(['a', 'b', 'c'], iterator_to_array($result));
    }

    public function testIntSetPlusStringSetResultsInUnion(): void
    {
        $leftHand = [0 => 'a', 1 => 'b'];
        $rightHand = ['third' => 'c', 'fourth' => 'd'];

        $result = Plus::of()($rightHand)($leftHand);
        self::assertSame([0 => 'a', 1 => 'b', 'third' => 'c', 'fourth' => 'd'], iterator_to_array($result));
    }
}
