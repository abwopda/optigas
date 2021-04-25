Feature: invalidate transfer
  Scenario: as a validator i want to invalidate an existing validated transfer
    Given i want to invalidate an existing validated transfer
    When i invalidate the transfer
    Then the transfer is invalidated and can be updated