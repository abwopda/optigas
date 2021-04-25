Feature: view exit
  Scenario: as an user i want to view an existing exit
    Given i want to view an existing exit
    When i load the view
    Then the exit details are displayed