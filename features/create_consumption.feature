Feature: create consumption
  Scenario: as an employee i want to create a new consumption
    Given i want to create a new consumption
    When i fill the form
    Then the consumption is on pending and waiting for validation