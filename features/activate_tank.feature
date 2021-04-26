Feature: activate tank
  Scenario: as an activator i want to activate an existing tank
    Given i want to activate a existing tank
    When i activate the tank
    Then the tank can be used