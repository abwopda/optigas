Feature: update invoice
  Scenario: as an administrator i want to update an existing unvalidated invoice
    Given i want to update an existing unvalidated invoice
    When i fill the form
    Then the invoice is updated and waiting for validation