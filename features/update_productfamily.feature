Feature: update productfamily
  Scenario: as an administrator i want to update an existing productfamily
    Given i want to update an existing productfamily
    When i update the productfamily
    Then the productfamily is updated