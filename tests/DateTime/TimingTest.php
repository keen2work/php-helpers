<?php


use EMedia\PHPHelpers\DateTime\Timing;

class TimingTest extends \PHPUnit\Framework\TestCase
{


    /**
     * @test
     */
    public function test_Timing_getTimezones_returns_array()
    {
        $this->assertTrue(is_array(Timing::getTimezones()));
    }

    /**
     * @test
     */
    public function test_Timing_getTimezones_returns_location()
    {
        $this->assertEquals('Australia/Sydney', Timing::getTimezones()['(UTC+10:00) Sydney']);
    }


    /**
     * @test
     */
    public function test_Timing_timezoneSelector_generates_a_timezone_selector_with_placeholder()
    {
        $id = "foo";
        $name = "my-select";
        $placeholderText = "Select a timezone";
        $attributeName = 'aria-label';
        $optionLabel = "timezone option";

        $selectWithPlaceholder = Timing::timezoneSelector(null, $placeholderText, ['name' => $name, 'id' => $id], [$attributeName => $optionLabel]);

        $dom = new DOMDocument();
        $dom->loadHTML($selectWithPlaceholder);
        $xpath = new DOMXpath($dom);

        $select = $xpath->query("//select")[0];
        $this->assertEquals($name, $select->attributes->getNamedItem('name')->value);
        $this->assertEquals($id, $select->attributes->getNamedItem('id')->value);

        $placeholder = $xpath->query("//option[@disabled]");
        $this->assertEquals($placeholderText, ($placeholder[0])->nodeValue);

        $options = $xpath->query("//option");
        $this->assertEquals($optionLabel, $options[1]->attributes->getNamedItem($attributeName)->value);
    }

    /**
     * @test
     */
    public function test_Timing_timezoneSelector_generates_a_timezone_selector_with_selected()
    {
        $placeholderText = "Select a timezone";

        $timezoneValue = '(UTC+10:00) Melbourne';
        $timezoneLabel = Timing::getTimezones()[$timezoneValue];

        $selectWithPlaceholder = Timing::timezoneSelector($timezoneLabel, $placeholderText);

        $dom = new DOMDocument();
        $dom->loadHTML($selectWithPlaceholder);
        $xpath = new DOMXpath($dom);

        $placeholder = $xpath->query("//option[@disabled]");
        $this->assertCount(0, $placeholder);

        $selected = $xpath->query("//option[@selected]");
        $this->assertCount(1, $selected);
        $this->assertEquals($timezoneValue, $selected[0]->nodeValue);
    }

    /**
     * @test
     */
    public function test_Timing_timezoneSelector_generates_a_timezone_selector_with_default_attributes()
    {
        $defaultSelectName = "timezone";
        $defaultId = 'timezone';
        $selectWithPlaceholder = Timing::timezoneSelector(null, "");

        $dom = new DOMDocument();
        $dom->loadHTML($selectWithPlaceholder);
        $xpath = new DOMXpath($dom);

        $select = $xpath->query("//select")[0];

        $this->assertEquals($defaultSelectName, $select->attributes->getNamedItem('name')->value);
        $this->assertEquals($defaultId, $select->attributes->getNamedItem('id')->value);
    }

    /** 
     * @test
     */
    public function test_Timing_microTimestamp_unqiue()
    {
        $this->assertNotEquals(Timing::microTimestamp(), Timing::microTimestamp());
    }

    /**
     * @test
     */
    public function test_Timing_microTimestamp_is_today_date()
    {
        $date = explode('.', Timing::microTimestamp())[0];
        $parsed = date_parse_from_format("Y_m_d_His", $date);

        $now = date_parse(date('Y-m-d'));

        $this->assertEquals($now["year"], $parsed["year"]);
        $this->assertEquals($now["month"], $parsed["month"]);
        $this->assertEquals($now["day"], $parsed["day"]);
    }

    /**
     * @test
     */
    public function test_Timing_convertToDbTime_parses_words_into_date_time()
    {
        $format = 'Y-m-d H:i:s';
        $now = new DateTime();
        $args = [
            'now' =>  date($format),
            '16 March 2020' => '2020-03-16 00:00:00',
            '+1 day' => $now->modify('+ 1 day')->format($format),
            'next monday' => $now->modify('next monday')->format($format),
        ];

        foreach ($args as $arg => $result) {
            $this->assertEquals($result, Timing::convertToDbTime($arg));
        }
    }

    /**
     * @test
     */
    public function test_Timing_convertToDbTime_parses_with_whitespace()
    {
        $now = date('Y-m-d H:i:s');
        $this->assertEquals("${now}", Timing::convertToDbTime("${now}      "));
    }

    /**
     * @test
     */
    public function test_Timing_convertToDbTime_accepts_date_without_time()
    {
        $now = date('Y-m-d');
        $this->assertEquals("${now} 00:00:00", Timing::convertToDbTime($now));
    }


    /**
     * @test
     */
    public function test_Timing_convertToDbTime_returns_epoch_on_invalid_values()
    {
        $invalidValues = [
            'foo',
            '',
            null,
            0
        ];
        foreach ($invalidValues as $value) {
            $this->assertEquals("1970-01-01 00:00:00", Timing::convertToDbTime(":"));
        }
    }

    /**
     * @test
     * @throws Exception
     */
    public function test_timing_convertFromUTC_converts_from_utc_time_to_given_timezone_time()
    {
        $format = 'Y-m-d H:i:s';
        $melb = "Australia/Melbourne";
        $utcTime = gmdate($format);
        $converted = Timing::convertFromUTC($utcTime, $melb);
        $melbTime = (new DateTime("now", new DateTimeZone($melb) ))->format($format);

        $this->assertEquals($melbTime, $converted);
    }

    /**
     * @test
     * @throws Exception
     */
    public function test_timing_convertToUTC_converts_to_utc_time_from_given_timezone_time()
    {
        $format = 'Y-m-d H:i:s';
        $melb = "Australia/Melbourne";

        $melbTime = (new DateTime("now", new DateTimeZone($melb) ))->format($format);
        $utcTime = gmdate($format);

        $converted = Timing::convertToUTC($melbTime, $melb, $format);

        $this->assertEquals($utcTime, $converted);
    }

    /**
     * @test
     * @throws Exception
     */
    public function test_timing_toUTCTimezone_sets_timezone_to_UTC()
    {
        $format = 'Y-m-d H:i:s';
        $melb = "Australia/Melbourne";

        $melbTime = (new DateTime("now", new DateTimeZone($melb) ));

        $converted = Timing::toUTCTimezone($melbTime->format($format));

        $this->assertNotEquals($melbTime->getTimezone()->getName(), $converted->timezone->getName());
    }

}