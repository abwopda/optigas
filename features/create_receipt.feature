Feature: create receipt
  Scenario: as an administrator i want to create a new receipt
    Given i want to create a new receipt
    When i fill the form
    Then the receipt can be used