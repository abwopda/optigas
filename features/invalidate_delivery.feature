Feature: invalidate delivery
  Scenario: as a validator i want to invalidate an existing delivery
    Given i want to invalidate an existing validated delivery
    When i invalidate the delivery
    Then the delivery is invalidated and can be updated