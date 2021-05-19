Feature: create typeproduct
  Scenario: as an administrator i want to create a new typeproduct
    Given i want to create a new typeproduct
    When i fill the form
    Then the typeproduct can be used