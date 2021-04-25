Feature: create exit
  Scenario: as an employee i want to create a new exit
    Given i want to create a new exit
    When i fill the form
    Then the exit is on pending and waiting for validation