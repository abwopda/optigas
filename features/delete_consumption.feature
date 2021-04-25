Feature: delete consumption
  Scenario: as an administrator i want to delete an existing consumption
    Given i want to delete a consumption
    When i select the consumption to delete
    Then the consumption is no more available