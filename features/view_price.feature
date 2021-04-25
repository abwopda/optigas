Feature: view price
  Scenario: as an user i want to view an existing price
    Given i want to view an existing price
    When i load the view
    Then the price details are displayed