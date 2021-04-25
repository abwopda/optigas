Feature: delete company
  Scenario: as an administrator i want to delete an existing company
    Given i want to delete a company
    When i select the company to delete
    Then the company is no more available