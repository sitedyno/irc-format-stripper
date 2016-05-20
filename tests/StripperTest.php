<?php
/**
 * Strip IRC formatting codes from a string
 *
 * @link https://github.com/sitedyno/irc-format-stripper
 * @copyright Copyright (c) 2016- Sitedyno https://github.com/sitedyno
 * @license https://opensource.org/licenses/MIT
 * @package Sitedyno\Irc\Format
 */

namespace Sitedyno\Irc\Format\Tests;

use PHPUnit_Framework_TestCase;
use Sitedyno\Irc\Format\Stripper;

class StripperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        $this->stripper = new Stripper;
    }

    /**
     * Easy replacements provider
     */
    public function easyReplacementsProvider()
    {
        yield ["\x02bold", "bold"];
        yield ["\x09italic", "italic"];
        yield ["\x09italic \x0Fnot italic", "italic not italic"];
        yield ["\x16reverse", "reverse"];
        yield ["\x13strikethrough", "strikethrough"];
        yield ["\x1Funderline", "underline"];
    }

    /**
     * Test strip function with easy replacements
     *
     * @dataProvider easyReplacementsProvider
     */
    public function testStripEasyReplacements($message, $result)
    {
        $this->assertSame($this->stripper->strip($message), $result);
    }

    /**
     * no comma provider
     */
    public function noCommaProvider()
    {
        yield ["\x031black", "black"];
        yield ["\x032blue", "blue"];
        yield ["\x0301black", "black"];
        yield ["\x0302blue", "blue"];
    }

    /**
     * Test strip with no comma
     *
     * @dataProvider noCommaProvider
     */
    public function testStripNoComma($message, $result)
    {
        $this->assertSame($this->stripper->strip($message), $result);
    }

    /**
     * Comma as first character provider
     */
    public function commaAsFirstCharacterProvider()
    {
        yield ["\x03,default", ",default"];
        yield ["\x03,4default over red", "default over red"];
        yield ["\x03,04default over red", "default over red"];
    }

    /**
     * Test strip function with comma as first character
     *
     * @dataProvider commaAsFirstCharacterProvider
     */
    public function testStripCommaAsFirstCharacter($message, $result)
    {
        $this->assertSame($this->stripper->strip($message), $result);
    }

    /**
     * Comma as second character provider
     */
    public function commaAsSecondCharacterProvider()
    {
        yield ["\x032,blue", ",blue"];
        yield ["\x032,4blue over red", "blue over red"];
        yield ["\x032,04blue over red", "blue over red"];
        yield ["\x032,b4blue", ",b4blue"];
    }

    /**
     * Test strip function with comma as second character
     *
     * @dataProvider commaAsSecondCharacterProvider
     */
    public function testStripCommaAsSecondCharacter($message, $result)
    {
        $this->assertSame($this->stripper->strip($message), $result);
    }

    /**
     * Comma as third character provider
     */
    public function commaAsThirdCharacterProvider()
    {
        yield ["\x0301,black", ",black"];
        yield ["\x0301,4black over red", "black over red"];
        yield ["\x0301,04black over red", "black over red"];
        yield ["\x0302,04blue over red", "blue over red"];
        yield ["\x0399,99client dependent", "client dependent"];
        yield ["\x0399,b9client dependent", ",b9client dependent"];
    }

    /**
     * Test strip function
     *
     * @dataProvider commaAsThirdCharacterProvider
     */
    public function testStripCommaAsThirdCharacter($message, $result)
    {
        $this->assertSame($this->stripper->strip($message), $result);
    }
}
