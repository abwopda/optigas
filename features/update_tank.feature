Feature: update tank
  Scenario: as an administrator i want to update an existing tank
    Given i want to update an existing tank
    When i update the tank
    Then the tank is updated