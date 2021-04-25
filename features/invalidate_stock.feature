Feature: invalidate stock
  Scenario: as a validator i want to invalidate an existing validated stock
    Given i want to invalidate an existing validated stock
    When i invalidate the stock
    Then the stock is invalidated and can be updated