Feature: view company
  Scenario: as an user i want to view an existing company
    Given i want to view an existing company
    When i load the view
    Then the company details are displayed