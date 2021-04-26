Feature: invalidate exit
  Scenario: as a validator i want to invalidate an existing exit
    Given i want to invalidate an existing exit
    When i invalidate the exit
    Then the exit is invalidated and can be updated