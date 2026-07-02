<?php

namespace Bestcompany\BestcompanyApi\Resources\SnoballApi;

use Bestcompany\BestcompanyApi\Exceptions\SnoballApiException;
use Bestcompany\BestcompanyApi\Resources\Resource;
use Bestcompany\BestcompanyApi\SnoballApi;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

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
     * @param  array  $params  array of referral request properties
     *
     * @throws SnoballApiException when the API returns a 4xx/5xx response;
     *                             inspect the structured error to decide what to surface
     */
    public function create(array $params = []): object
    {
        $path = 'referral-request';
        $snoballApi = $this->getSnoballClient();

        try {
            return $snoballApi->getClient()->request(
                'post',
                $path,
                ['json' => $params],
            );
        } catch (ClientException|ServerException $e) {
            throw SnoballApiException::fromGuzzle($e);
        }
    }

    /**
     * Delete a referral request.
     *
     * @param  mixed  $id
     */
    public function delete($id): object
    {
        $path = 'referral-request/'.$id;
        $snoballApi = $this->getSnoballClient();

        return $snoballApi->getClient()->request(
            'delete',
            $path
        );
    }
}
