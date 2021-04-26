Feature: create tank
  Scenario: as an administrator i want to create a new tank
    Given i want to create a new tank
    When i fill the form
    Then the tank can be used