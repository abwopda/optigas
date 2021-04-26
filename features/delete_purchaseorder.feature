Feature: delete purchaseorder
  Scenario: as an administrator i want to delete an existing purchaseorder
    Given i want to delete an existing purchaseorder
    When i select the purchaseorder to delete
    Then the purchaseorder is no more available