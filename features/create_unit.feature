Feature: create unit
  Scenario: as an administrator i want to create a new unit
    Given i want to create a new unit
    When i fill the form
    Then the unit can be used