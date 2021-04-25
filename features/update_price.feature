Feature: update price
  Scenario: as an administrator i want to update an existing unvalidated price
    Given i want to update an existing unvalidated price
    When i fill the form
    Then the price is updated and waiting for validation