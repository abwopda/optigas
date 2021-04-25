Feature: create invoice
  Scenario: as an administrator i want to create a new invoice
    Given i want to create a new invoice
    When i fill the form
    Then the invoice can be used