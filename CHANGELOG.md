# Changelog

All notable changes to `laravel-quickpay` will be documented in this file.

## [v0.3.0-alpha] - 2026-10-03

### Added
- Laravel 13 support.
- `Quickpay::callbacks()` verifies the `Quickpay-Checksum-Sha256` header of a callback with the private key of the account (`QUICKPAY_PRIVATE_KEY`).
- `QuickpayException` as the base class of every exception the package throws.
- A test suite covering the payment and subscription resources, plus static analysis with Larastan in CI.

### Fixed
- Every successful request threw `CardNotAccepted` when the application ran in `production`. It is now only thrown for a transaction made in test mode.
- The package config was never merged, so the package only worked after publishing the config. The `quickpay:install` command was never registered.
- `createPaymentSession()` did not send its payload.
- `Basket::toArray()` returned `BasketItem` objects instead of arrays.
- `SubscriptionRecurring::fromArray()` failed when `auto_capture` was left out.
- A response without a body caused a `TypeError`.
- The README used method names that do not exist (`createPaymentLink`, `session`, `createFraudReport`).

### Changed
- Requires PHP 8.3 and Laravel 12 or 13.
- All files declare strict types.
- The install command no longer copies a service provider into the application; the provider is auto-discovered.

## [v0.2.0-alpha] - 2025-04-23

### Added (Thanks, Anders Grønborg)
- Implemented Subscription Resource and comprehensive exception handling.
    - Updated `SubscriptionResource.php` with the following functions adjusted:
        - `all()`
        - `find()`
        - `createSubscriptionLink()`
        - `deletePaymentLink()`
        - `create()`
        - `update()`
        - `authorize()`
        - `cancel()`
        - `createRecurring()`
        - `fraudReport()`
        - `getPayments()`
    - Introduced dedicated exception classes for various subscription operations in ../Exceptions/Subscriptions:
        - `FetchSubscriptionFailed`
        - `FetchSubscriptionsFailed`
        - `CreateRecurringFailed`
        - `CreateSubscriptionFailed`
        - `CreateSubscriptionLinkFailed`
        - `DeletePaymentLinkFailed`
        - `UpdateSubscriptionFailed`
        - `AuthorizeSubscriptionFailed`
        - `CancelSubscriptionFailed`
        - `FraudReportSubscriptionFailed`
        - `GetSubscriptionPaymentsFailed`
    - Completed implementation of SubscriptionResource functions with API calls and integrated exception handling.
