Feature: create transfer
  Scenario: as an administrator i want to create a new transfer
    Given i want to create a new transfer
    When i fill the form
    Then the transfer can be used