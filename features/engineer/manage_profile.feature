Feature: Manage profile
  In order to ensure that I can always perform my job role
  As an Engineer
  I want to make sure that my out of hours contact details are correct

  Background:
    Given there is an Engineer called "Bob"

  Scenario: Primary phone number can be updated
    Given that Bob has a primary phone number in his personal information
    When Bob changes his phone number
    Then the new primary phone number is updated
