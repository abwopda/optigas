Feature: activate productfamily
  Scenario: as an activator i want to activate an existing productfamily
    Given i want to activate a existing productfamily
    When i activate the productfamily
    Then the productfamily can be used