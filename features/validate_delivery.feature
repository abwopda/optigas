Feature: validate delivery
  Scenario: as a validator i want to validate an existing unvalidated delivery
    Given i want to validate an existing unvalidated delivery
    When i validate the delivery
    Then the delivery is validated and cannot be updated