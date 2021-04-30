Feature: Register Contact
  Scenario: As an administrator I want to register a contact so that he can connect to the platform
    Given a contact need to be registered before using the platform
    When an administrator fill the registration form
    Then the contact can log in with the account created