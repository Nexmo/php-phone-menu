<?php
namespace NexmoDemo;


class Ivr
{
    use TemplateTrait;
    use TalkTrait;
    use NccoTrait;

    /**
     * @var Orders
     */
    protected $orders;

    /**
     * Caller
     * @var string
     */
    protected $from;

    /**
     * App Config
     * @var array
     */
    protected $config;


    public function __construct(Orders $orders, $config, $request)
    {
        $this->orders = $orders;

        if(isset($request['from'])){
            $this->from   = preg_replace("/[^0-9]/", "", $request['from']);
        }

        $this->config = $config;
    }

    public function answerAction()
    {
        $this->sayHello();

        //if they have a recent order, ask about it
        if($order = $this->orders->findOneByNumber($this->from) AND $order['date'] > new \DateTime('-1 week')){
            $this->promptRecent($order);
            return;
        }

        $this->promptSearch();
    }

    public function recentAction($request = null)
    {
        if(!isset($request['dtmf'])){
            $this->answerAction();
            return;
        }

        switch($request['dtmf']){
            case '1':
                if($order = $this->orders->findOneByNumber($this->from)){
                    $this->sayOrder($order)
                         ->sayGoodby();
                } else {
                    $this->promptSearch();
                }
                break;
            case '2':
                $this->listOrders($this->orders->findAllByNumber($this->from));
                break;
            case '3':
            default:
                $this->promptSearch();
                break;
        }
    }

    public function searchAction($request = null)
    {
        if(!isset($request['dtmf'])){
            $this->promptSearch();
        } else if(!$order = $this->orders->findOneById($request['dtmf'])){
            $this->sayNotFound()
                 ->promptSearch();
        } else {
            $this->sayOrder($order);
            $this->sayGoodby();
        }
    }

    public function __call($name, $arguments)
    {
        $this->sayNotFound();
    }
}