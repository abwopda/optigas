Feature: validate meter
  Scenario: as a validator i want to validate an existing unvalidated meter
    Given i want to validate an existing unvalidated meter
    When i validate the meter
    Then the meter is validated and cannot be updated