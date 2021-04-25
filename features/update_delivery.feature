Feature: update delivery
  Scenario: as an administrator i want to update an existing delivery
    Given i want to update an existing unvalidated delivery
    When i fill the form
    Then the delivery is updated and waiting for validation