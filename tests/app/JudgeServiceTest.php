<?php namespace App\Services;

use App\Services\JudgeService;
use PHPUnit\Framework\TestCase;


class JudgeServiceTest extends \CIUnitTestCase
{
    public function testMeanJudge()
    {
        $actual = JudgeService::meanJudge(30);
        $expected = 2;

        $this->assertEquals(
            $expected,
            $actual,
            "actual value is equals to expected"
        );
    }

    public function testRockJudge()
    {
        $actual = JudgeService::rockJudge(30, 'Rock');
        $expected = 5;

        $this->assertEquals(
            $expected,
            $actual,
            "actual value is equals to expected"
        );
    }

    public function testFriendlyJudge()
    {
        $actual = JudgeService::friendlyJudge(30, true);
        $expected = 9;

        $this->assertEquals(
            $expected,
            $actual,
            "actual value is equals to expected"
        );
    }
}