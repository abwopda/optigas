Feature: view productfamily
  Scenario: as an user i want to view an existing productfamily
    Given i want to view an existing productfamily
    When i load the view
    Then the productfamily details are displayed