Feature: view typeproduct
  Scenario: as an user i want to view an existing typeproduct
    Given i want to view an existing typeproduct
    When i load the view
    Then the typeproduct details are displayed