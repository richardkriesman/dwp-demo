<?php


namespace App\Core\Time;


use DateTime;

interface TimeServiceInterface
{

    /**
     * Formats a {@link DateTime} in a user-friendly format.
     *
     * If the difference between the specified time and the current time is less than 24 hours, the resultant string
     * will be a relative description produced using {@link TimeServiceInterface::relativeDifference()}.
     *
     * If the difference is greater than or equal to 24 hours but within the same year, the resultant string will
     * contain the day and month.
     *
     * If the none of the above are true, the resultant string will contain the day, month, and year.
     *
     * @param DateTime $dateTime
     * @return string
     */
    public function formatForDisplay(DateTime $dateTime): string;

    /**
     * Creates a user-friendly, relative description of the range of time between two {@link DateTime} instances.
     *
     * If the difference is less than 1 minute, "just now" will be returned.
     * If the difference is less than 1 hour, the number of minutes will be returned.
     * If the difference is greater than 1 hour, the number of hours will be returned.
     *
     * @param DateTime $dateTime1 The lower bound
     * @param DateTime $dateTime2 The upper bound
     * @return string Formatted string
     */
    public function relativeDifference(DateTime $dateTime1, DateTime $dateTime2): string;

}