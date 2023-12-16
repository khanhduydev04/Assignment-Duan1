<?php

namespace MyApp;

use Message;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use User;

require dirname(__DIR__) . "/App/Models/db.php";
require dirname(__DIR__) . "/App/Models/UserModel.php";
require dirname(__DIR__) . "/App/Models/MessageModel.php";

class Chat implements MessageComponentInterface
{
  protected $clients;

  public function __construct()
  {
    $this->clients = new \SplObjectStorage;
    echo 'Sever started';
  }

  public function onOpen(ConnectionInterface $conn)
  {
    // Store the new connection to send messages to later
    $this->clients->attach($conn);

    $queryString = $conn->httpRequest->getUri()->getQuery();
    parse_str($queryString, $queryArray);
    $user = new User();
    $user_token = $queryArray['token'];
    $user_connection_id = $conn->resourceId;
    $user->updatetUserConnectionId($user_connection_id, $user_token);
    echo "New connection! ({$conn->resourceId})\n";
  }

  public function onMessage(ConnectionInterface $from, $msg)
  {
    $numRecv = count($this->clients) - 1;
    echo sprintf(
      'Connection %d sending message "%s" to %d other connection%s' . "\n",
      $from->resourceId,
      $msg,
      $numRecv,
      $numRecv == 1 ? '' : 's'
    );

    $user = new User();
    $message = new Message();
    $data = json_decode($msg, true);
    $message->saveChat($data['msg'], $data['userId'], $data['receiver_userId']);
    $sender_name = $user->getFullnameByUser($data['userId']);
    $receiver_data = $user->getUserById($data['receiver_userId']);

    foreach ($this->clients as $client) {
      if ($from == $client) {
        $data['from'] = 'Me';
      } else {
        $data['from'] = $sender_name;
      }
      if ($client->resourceId == $receiver_data['connection_id'] || $from == $client) {
        $client->send(json_encode($data));
      } else {
        var_dump($data);
      }
    }
  }

  public function onClose(ConnectionInterface $conn)
  {
    // The connection is closed, remove it, as we can no longer send it messages
    $this->clients->detach($conn);

    echo "Connection {$conn->resourceId} has disconnected\n";
  }

  public function onError(ConnectionInterface $conn, \Exception $e)
  {
    echo "An error has occurred: {$e->getMessage()}\n";

    $conn->close();
  }
}
