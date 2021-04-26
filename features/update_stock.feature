Feature: update stock
  Scenario: as an administrator i want to update an existing unvalidated stock
    Given i want to update an existing unvalidated stock
    When i fill the form
    Then the stock is updated and waiting for validation