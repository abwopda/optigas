Feature: delete store
  Scenario: as an administrator i want to delete an existing store
    Given i want to delete a store
    When i select the store to delete
    Then the store is no more available