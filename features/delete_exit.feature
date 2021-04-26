Feature: delete exit
  Scenario: as an administrator i want to delete an existing exit
    Given i want to delete a exit
    When i select the exit to delete
    Then the exit is no more available