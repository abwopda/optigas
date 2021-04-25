Feature: delete product
  Scenario: as an administrator i want to delete an existing product
    Given i want to delete a product
    When i select the product to delete
    Then the product is no more available