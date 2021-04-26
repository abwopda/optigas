Feature: update pump
  Scenario: as an administrator i want to update an existing pump
    Given i want to update an existing pump
    When i update the pump
    Then the pump is updated