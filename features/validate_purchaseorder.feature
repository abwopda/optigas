Feature: validate purchaseorder
  Scenario: as a validator i want to validate an existing unvalidated purchaseorder
    Given i want to validate an existing unvalidated purchaseorder
    When i validate the purchaseorder
    Then the purchaseorder is validated and cannot be updated