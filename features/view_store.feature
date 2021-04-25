Feature: view store
  Scenario: as an user i want to view an existing store
    Given i want to view an existing store
    When i load the view
    Then the store details are displayed