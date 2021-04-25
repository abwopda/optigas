Feature: create pos
  Scenario: as an administrator i want to create a new pos
    Given i want to create a new pos
    When i fill the form
    Then the pos can be used