<?php

if(!function_exists('rangeNumber')){

    /**
     * Determines if $number is between $min and $max
     *
     * @param integer $number     The number to test
     * @param integer $min        The minimum value in the range
     * @param integer $max        The maximum value in the range
     * @param boolean $inclusive  Whether the range should be inclusive or not
     * @return boolean              Whether the number was in the range
     */
    function rangeNumber($number, $min, $max, bool $inclusive = FALSE): bool
    {
        if (is_int($number) && is_int($min) && is_int($max))
        {
            return $inclusive
                ? ($number >= $min && $number <= $max)
                : ($number > $min && $number < $max) ;
        }

        return FALSE;
    }

}
