# Changelog

All notable changes to `laravel-quickpay` will be documented in this file.

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
