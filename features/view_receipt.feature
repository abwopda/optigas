Feature: view receipt
  Scenario: as an user i want to view an existing receipt
    Given i want to view an existing receipt
    When i load the view
    Then the receipt details are displayed