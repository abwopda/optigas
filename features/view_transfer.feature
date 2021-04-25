Feature: view transfer
  Scenario: as an user i want to view an existing transfer
    Given i want to view an existing transfer
    When i load the view
    Then the transfer details are displayed