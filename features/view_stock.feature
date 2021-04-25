Feature: view stock
  Scenario: as an user i want to view an existing stock
    Given i want to view an existing stock
    When i load the view
    Then the stock details are displayed