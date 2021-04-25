Feature: view unit
  Scenario: as an user i want to view an existing unit
    Given i want to view an existing unit
    When i load the view
    Then the unit details are displayed