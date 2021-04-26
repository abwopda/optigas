Feature: update receipt
  Scenario: as an administrator i want to update an existing unvalidated receipt
    Given i want to update an existing unvalidated receipt
    When i fill the form
    Then the receipt is updated and waiting for validation