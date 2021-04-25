Feature: inactivate pos
  Scenario: as an activator i want to inactivate an existing pos
    Given i want to inactivate a existing pos
    When i inactivate the pos
    Then the pos cannot be used