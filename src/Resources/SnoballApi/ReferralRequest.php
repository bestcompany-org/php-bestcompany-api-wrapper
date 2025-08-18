<?php

namespace Bestcompany\BestcompanyApi\Resources\SnoballApi;

use Bestcompany\BestcompanyApi\Resources\Resource;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\SnoballApi;

class ReferralRequest extends Resource
{
  /**
   * Get the Snoball API client instance
   */
  protected function getSnoballClient(): SnoballApi
  {
    return app(SnoballApi::class);
  }

  /**
   * Create a referral request.
   *
   * @param array $params array of referral request properties
   *
   * @return Object
   */
  public function create(array $params = []): Object
  {
    $path = 'referral-request';
    $snoballApi = $this->getSnoballClient();

    return $snoballApi->getClient()->request(
      'post',
      $path,
      ['json' => $params],
    );
  }

  /**
   * Delete a referral request.
   *
   * @param mixed $id
   *
   * @return Object
   */
  public function delete($id): Object
  {
    $path = 'referral-request/' . $id;
    $snoballApi = $this->getSnoballClient();

    return $snoballApi->getClient()->request(
      'delete',
      $path
    );
  }
}
