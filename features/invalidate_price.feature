Feature: invalidate price
  Scenario: as a validator i want to invalidate an existing validated price
    Given i want to invalidate an existing validated price
    When i invalidate the price
    Then the price is invalidated and can be updated