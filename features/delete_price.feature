Feature: delete price
  Scenario: as an administrator i want to delete an existing price
    Given i want to delete an existing price
    When i select the price to delete
    Then the price is no more available