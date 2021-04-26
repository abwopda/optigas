Feature: validate stock
  Scenario: as a validator i want to validate an existing unvalidated stock
    Given i want to validate an existing unvalidated stock
    When i validate the stock
    Then the stock is validated and cannot be updated