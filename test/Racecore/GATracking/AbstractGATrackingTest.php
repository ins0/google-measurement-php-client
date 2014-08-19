<?php
namespace Racecore\GATracking;

/**
 * Abstract Class GATrackingTest
 *
 * @author      Marco Rieger
 * @package       Racecore\GATracking
 */
abstract class AbstractGATrackingTest extends \PHPUnit_Framework_TestCase {

    /**
    * Determine if two associative arrays are similar
    *
    * Both arrays must have the same indexes with identical values
    * without respect to key ordering
    *
    * @param array $a
    * @param array $b
    * @return bool
    */
    function arrays_are_similar($a, $b) {
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }
        foreach($a as $k => $v) {
            if ($v !== $b[$k]) {
                return false;
            }
        }
        return true;
    }

    /**
     * Tests if two Arrays are Similar
     *
     * @param $a
     * @param $b
     * @return mixed
     */
    function assertArraySimilar($a, $b) {
        return $this->assertEquals(
            true,
            $this->arrays_are_similar($a, $b)
        );
    }
}