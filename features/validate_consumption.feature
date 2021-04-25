Feature: validate consumption
  Scenario: as a validator i want to validate an existing consumption
    Given i want to validate an existing consumption
    When i validate the consumption
    Then the consumption is validated and cannot be updated