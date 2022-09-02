<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class ReferralRequest extends Resource
{
  /**
   * Create a business user favorite review.
   *
   * @param array $params array of access request properties
   *   *
   * @return Object
   */
  public function create(array $params = []): Object
  {
    $path = 'referral-requests';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }
  /**
   * Delete a business user favorite review.
   *
   * @param mixed $id
   *
   * @return Object
   */
  public function delete($id): Object
  {
    $path = 'referral-requests/' . $id;

    return $this->client->request(
      'delete',
      $path
    );
  }
}
