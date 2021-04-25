Feature: view delivery
  Scenario: as an user i want to view an existing delivery
    Given i want to view an existing delivery
    When i load the view
    Then the delivery details are displayed