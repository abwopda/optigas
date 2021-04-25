Feature: view purchaseorder
  Scenario: as an user i want to view an existing purchaseorder
    Given i want to view an existing purchaseorder
    When i load the view
    Then the purchaseorder details are displayed