<?php

namespace App\Websockets\Controller;

use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class TestWebsocketController implements \Ratchet\WebSocket\MessageComponentInterface
{

    /**
     * @inheritDoc
     */
    function onOpen(ConnectionInterface $conn)
    {
        Log::debug("connect");
    }

    /**
     * @inheritDoc
     */
    function onClose(ConnectionInterface $conn)
    {
        Log::debug("close");
    }

    /**
     * @inheritDoc
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        // TODO: Implement onMessage() method.
    }
}
