Feature: delete entry
  Scenario: as an administrator i want to delete an existing entry
    Given i want to delete a entry
    When i select the entry to delete
    Then the entry is no more available