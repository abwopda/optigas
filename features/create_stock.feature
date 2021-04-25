Feature: create stock
  Scenario: as an administrator i want to create a new stock
    Given i want to create a new stock
    When i fill the form
    Then the stock can be used