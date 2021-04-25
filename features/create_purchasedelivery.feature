Feature: create purchasedelivery
  Scenario: as an administrator i want to create a new purchasedelivery
    Given i want to create a new purchasedelivery
    When i fill the form
    Then the purchasedelivery can be used