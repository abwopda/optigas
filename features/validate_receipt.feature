Feature: validate receipt
  Scenario: as a validator i want to validate an existing unvalidated receipt
    Given i want to validate an existing unvalidated receipt
    When i validate the receipt
    Then the receipt is validated and cannot be updated