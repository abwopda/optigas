Feature: delete delivery
  Scenario: as an administrator i want to delete an existing delivery
    Given i want to delete an existing delivery
    When i select the delivery to delete
    Then the delivery is no more available