Feature: invalidate consumption
  Scenario: as a validator i want to invalidate an existing consumption
    Given i want to invalidate an existing consumption
    When i invalidate the consumption
    Then the consumption is invalidated and can be updated