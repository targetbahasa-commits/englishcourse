<?php

namespace Tests\Unit;

use App\Services\ToeflReadingPracticeData;
use PHPUnit\Framework\TestCase;

class ToeflReadingPracticeDataTest extends TestCase
{
    private const EXPECTED_ANSWER_KEYS = [
        1 => 'ACDDAABCDBCACBCABBDADCBABCCACDBBDCCAADBCAAAADBCBCC',
        2 => 'DACDBBACCABCDCBADADBCADBADABAACCADBCACCBAACDDBCDAC',
        3 => 'DAABADDBABCDBCBDCBBABDACBDDBAADDABCDCBBADCDBCCADCB',
        4 => 'CDACDBDABCDBADBDCACBDAACADBCBDCDDBDBCBABAACCBCCDDB',
        5 => 'ABCCBCABDBBADBDACCBADABCCCDCCCBADCCDCCBDBCCCADBAAD',
        6 => 'BDBCCACAACABCDAAABDBBACCDBBBCBBDCCCADBDACBCDAABACC',
        7 => 'ABCCCDDAABDACBDADCDBCDCDAADABCABBDBDCABDBCDADCCCDC',
        8 => 'BABDBCDADCDAADCCDADBCBDDADDCCBDADBDABBCDDCCBCABBAC',
        9 => 'ACBBAACDBBABBDADDBBBCBDCAABDBCCADADACBDCDCBDBCBACC',
        10 => 'BCADBDADDBCADADCDDBCADCDBDABDABCDACBDDAACBBAADCDCC',
        11 => 'AABDAADDBDCCBDCABCBDBACADDCACACBADDCCABDBBDCCDCDCC',
        12 => 'ACBDAADBDCBDCBABDCBCABCBCBDACAADCBCBDDCCAACBDBBCAD',
        13 => 'ADCBBDACDDCABCAACADCBDABAADBDCCAAABDDDBDBCABCBBCAD',
        14 => 'BCDCDCBABBDAACADCBCDCADADBCBBDBADBBADABBCCDDCBADAC',
    ];

    public function test_catalog_contains_14_available_packages(): void
    {
        $catalog = ToeflReadingPracticeData::catalog();

        $this->assertCount(14, $catalog);

        foreach ($catalog as $index => $item) {
            $expectedNumber = $index + 1;
            $this->assertSame($expectedNumber, $item['package_number']);
            $this->assertSame('available', $item['status']);
            $this->assertSame('Practice Test ' . sprintf('%02d', $expectedNumber), $item['title']);
            $this->assertNotEmpty($item['description']);
        }
    }

    public function test_all_14_packages_have_valid_structure_and_matching_answers(): void
    {
        foreach (self::EXPECTED_ANSWER_KEYS as $packageNumber => $expectedAnswerStr) {
            $package = ToeflReadingPracticeData::package($packageNumber);

            $this->assertIsArray($package, "Package {$packageNumber} should be an array");
            $this->assertSame($packageNumber, $package['package_number']);
            $this->assertCount(5, $package['passages'], "Package {$packageNumber} should have 5 passages");

            $actualAnswers = [];
            $totalQuestions = 0;

            foreach ($package['passages'] as $passageIndex => $passage) {
                $this->assertNotEmpty($passage['content'], "Package {$packageNumber} passage {$passageIndex} content is empty");
                $this->assertNotEmpty($passage['section_title']);

                foreach ($passage['questions'] as $question) {
                    $totalQuestions++;
                    $qNum = (int) $question['number'];
                    $actualAnswers[$qNum] = $question['answer'];

                    $this->assertNotEmpty($question['text'], "Package {$packageNumber} Q{$qNum} text is empty");
                    $this->assertCount(4, $question['options'], "Package {$packageNumber} Q{$qNum} must have 4 options");
                    $this->assertArrayHasKey('A', $question['options']);
                    $this->assertArrayHasKey('B', $question['options']);
                    $this->assertArrayHasKey('C', $question['options']);
                    $this->assertArrayHasKey('D', $question['options']);
                    $this->assertNotEmpty($question['explanation'], "Package {$packageNumber} Q{$qNum} explanation is empty");
                    $this->assertIsArray($question['distractor_explanations']);
                }
            }

            $this->assertSame(50, $totalQuestions, "Package {$packageNumber} must have exactly 50 questions");
            $this->assertCount(50, $actualAnswers, "Package {$packageNumber} must have 50 answers");

            $expectedChars = str_split($expectedAnswerStr);
            for ($q = 1; $q <= 50; $q++) {
                $this->assertArrayHasKey($q, $actualAnswers, "Package {$packageNumber} missing Q{$q}");
                $this->assertSame(
                    $expectedChars[$q - 1],
                    $actualAnswers[$q],
                    "Package {$packageNumber} Answer mismatch at question {$q}"
                );
            }
        }
    }
}