Feature: create meter
  Scenario: as an administrator i want to create a new meter
    Given i want to create a new meter
    When i fill the form
    Then the meter can be used