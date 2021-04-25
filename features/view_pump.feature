Feature: view pump
  Scenario: as an user i want to view an existing pump
    Given i want to view an existing pump
    When i load the view
    Then the pump details are displayed