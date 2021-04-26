Feature: create price
  Scenario: as an administrator i want to create a new price
    Given i want to create a new price
    When i fill the form
    Then the price can be used