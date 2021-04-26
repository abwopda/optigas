Feature: update purchaseorder
  Scenario: as an administrator i want to update an existing purchaseorder
    Given i want to update an existing unvalidated purchaseorder
    When i fill the form
    Then the purchaseorder is updated and waiting for validation