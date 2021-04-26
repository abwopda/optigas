Feature: activate pump
  Scenario: as an activator i want to activate an existing pump
    Given i want to activate a existing pump
    When i activate the pump
    Then the pump can be used