Feature: delete transfer
  Scenario: as an administrator i want to delete an existing transfer
    Given i want to delete an existing transfer
    When i select the transfer to delete
    Then the transfer is no more available