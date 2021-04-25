Feature: view invoice
  Scenario: as an user i want to view an existing invoice
    Given i want to view an existing invoice
    When i load the view
    Then the invoice details are displayed