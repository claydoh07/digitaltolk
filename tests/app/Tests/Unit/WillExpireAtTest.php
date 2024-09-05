<?php

namespace Tests\Unit;

use App\Helpers\TeHelper;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class CalculatorTest extends TestCase
{
    /** @test */
    public function it_checks_if_parameter_is_a_date_time_instance()
    {
        $teHelper = new TeHelper();
        $due_time = '2024-09-01 10:00:00';
        $created_at = 'invalid-date-time';

        $result = $teHelper->willExpireAt($due_time, $created_at);

        $this->assertTrue($this->isParseableDateTime($due_time));
        $this->assertFalse($this->isParseableDateTime($created_at));
        $this->expectException(\InvalidArgumentException::class);

    }
    /** @test */
    public function time_greater_than_90()
    {
        $teHelper = new TeHelper();
        $due_time = Carbon::now();
        $created_at = $due_time->addHours(91);
        $output = $due_time->subHours(48);

        $result = $teHelper->willExpireAt($due_time, $created_at);

        $this->assertEquals($output->format('Y-m-d H:i:s'), $result);
    }

    /** @test */
    public function time_less_than_equal_to_90()
    {
        $teHelper = new TeHelper();
        $due_time = Carbon::now();
        $created_at = $due_time->addHours(89);
        $output = $due_time;

        $result = $teHelper->willExpireAt($due_time, $created_at);

        $this->assertEquals($output->format('Y-m-d H:i:s'), $result);
    }

    /** @test */
    public function time_less_than_equal_to_24()
    {
        $teHelper = new TeHelper();
        $due_time = Carbon::now();
        $created_at = $due_time->addHours(23);
        $output = $created_at->addMinutes(90);

        $result = $teHelper->willExpireAt($due_time, $created_at);

        $this->assertEquals($output->format('Y-m-d H:i:s'), $result);
    }

    /** @test */
    public function time_greater_than_24_and_less_than_equal_to_72()
    {
        $teHelper = new TeHelper();
        $due_time = Carbon::now();
        $created_at = $due_time->addHours(50);
        $output = $created_at->addHours(16);

        $result = $teHelper->willExpireAt($due_time, $created_at);

        $this->assertEquals($output->format('Y-m-d H:i:s'), $result);
    }
    
    /** @test */
    public function it_checks_if_date_time_is_in_correct_format()
    {
        $due_time = Carbon::now();
        $created_at = $due_time->addHours(91);

        $result = $teHelper->willExpireAt($due_time, $created_at);

        $this->assertDateTimeFormat($result, 'Y-m-d H:i:s');
    }
    
    protected function assertDateTimeFormat(Carbon $dateTime, $format)
    {
        $formattedDateTime = $dateTime->format($format);
        $this->assertSame($formattedDateTime, $dateTime->format($format));
    }

    protected function isParseableDateTime($dateTimeString)
    {
        try {
            Carbon::parse($dateTimeString);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}