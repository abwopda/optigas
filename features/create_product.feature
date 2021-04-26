Feature: create product
  Scenario: as an administrator i want to create a new product
    Given i want to create a new product
    When i fill the form
    Then the product can be used