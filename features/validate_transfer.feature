Feature: validate transfer
  Scenario: as a validator i want to validate an existing unvalidated transfer
    Given i want to validate an existing unvalidated transfer
    When i validate the transfer
    Then the transfer is validated and cannot be updated