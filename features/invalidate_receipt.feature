Feature: invalidate receipt
  Scenario: as a validator i want to invalidate an existing validated receipt
    Given i want to invalidate an existing validated receipt
    When i invalidate the receipt
    Then the receipt is invalidated and can be updated