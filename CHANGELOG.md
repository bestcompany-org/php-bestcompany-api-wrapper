# Changelog

All notable changes to `bestcompany-api` will be documented in this file

## Unreleased

## 1.0.0 - 2026-07-01

First release under strict [SemVer](https://semver.org/) — see CONTRIBUTING for the versioning policy. Consolidates everything released since 0.10.0 as the stable baseline.

- Added structured error handling for `SnoballApi::referralRequest()->create()`. 4xx/5xx responses now throw a typed `Bestcompany\BestcompanyApi\Exceptions\SnoballApiException` carrying a machine-readable `Bestcompany\BestcompanyApi\Enums\SnoballApiErrorCode`, a `user_safe` flag, an optional end-user `display_message`, and per-field validation errors — so consumers can decide what to surface without string-matching. Responses without the envelope degrade gracefully (null code, not user-safe). Other resources are unchanged.

## 0.10.0 - 2026-03-11

- Added `ReviewSubmitted` resource to SnoballApi

## 0.9.0 - 2026-02-04

- Added `RepConversation` resource to SnoballApi

## 0.8.1 - 2025-01-XX

- Fixed `RepMessage` resource naming (renamed from SalesRepReferral)

## 0.8.0 - 2025-01-XX

- Added Laravel 12 compatibility

## 0.7.0 - 2024-XX-XX

- Added new resources for Bestcompany API
- Removed deprecated resources

## 1.0.0 - 201X-XX-XX

- initial release
