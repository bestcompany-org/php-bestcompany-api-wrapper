<?php

namespace Bestcompany\BestcompanyApi\Exceptions;

use Bestcompany\BestcompanyApi\Enums\SnoballApiErrorCode;
use GuzzleHttp\Exception\RequestException;
use RuntimeException;
use Throwable;

/**
 * Thrown when a Snoball internal API request returns a 4xx/5xx response.
 *
 * Carries the structured error envelope so consumers can decide, without
 * string-matching, whether an error is safe to surface to an end user:
 *
 *   try {
 *       $rr = SnoballApi::referralRequest()->create($params);
 *   } catch (SnoballApiException $e) {
 *       if ($e->hasFieldErrors()) {
 *           return back()->withErrors($e->fieldErrors());   // map onto the form
 *       }
 *       if ($e->isUserSafe()) {
 *           return back()->with('error', $e->displayMessage());
 *       }
 *       report($e);
 *       return back()->with('error', 'Something went wrong — please contact support.');
 *   }
 *
 * Responses that predate the structured envelope degrade gracefully: errorCode()
 * is null, isUserSafe() is false, and getMessage() falls back to the raw body.
 */
class SnoballApiException extends RuntimeException
{
    /**
     * @param  int  $statusCode  HTTP status code of the response
     * @param  SnoballApiErrorCode|null  $errorCode  parsed machine-readable code, null if unknown/absent
     * @param  bool  $userSafe  whether displayMessage is safe to show an end user
     * @param  string|null  $displayMessage  end-user-facing message, when the server marks one user-safe
     * @param  array<string, array<int, string>>  $fieldErrors  per-field validation errors, keyed by input name
     * @param  object|null  $body  the decoded response body, for logging/inspection
     */
    public function __construct(
        string $message,
        private readonly int $statusCode,
        private readonly ?SnoballApiErrorCode $errorCode = null,
        private readonly bool $userSafe = false,
        private readonly ?string $displayMessage = null,
        private readonly array $fieldErrors = [],
        private readonly ?object $body = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * Build the exception from a Guzzle client/server exception, parsing the
     * structured error envelope from the response body when present.
     */
    public static function fromGuzzle(RequestException $e): self
    {
        $response = $e->getResponse();
        $statusCode = $response?->getStatusCode() ?? 0;
        $body = $response ? json_decode((string) $response->getBody()) : null;

        $error = is_object($body) && isset($body->error) && is_object($body->error) ? $body->error : null;

        $errorCode = is_object($error) && isset($error->code) && is_string($error->code)
            ? SnoballApiErrorCode::tryFrom($error->code)
            : null;

        $userSafe = (bool) ($error->user_safe ?? false);
        $displayMessage = isset($error->display_message) && is_string($error->display_message)
            ? $error->display_message
            : null;

        $fieldErrors = [];
        if (is_object($body) && isset($body->errors) && is_object($body->errors)) {
            $fieldErrors = array_map(
                static fn ($messages): array => (array) $messages,
                (array) $body->errors,
            );
        }

        $message = is_object($body) && isset($body->message) && is_string($body->message)
            ? $body->message
            : $e->getMessage();

        return new self(
            message: $message,
            statusCode: $statusCode,
            errorCode: $errorCode,
            userSafe: $userSafe,
            displayMessage: $displayMessage,
            fieldErrors: $fieldErrors,
            body: $body,
            previous: $e,
        );
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function errorCode(): ?SnoballApiErrorCode
    {
        return $this->errorCode;
    }

    /**
     * Whether the server marked this error's message safe to show an end user.
     */
    public function isUserSafe(): bool
    {
        return $this->userSafe;
    }

    /**
     * The end-user-facing message when user-safe, otherwise null.
     */
    public function displayMessage(): ?string
    {
        return $this->userSafe ? $this->displayMessage : null;
    }

    public function hasFieldErrors(): bool
    {
        return $this->fieldErrors !== [];
    }

    /**
     * Per-field validation errors keyed by input name.
     *
     * @return array<string, array<int, string>>
     */
    public function fieldErrors(): array
    {
        return $this->fieldErrors;
    }

    /**
     * The decoded response body, for logging or inspecting fields not modelled here.
     */
    public function body(): ?object
    {
        return $this->body;
    }
}
