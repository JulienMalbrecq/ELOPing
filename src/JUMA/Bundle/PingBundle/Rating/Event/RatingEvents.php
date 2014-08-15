<?php


namespace JUMA\Bundle\PingBundle\Rating\Event;


final class RatingEvents
{
    const BEFORE_PERSIST = 'juma_ping.rating.before_persist';
    const BEFORE_RATING = 'juma_ping.rating.before_rating';
    const AFTER_RATING = 'juma_ping.rating.after_rating';
}