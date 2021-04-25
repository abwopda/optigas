Feature: update meter
  Scenario: as an administrator i want to update an existing unvalidated  meter
    Given i want to update an existing unvalidated meter
    When i fill the form
    Then the meter is updated and waiting for validation