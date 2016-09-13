<?php
namespace NexmoDemo;

/**
 * Convert value objects into spoken words.
 */
trait TalkTrait
{
    protected function talkStatus($status)
    {
        switch($status){
            case 'shipped':
                return 'has been shipped';
            case 'pending':
                return 'is still pending';
            case 'backordered':
                return 'is backordered';
            default:
                return 'can not be located at this time';
        }
    }

    protected function talkDate(\DateTime $date)
    {
        return $date->format('l F jS');
    }

    protected function talkCharacters($string)
    {
        return implode(' ', str_split($string));
    }
}