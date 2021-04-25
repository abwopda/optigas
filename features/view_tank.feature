Feature: view tank
  Scenario: as an user i want to view an existing tank
    Given i want to view an existing tank
    When i load the view
    Then the tank details are displayed