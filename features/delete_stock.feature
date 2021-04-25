Feature: delete stock
  Scenario: as an administrator i want to delete an existing stock
    Given i want to delete an existing stock
    When i select the stock to delete
    Then the stock is no more available