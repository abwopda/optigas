Feature: invalidate entry
  Scenario: as a validator i want to invalidate an existing entry
    Given i want to invalidate an existing validated entry
    When i invalidate the entry
    Then the entry is invalidated and can be updated