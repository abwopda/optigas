Feature: validate typeproduct
  Scenario: as a validator i want to validate an existing unvalidated typeproduct
    Given i want to validate an existing unvalidated typeproduct
    When i validate the typeproduct
    Then the typeproduct is validated and cannot be updated