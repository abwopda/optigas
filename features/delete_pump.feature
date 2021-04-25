Feature: delete pump
  Scenario: as an administrator i want to delete an existing pump
    Given i want to delete a pump
    When i select the pump to delete
    Then the pump is no more available