<?php

namespace Bestcompany\BestcompanyApi\Util;

use JsonSerializable;
use Ramsey\Uuid\Type\Integer;

class WebhookEvent implements JsonSerializable
{
  /**
   * The key identifier for the event.
   *
   * @var string
   */
  public $key;

  /**
   * The name of the event.
   *
   * @var string
   */
  public $event;

  /**
   * The event's data.
   *
   * @var array
   */
  public $data;

  /**
   * The event's created time.
   *
   * @var string
   */
  public $created;

  /**
   * Create a new event instance.
   *
   * @param  string  $key
   * @param  string  $name
   * @param  array  $permissions
   * @return void
   */
  public function __construct(string $key, string $event, array $data, int $created)
  {
    $this->key = $key;
    $this->event = $event;
    $this->data = $data;
    $this->created = $created;
  }

  /**
   * Get the JSON serializable representation of the object.
   *
   * @return array
   */
  public function jsonSerialize(): array
  {
    return [
      'key' => $this->key,
      'event' => $this->event,
      'data' => $this->data,
      'created' => $this->created,
    ];
  }
}
