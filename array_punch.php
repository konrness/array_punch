<?php
/**
 * Challenge Yourselph - 011
 *
 * Array Punch
 *   This weeks challenge (from Eddie Pfremmer, team Bacon) is a little open ended and abstract.
 *   Provide your interpretation of what a native PHP function array_punch should do.
 *
 * Usage: php kness.php
 *
 * @author Konr Ness <konr.ness@gmail.com>
 */

/**
 * Punch one or more elements onto the end of array.
 *
 * array_punch is very similar to array_push, however a punch is much more forceful
 * than a push, therefore the added elements get stuffed at the second to the last position
 * of the input array.
 *
 * @param array $array The input array.
 * @param mixed $vars The pushed value.
 * @param mixed ... [optional] Additional pushed values
 * @return int the new number of elements in the array.
 */
function array_punch(&$array = null, ...$vars)
{
    if (is_null($array) || count($vars) == 0) {
        trigger_error("array_punch() expects at least 2 parameters, 0 given", E_USER_WARNING);
    }

    if (! is_array($array)) {
        switch (true) {
            case is_int($array):
                trigger_error("array_punch() expects parameter 1 to be array, integer given", E_USER_WARNING);
                break;
            case is_string($array):
                trigger_error("array_punch() expects parameter 1 to be array, string given", E_USER_WARNING);
                break;
            default:
                trigger_error("array_punch() expects parameter 1 to be array", E_USER_WARNING);
                break;
        }
    }

    // retrieve the last element so it can be added back later
    // cannot just use array_pop because we need to also retrieve the key
    $lastElement = array_slice($array, -1, true);
    array_pop($array);

    if (! is_null($vars)) {
        foreach ($vars as $var) {
            array_push($array, $var);
        }
    }

    // put the last element back on
    if (! empty($lastElement)) {

        $lastElementKeys = array_keys($lastElement);
        $lastElementKey  = array_pop($lastElementKeys);

        $lastElementValues = array_values($lastElement);
        $lastElementValue  = array_pop($lastElementValues);

        if (is_int($lastElementKey)) {
            // key was numeric, do not reset it
            array_push($array, $lastElementValue);
        } else {
            $array[$lastElementKey] = $lastElementValue;
        }
    }

    return count($array);
}