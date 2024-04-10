<?php

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateDate($day, $month, $year)
{
    return checkdate($month, $day, $year);
}
