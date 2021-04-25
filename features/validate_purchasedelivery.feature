Feature: validate purchasedelivery
  Scenario: as a validator i want to validate an existing unvalidated purchasedelivery
    Given i want to validate an existing unvalidated purchasedelivery
    When i validate the purchasedelivery
    Then the purchasedelivery is validated and cannot be updated