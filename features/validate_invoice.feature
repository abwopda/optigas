Feature: validate invoice
  Scenario: as a validator i want to validate an existing unvalidated invoice
    Given i want to validate an existing unvalidated invoice
    When i validate the invoice
    Then the invoice is validated and cannot be updated