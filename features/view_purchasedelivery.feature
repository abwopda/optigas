Feature: view purchasedelivery
  Scenario: as an user i want to view an existing purchasedelivery
    Given i want to view an existing purchasedelivery
    When i load the view
    Then the purchasedelivery details are displayed