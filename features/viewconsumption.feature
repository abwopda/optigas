Feature: view consumption
  Scenario: as an user i want to view an existing consumption
    Given i want to view an existing consumption
    When i load the view
    Then the consumption details are displayed