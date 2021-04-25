Feature: update transfer
  Scenario: as an administrator i want to update an existing unvalidated transfer
    Given i want to update an existing unvalidated transfer
    When i fill the form
    Then the transfer is updated and waiting for validation