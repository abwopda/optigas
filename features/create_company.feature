Feature: create company
  Scenario: as an administrator i want to create a new company
    Given i want to create a new company
    When i fill the form
    Then the company can be used