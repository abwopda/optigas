Feature: delete meter
  Scenario: as an administrator i want to delete an existing meter
    Given i want to delete an existing meter
    When i select the meter to delete
    Then the meter is no more available