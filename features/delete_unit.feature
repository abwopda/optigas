Feature: delete unit
  Scenario: as an administrator i want to delete an existing unit
    Given i want to delete a unit
    When i select the unit to delete
    Then the unit is no more available