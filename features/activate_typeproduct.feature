Feature: activate typeproduct
  Scenario: as an activator i want to activate an existing typeproduct
    Given i want to activate a existing typeproduct
    When i activate the typeproduct
    Then the typeproduct can be used