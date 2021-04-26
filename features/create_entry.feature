Feature: create entry
  Scenario: as an employee i want to create a new entry
    Given i want to create a new entry
    When i fill the form
    Then the entry is on pending and waiting for validation