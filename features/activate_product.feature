Feature: activate product
  Scenario: as an activator i want to activate an existing product
    Given i want to activate a existing product
    When i activate the product
    Then the product can be used