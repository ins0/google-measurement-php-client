<?php
namespace Racecore\GATracking;

/**
 * Abstract Class GATrackingTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking
 */
abstract class AbstractGATrackingTest extends \PHPUnit_Framework_TestCase
{
    protected function arraysAreSimilar($arrayOne, $arrayTwo)
    {
        if (count(array_diff_assoc($arrayOne, $arrayTwo))) {
            return false;
        }
        foreach ($arrayOne as $key => $val) {
            if ($val !== $arrayTwo[$key]) {
                return false;
            }
        }
        return true;
    }

    protected function assertArraysAreSimilar($arrayOne, $arrayTwo)
    {
        return $this->assertEquals(
            true,
            $this->arraysAreSimilar($arrayOne, $arrayTwo)
        );
    }
}
