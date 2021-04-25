Feature: update unit
  Scenario: as an administrator i want to update an existing unit
    Given i want to update an existing unit
    When i update the unit
    Then the unit is updated