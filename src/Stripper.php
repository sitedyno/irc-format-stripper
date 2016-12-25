<?php
/**
 * Strip IRC formatting codes from a string
 *
 * @link https://github.com/sitedyno/irc-format-stripper
 * @copyright Copyright (c) 2016 Heath Nail https://github.com/sitedyno
 * @license https://opensource.org/licenses/MIT
 * @package Sitedyno\Irc\Format
 */

namespace Sitedyno\Irc\Format;

class Stripper
{
    /**
     * Bold code
     *
     * @string
     */
    protected $bold = "\x02";

    /**
     * Color code
     *
     * @string
     */
    protected $color = "\x03";

    /**
     * Italic code
     *
     * @string
     */
    protected $italic = "\x09";

    /**
     * Reset code
     *
     * @string
     */
    protected $reset = "\x0F";

    /**
     * Reverse code
     *
     * @string
     */
    protected $reverse = "\x16";

    /**
     * Strikethrough code
     *
     * @string
     */
    protected $strikethrough = "\x13";

    /**
     * Underline code
     *
     * @string
     */
    protected $underline = "\x1F";

    /**
     * Holds replaceable codes for easy iteration
     *
     * @array
     */
    protected $replaceableCodes = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->replaceableCodes = [
            $this->bold,
            $this->italic,
            $this->reset,
            $this->reverse,
            $this->strikethrough,
            $this->underline
        ];
    }

    /**
     * Strips IRC format codes from a string
     *
     * @param string $message An IRC message
     * @return string The stripped IRC message
     */
    public function strip($message)
    {
        $message = str_replace($this->replaceableCodes, '', $message);
        if (strpos($message, $this->color) !== false) {
            $split = str_split($message);
            foreach ($split as $i => $char) {
                if ($char === $this->color) {
                    $first  = $i + 1;
                    $second = $i + 2;
                    $third  = $i + 3;
                    $fourth = $i + 4;
                    $fifth  = $i + 5;
                    $split[$i] = '';
                    if (isset($split[$first]) && isset($split[$second])) {
                        if (is_numeric($split[$first]) && is_numeric($split[$second])) {
                            $split[$first] = $split[$second] = '';
                            if (isset($split[$third]) && "," === $split[$third]) {
                                if (isset($split[$fourth]) && is_numeric($split[$fourth])) {
                                    $split[$third] = '';
                                    $split[$fourth] = '';
                                    if (isset($split[$fifth]) && is_numeric($split[$fifth])) {
                                        $split[$fifth] = '';
                                    }
                                }
                            }
                        }
                    }
                    if (isset($split[$first]) && is_numeric($split[$first])) {
                        $split[$first] = '';
                        if (isset($split[$second]) && "," === $split[$second]) {
                            if (isset($split[$third]) && is_numeric($split[$third])) {
                                $split[$second] = '';
                                $split[$third] = '';
                                if (isset($split[$fourth]) && is_numeric($split[$fourth])) {
                                    $split[$fourth] = '';
                                }
                            }
                        }
                    }
                    if (isset($split[$first]) && "," === $split[$first]) {
                        if (isset($split[$second]) && is_numeric($split[$second])) {
                            $split[$first] = '';
                            $split[$second] = '';
                            if (isset($split[$third]) && is_numeric($split[$third])) {
                                $split[$third] = '';
                            }
                        }
                    }
                }
            }
            $message = implode($split);
        }
        return $message;
    }
}
