Feature: activate pos
  Scenario: as an activator i want to activate an existing pos
    Given i want to activate a existing pos
    When i activate the pos
    Then the pos can be used