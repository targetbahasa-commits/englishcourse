<?php

namespace Tests\Unit;

use App\Services\ToeflReadingPracticeData;
use PHPUnit\Framework\TestCase;

class ToeflReadingPracticeDataTest extends TestCase
{
    public function test_practice_test_01_answer_key_matches_expected(): void
    {
        $package = ToeflReadingPracticeData::package(1);
        $this->assertIsArray($package);
        $actual = [];

        foreach ($package['passages'] as $passage) {
            foreach ($passage['questions'] as $question) {
                $actual[(int) $question['number']] = $question['answer'];
            }
        }

        ksort($actual);
        $expected = str_split('ACDDAABCDBCACBCABBDADCBABCCACDBBDCCAADBCAAAADBCBCC');

        $this->assertCount(50, $actual);

        for ($i = 1; $i <= 50; $i++) {
            $this->assertArrayHasKey($i, $actual);
            $this->assertSame($expected[$i - 1], $actual[$i], "Answer mismatch at question {$i}");
        }
    }
}