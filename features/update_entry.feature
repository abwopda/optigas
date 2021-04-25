Feature: update entry
  Scenario: as an administrator i want to update an existing entry
    Given i want to update an existing unvalidated entry
    When i update the entry
    Then the entry is updated and waiting for validation