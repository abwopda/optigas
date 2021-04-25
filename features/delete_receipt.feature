Feature: delete receipt
  Scenario: as an administrator i want to delete an existing receipt
    Given i want to delete an existing receipt
    When i select the receipt to delete
    Then the receipt is no more available