Feature: validate exit
  Scenario: as a validator i want to validate an existing exit
    Given i want to validate an existing exit
    When i validate the exit
    Then the exit is validated and cannot be updated