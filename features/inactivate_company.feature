Feature: inactivate company
  Scenario: as an activator i want to inactivate an existing company
    Given i want to inactivate a existing company
    When i inactivate the company
    Then the company cannot be used