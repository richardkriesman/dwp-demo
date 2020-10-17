<?php


namespace App\Core\Time;


use DateTimeImmutable;
use DateTimeInterface;

/**
 * Concrete implementation of {@link TimeServiceInterface}.
 *
 * @package App\Core\Time
 */
final class TimeService implements TimeServiceInterface
{

    /**
     * @inheritDoc
     */
    public function formatForDisplay(DateTimeInterface $dateTime): string
    {
        $now = new DateTimeImmutable();
        $diff = ($now->getTimestamp() - $dateTime->getTimestamp());

        // use relative time if within 24 hours
        if ($diff < 86400) {
            return $this->relativeDifference($now, $dateTime);
        }

        // use day and month if within the same year
        $nowYear = intval($now->format('Y'));
        $otherYear = intval($dateTime->format('Y'));
        if ($nowYear == $otherYear) {
            return $dateTime->format('F j');
        }

        // use day, month, and year
        return $dateTime->format('F j, Y');
    }

    /**
     * @inheritDoc
     */
    public function relativeDifference(DateTimeInterface $dateTime1, DateTimeInterface $dateTime2): string
    {
        $diff = ($dateTime1->getTimestamp() - $dateTime2->getTimestamp());
        if ($diff < 60) { // within the past minute
            return 'just now';
        } else if ($diff <= 3600) { // within the past hour
            $minuteDiff = floor($diff / 60);
            if ($minuteDiff == 1) {
                return '1 minute ago';
            } else {
                return "{$minuteDiff} minutes ago";
            }
        } else { // after the past hour
            $hourDiff = floor($diff / 3600);
            if ($hourDiff == 1) {
                return '1 hour ago';
            } else {
                return "{$hourDiff} hours ago";
            }
        }
    }

}