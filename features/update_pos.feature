Feature: update pos
  Scenario: as an administrator i want to update an existing pos
    Given i want to update an existing pos
    When i update the pos
    Then the pos is updated