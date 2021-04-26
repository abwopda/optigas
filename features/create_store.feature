Feature: create store
  Scenario: as an administrator i want to create a new store
    Given i want to create a new store
    When i fill the form
    Then the store can be used