Feature: activate store
  Scenario: as an activator i want to activate an existing store
    Given i want to activate a existing store
    When i activate the store
    Then the store can be used