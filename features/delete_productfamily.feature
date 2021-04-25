Feature: delete productfamily
  Scenario: as an administrator i want to delete an existing productfamily
    Given i want to delete a productfamily
    When i select the productfamily to delete
    Then the productfamily is no more available