Feature: delete pos
  Scenario: as an administrator i want to delete an existing pos
    Given i want to delete a pos
    When i select the pos to delete
    Then the pos is no more available