Feature: create purchaseorder
  Scenario: as an administrator i want to create a new purchaseorder
    Given i want to create a new purchaseorder
    When i fill the form
    Then the purchaseorder can be used