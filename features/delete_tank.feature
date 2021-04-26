Feature: delete tank
  Scenario: as an administrator i want to delete an existing tank
    Given i want to delete a tank
    When i select the tank to delete
    Then the tank is no more available