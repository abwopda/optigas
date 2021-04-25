Feature: inactivate store
  Scenario: as an activator i want to inactivate an existing store
    Given i want to inactivate a existing store
    When i inactivate the store
    Then the store cannot be used