Feature: validate entry
  Scenario: as a validator i want to validate an existing unvalidated entry
    Given i want to validate an existing unvalidated entry
    When i validate the entry
    Then the entry is validated and cannot be updated