Feature: invalidate purchaseorder
  Scenario: as a validator i want to invalidate an existing purchaseorder
    Given i want to invalidate an existing validated purchaseorder
    When i invalidate the purchaseorder
    Then the purchaseorder is invalidated and can be updated