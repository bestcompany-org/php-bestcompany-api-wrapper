<?php

namespace Bestcompany\BestcompanyApi\Enums;

use Bestcompany\BestcompanyApi\Exceptions\SnoballApiException;

/**
 * Stable machine-readable error codes returned by the Snoball internal API.
 *
 * The backing value is the wire format sent in the `error.code` field of an
 * error response. Consumers should switch on these cases rather than matching
 * on the human-readable `message`, which is not stable.
 *
 * Any code not recognised by this enum (e.g. one added server-side before the
 * SDK is upgraded) resolves to null via {@see self::tryFrom()}; treat unknown
 * codes as not user-safe.
 */
enum SnoballApiErrorCode: string
{
    /** The company does not have the referrals module subscription. */
    case SubscriptionRequired = 'SUBSCRIPTION_REQUIRED';

    /** The company has reached its annual referral request limit. */
    case ReferralLimitReached = 'REFERRAL_LIMIT_REACHED';

    /** The recipient number is on the do-not-contact list. */
    case DoNotContact = 'DO_NOT_CONTACT';

    /** The recipient number cannot receive SMS (e.g. landline, invalid). */
    case SmsUndeliverable = 'SMS_UNDELIVERABLE';

    /** The referring sales rep or requesting user could not be resolved. */
    case RepResolutionFailed = 'REP_RESOLUTION_FAILED';

    /** Request payload failed validation; see {@see SnoballApiException::fieldErrors()}. */
    case ValidationFailed = 'VALIDATION_FAILED';

    /** The referenced company could not be found. */
    case CompanyNotFound = 'COMPANY_NOT_FOUND';

    /** An unexpected server-side error occurred. */
    case UnexpectedError = 'UNEXPECTED_ERROR';
}
