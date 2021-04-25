Feature: create pump
  Scenario: as an administrator i want to create a new pump
    Given i want to create a new pump
    When i fill the form
    Then the pump can be used