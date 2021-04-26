Feature: invalidate invoice
  Scenario: as a validator i want to invalidate an existing validated invoice
    Given i want to invalidate an existing validated invoice
    When i invalidate the invoice
    Then the invoice is invalidated and can be updated