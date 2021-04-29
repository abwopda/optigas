Feature: Register Employee
  Scenario: As an administrator I want to register an employee so that he can connect to the platform
    Given an employee need to be registered before using the platform
    When an administrator fill the registration form
    Then the employee can log in with the account created