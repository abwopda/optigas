Feature: inactivate unit
  Scenario: as an activator i want to inactivate an existing unit
    Given i want to inactivate a existing unit
    When i inactivate the unit
    Then the unit cannot be used