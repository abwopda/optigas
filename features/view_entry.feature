Feature: view entry
  Scenario: as an user i want to view an existing entry
    Given i want to view an existing entry
    When i load the view
    Then the entry details are displayed