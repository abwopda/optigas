Feature: update product
  Scenario: as an administrator i want to update an existing product
    Given i want to update an existing product
    When i update the product
    Then the product is updated