Feature: update company
  Scenario: as an administrator i want to update an existing company
    Given i want to update an existing company
    When i update the company
    Then the company is updated