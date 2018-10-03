<?php

/**
 * @param $current
 * @param $expected
 * @return string
 */
function selected($current, $expected)
{
    return $current === $expected ? 'selected' : '';
}
