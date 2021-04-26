Feature: inactivate tank
  Scenario: as an activator i want to inactivate an existing tank
    Given i want to inactivate a existing tank
    When i inactivate the tank
    Then the tank cannot be used