<?php

use PHPUnit\Framework\TestCase;

include(__DIR__ . '/../bin/Advent.php');

class AjaxTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    final public function testEmptyRequest(): void
    {
        (new Advent())->open_door(null, false);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_OUT_OF_RANGE", $json['status']);
        self::assertEquals(400, http_response_code());
    }

    /**
     * @runInSeparateProcess
     */
    final public function testEmptyRequestDownload(): void
    {
        (new Advent())->open_door(null, true);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_OUT_OF_RANGE", $json['status']);
        self::assertEquals(400, http_response_code());
    }

    /**
     * @runInSeparateProcess
     */
    final public function testEarlyRequestInMonth(): void
    {
        // Serverzeit manipulieren auf 1.12.2020
        $first_of_december = mktime(0, 0, 0, 12, 1, YEAR);
        $advent = new AdventWithManipulatedNow($first_of_december);
        $advent->open_door(2, false);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_TO_EARLY", $json['status']);
        self::assertEquals(403, http_response_code());
    }

    /**
     * @runInSeparateProcess
     */
    final public function testEarlyRequestInMonthDownload(): void
    {
        // Serverzeit manipulieren auf 1.12.2020
        $first_of_december = mktime(0, 0, 0, 12, 1, YEAR);
        $advent = new AdventWithManipulatedNow($first_of_december);
        $advent->open_door(2, true);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_TO_EARLY", $json['status']);
        self::assertEquals(403, http_response_code());
    }

    /**
     * @runInSeparateProcess
     */
    final public function testEarlyRequestInYear(): void
    {
        // Serverzeit manipulieren auf 30.11.2020
        $last_of_november = mktime(0, 0, 0, 11, 30, YEAR);
        $advent = new AdventWithManipulatedNow($last_of_november);
        $advent->open_door(1, false);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_TO_EARLY", $json['status']);
        self::assertEquals(403, http_response_code());
    }

    /**
     * @runInSeparateProcess
     */
    final public function testEarlyRequestInYearDownload(): void
    {
        // Serverzeit manipulieren auf 30.11.2020
        $last_of_november = mktime(0, 0, 0, 11, 30, YEAR);
        $advent = new AdventWithManipulatedNow($last_of_november);
        $advent->open_door(1, true);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_TO_EARLY", $json['status']);
        self::assertEquals(403, http_response_code());
    }


    /**
     * @runInSeparateProcess
     */
    final public function testFileNotFound(): void
    {
        // Serverzeit manipulieren auf 1.12.2020
        $first_of_december = mktime(0, 0, 0, 12, 1, YEAR);
        $advent = new AdventWithManipulatedNow($first_of_december);
        //File aus Array löschen, falls vorhanden
        unset($advent->advent_files[1]);

        $advent->open_door(1, false);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_NOT_AVAILABLE", $json['status']);
        self::assertEquals(404, http_response_code());
    }

    /**
     * @runInSeparateProcess
     */
    final public function testFileNotFoundDownload(): void
    {
        // Serverzeit manipulieren auf 1.12.2020
        $first_of_december = mktime(0, 0, 0, 12, 1, YEAR);
        $advent = new AdventWithManipulatedNow($first_of_december);
        //File aus Array löschen, falls vorhanden
        unset($advent->advent_files[1]);

        $advent->open_door(1, true);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("ERROR_NOT_AVAILABLE", $json['status']);
        self::assertEquals(404, http_response_code());
    }

    /**
     * @runInSeparateProcess
     */
    final public function testSuccess(): void
    {
        // Serverzeit manipulieren auf 1.12.2020
        $first_of_december = mktime(0, 0, 0, 12, 1, YEAR);
        $advent = new AdventWithManipulatedNow($first_of_december);
        //File aus Array löschen, falls vorhanden
        $advent->advent_files[1] = "../test/test.txt";

        $advent->open_door(1, false);
        $json = json_decode($this->getActualOutput(), true);
        self::assertEquals("SUCCESS", $json['status']);
        self::assertEquals(200, http_response_code());
    }
}

class AdventWithManipulatedNow extends Advent
{
    private $testDate;

    public function __construct(int $timestamp)
    {
        $this->testDate = $timestamp;
    }

    protected function now(): int
    {
        return (int)$this->testDate;
    }
}