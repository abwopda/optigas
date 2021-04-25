Feature: delete purchasedelivery
  Scenario: as an administrator i want to delete an existing purchasedelivery
    Given i want to delete an existing purchasedelivery
    When i select the purchasedelivery to delete
    Then the purchasedelivery is no more available