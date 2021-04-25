Feature: update purchasedelivery
  Scenario: as an administrator i want to update an existing purchasedelivery
    Given i want to update an existing unvalidated purchasedelivery
    When i fill the form
    Then the purchasedelivery is updated and waiting for validation