Feature: invalidate purchasedelivery
  Scenario: as a validator i want to invalidate an existing purchasedelivery
    Given i want to invalidate an existing validated purchasedelivery
    When i invalidate the purchasedelivery
    Then the purchasedelivery is invalidated and can be updated