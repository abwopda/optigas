Feature: update store
  Scenario: as an administrator i want to update an existing store
    Given i want to update an existing store
    When i update the store
    Then the store is updated