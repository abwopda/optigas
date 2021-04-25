Feature: view pos
  Scenario: as an user i want to view an existing pos
    Given i want to view an existing pos
    When i load the view
    Then the pos details are displayed