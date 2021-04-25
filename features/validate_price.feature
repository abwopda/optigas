Feature: validate price
  Scenario: as a validator i want to validate an existing unvalidated price
    Given i want to validate an existing unvalidated price
    When i validate the price
    Then the price is validated and cannot be updated