Feature: inactivate productfamily
  Scenario: as an activator i want to inactivate an existing productfamily
    Given i want to inactivate a existing productfamily
    When i inactivate the productfamily
    Then the productfamily cannot be used