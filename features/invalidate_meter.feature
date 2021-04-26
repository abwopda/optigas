Feature: invalidate meter
  Scenario: as a validator i want to invalidate an existing validated meter
    Given i want to invalidate an existing validated meter
    When i invalidate the meter
    Then the meter is invalidated and can be updated