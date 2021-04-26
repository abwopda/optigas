Feature: create delivery
  Scenario: as an administrator i want to create a new delivery
    Given i want to create a new delivery
    When i fill the form
    Then the delivery can be used