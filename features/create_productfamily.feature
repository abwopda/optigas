Feature: create productfamily
  Scenario: as an administrator i want to create a new productfamily
    Given i want to create a new productfamily
    When i fill the form
    Then the productfamily can be used