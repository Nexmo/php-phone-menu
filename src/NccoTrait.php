<?php
namespace NexmoDemo;

/**
 * Simple container for NCCO stack.
 */
trait NccoTrait
{
    /**
     * The NCCO Stack
     * @var array
     */
    protected $ncco = [];

    public function getStack()
    {
        return $this->ncco;
    }

    protected function append($ncco)
    {
        array_push($this->ncco, $ncco);
    }

    protected function prepend($ncco)
    {
        array_unshift($this->ncco, $ncco);
    }
}