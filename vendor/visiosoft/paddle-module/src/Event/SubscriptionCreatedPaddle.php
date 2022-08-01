<?php namespace Visiosoft\PaddleModule\Event;

class SubscriptionCreatedPaddle
{
    /**
     * @author Visiosoft LTD.
     */
    private $response;

    /**
     * SubscriptionCancelledPaddle constructor.
     * @param $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return json_decode($this->response, true);
    }
}
