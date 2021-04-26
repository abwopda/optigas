Feature: view product
  Scenario: as an user i want to view an existing product
    Given i want to view an existing product
    When i load the view
    Then the product details are displayed