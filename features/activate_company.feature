Feature: activate company
  Scenario: as an activator i want to activate an existing company
    Given i want to activate a existing company
    When i activate the company
    Then the company can be used