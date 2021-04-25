Feature: inactivate pump
  Scenario: as an activator i want to inactivate an existing pump
    Given i want to inactivate a existing pump
    When i inactivate the pump
    Then the pump cannot be used