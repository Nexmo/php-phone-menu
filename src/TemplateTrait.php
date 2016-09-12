<?php


namespace NexmoDemo;


trait TemplateTrait
{
    protected function sayHello()
    {
        $this->append([
            'action' => 'talk',
            'text' => 'Thanks for calling our order status hotline.'
        ]);

        return $this;
    }

    protected function sayGoodby()
    {
        $this->append([
            'action' => 'talk',
            'text' => "Thank you, good by."
        ]);

        return $this;
    }

    protected function sayOrder($order)
    {
        $this->append([
            'action' => 'talk',
            'text' => "Your order placed on {$this->talkDate($order['date'])} {$this->talkStatus($order['status'])}."
        ]);

        $this->append([
            'action' => 'talk',
            'text' => "The total cost is {$order['total']}"
        ]);

        return $this;
    }

    protected function sayNotFound()
    {
        $this->append([
            'action' => 'talk',
            'text' => 'Sorry, we can not find that option.'
        ]);

        return $this;
    }

    protected function listOrders($orders)
    {
        foreach($orders as $order){
            $this->append([
                'action' => 'talk',
                'text' => "Enter {$this->talkCharacters($order['id'])} for your order placed on {$this->talkDate($order['date'])}"
            ]);
        }

        $this->append([
            'action' => 'input',
            'eventUrl' => [$this->config['base_path'] . '/search']
        ]);

    }

    protected function promptSearch()
    {
        $this->append([
            'action' => 'talk',
            'text' => 'Using the numbers on your phone, enter your order number followed by the pound sign'
        ]);

        $this->append([
            'action' => 'input',
            'eventUrl' => [$this->config['base_path'] . '/search'],
            'timeOut' => '10',
            'submitOnHash' => true
        ]);

        return $this;
    }

    protected function promptRecent($order)
    {
        $this->append([
            'action' => 'talk',
            'text' => 'Press 1 if you would like to get the status of your order placed on ' . $this->talkDate($order['date'])
        ]);

        $this->append([
            'action' => 'talk',
            'text' => 'Press 2 if you would like to list your recent orders'
        ]);

        $this->append([
            'action' => 'talk',
            'text' => 'Press 3 to enter an order i d'
        ]);

        $this->append([
            'action' => 'input',
            'maxDigits' => '1',
            'eventUrl' => [$this->config['base_path'] . '/recent?' . http_build_query(['from' => $this->from])]
        ]);
    }
}