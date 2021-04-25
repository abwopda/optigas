Feature: update consumption
  Scenario: as an administrator i want to update an existing consumption
    Given i want to update an existing consumption
    When i update the consumption
    Then the consumption is updated and waiting for validation