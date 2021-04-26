Feature: inactivate product
  Scenario: as an activator i want to inactivate an existing product
    Given i want to inactivate a existing product
    When i inactivate the product
    Then the product cannot be used