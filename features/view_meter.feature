Feature: view meter
  Scenario: as an user i want to view an existing meter
    Given i want to view an existing meter
    When i load the view
    Then the meter details are displayed