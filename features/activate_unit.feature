Feature: activate unit
  Scenario: as an activator i want to activate an existing unit
    Given i want to activate a existing unit
    When i activate the unit
    Then the unit can be used