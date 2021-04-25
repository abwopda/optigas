Feature: update exit
  Scenario: as an administrator i want to update an existing exit
    Given i want to update an existing exit
    When i update the exit
    Then the exit is updated and waiting for validation