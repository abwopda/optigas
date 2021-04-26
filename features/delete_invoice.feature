Feature: delete invoice
  Scenario: as an administrator i want to delete an existing invoice
    Given i want to delete an existing invoice
    When i select the invoice to delete
    Then the invoice is no more available